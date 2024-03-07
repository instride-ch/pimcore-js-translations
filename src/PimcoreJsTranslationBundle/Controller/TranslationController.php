<?php

declare(strict_types=1);

/**
 * Pimcore JavaScript Translations.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright 2024 instride AG (https://instride.ch)
 * @license   https://github.com/instride-ch/PimcoreJsTranslationBundle/blob/main/LICENSE GNU General Public License version 3 (GPLv3)
 */

namespace Instride\Bundle\PimcoreJsTranslationBundle\Controller;

use Carbon\Carbon;
use MatthiasMullie\Minify;
use Pimcore\Model\Translation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TranslationController
{
    private const FORMAT_JAVASCRIPT = 'js';

    public function __construct(
        private readonly string $environment,
        private readonly int $httpCacheTime,
        private readonly string $localeFallback,
        private readonly Environment $twig
    ) {}

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getTranslationsAction(Request $request, string $format): Response
    {
        $locales = $this->getLocales($request);

        if (0 === \count($locales)) {
            throw new NotFoundHttpException();
        }

        $translations = [];

        $translationList = new Translation\Listing();
        $translationList->setOrderKey('key');
        $translationList->setOrder('asc');
        $translationList->load();

        $defaultDomain = 'messages';

        foreach ($locales as $locale) {
            $translations[$locale][$defaultDomain] = [];

            foreach ($translationList->getTranslations() as $translation) {
                if ($translation->hasTranslation($locale)) {
                    $content = $translation->getTranslation($locale);
                }

                if (!$content) {
                    continue;
                }

                $translations[$locale][$defaultDomain][$translation->getKey()] = $content;
            }
        }

        $content = $this->twig->render('@PimcoreJsTranslation/getTranslations.' . $format . '.twig', [
            'fallback' => $this->localeFallback,
            'defaultDomain' => $defaultDomain,
            'translations' => $translations,
        ]);

        if ('prod' === $this->environment && self::FORMAT_JAVASCRIPT === $format) {
            $minifier = new Minify\JS($content);
            $content = $minifier->minify();
        }

        $expirationTime = Carbon::now()->addSeconds($this->httpCacheTime);
        $response = new Response(
            $content,
            200,
            ['Content-Type' => $request->getMimeType($format)]
        );
        $response->prepare($request);
        $response->setPublic();
        $response->setETag(\md5((string) $response->getContent()));
        $response->isNotModified($request);
        $response->setExpires($expirationTime);

        return $response;
    }

    /**
     * Get the locale from the request by default.
     */
    private function getLocales(Request $request): array
    {
        if (null !== $locales = $request->query->get('locales')) {
            $locales = \explode(',', $locales);
        } else {
            $locales = [$request->getLocale()];
        }

        $locales = \array_filter(
            $locales,
            static fn ($locale) => 1 === \preg_match('/^[a-z]{2,3}([-_][a-zA-Z]{2})?$/', $locale)
        );

        return \array_unique(\array_map(static fn ($locale) => \trim($locale), $locales));
    }
}
