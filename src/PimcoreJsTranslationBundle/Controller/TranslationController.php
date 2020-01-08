<?php
/**
 * Pimcore JavaScript Translations.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright Copyright (c) 2020 w-vision AG (https://www.w-vision.ch)
 * @license   https://github.com/w-vision/PimcoreJsTranslationBundle/blob/master/LICENSE GNU General Public License version 3 (GPLv3)
 */

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Controller;

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

    /**
     * @var string
     */
    private $environment;

    /**
     * @var int
     */
    private $httpCacheTime;

    /**
     * @var string
     */
    private $localeFallback;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @param string      $environment
     * @param int         $httpCacheTime
     * @param string      $localeFallback
     * @param Environment $twig
     */
    public function __construct(string $environment, int $httpCacheTime, string $localeFallback, Environment $twig)
    {
        $this->environment = $environment;
        $this->httpCacheTime = $httpCacheTime;
        $this->localeFallback = $localeFallback;
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @param string  $format
     *
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getTranslationsAction(Request $request, string $format): Response
    {
        $locales = $this->getLocales($request);

        if (0 === count($locales)) {
            throw new NotFoundHttpException();
        }

        $translations = [];

        $translationList = new Translation\Website\Listing();
        $translationList->setOrderKey('key');
        $translationList->setOrder('asc');
        $translationList->load();

        foreach ($locales as $locale) {
            $translations[$locale] = [];

            foreach ($translationList->getTranslations() as $translation) {
                $content = $translation->getTranslation($locale);

                if (!$content) {
                    continue;
                }

                $translations[$locale][$translation->getKey()] = $content;
            }
        }

        $content = $this->twig->render('@PimcoreJsTranslation/getTranslations.' . $format . '.twig', [
            'fallback' => $this->localeFallback,
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
        $response->setETag(md5((string) $response->getContent()));
        $response->isNotModified($request);
        $response->setExpires($expirationTime);

        return $response;
    }

    /**
     * Get the locale from the request by default.
     *
     * @param Request $request
     *
     * @return array
     */
    private function getLocales(Request $request): array
    {
        if (null !== $locales = $request->query->get('locales')) {
            $locales = explode(',', $locales);
        } else {
            $locales = [$request->getLocale()];
        }

        $locales = array_filter($locales, static function ($locale) {
            return 1 === preg_match('/^[a-z]{2,3}([-_][a-zA-Z]{2})?$/', $locale);
        });

        $locales = array_unique(array_map(static function ($locale) {
            return trim($locale);
        }, $locales));

        return $locales;
    }
}
