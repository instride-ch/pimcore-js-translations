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
 * @copyright  Copyright (c) 2016-2019 w-vision AG (https://www.w-vision.ch)
 * @license    https://github.com/w-vision/PimcoreJsTranslationBundle/blob/master/LICENSE GNU General Public License version 3 (GPLv3)
 */

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Dumper;

use Symfony\Component\Translation\Dumper\XliffFileDumper;
use Symfony\Component\Translation\MessageCatalogueInterface;

class PimcoreWebsiteTranslationDumper implements PimcoreTranslationDumperInterface
{
    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var string
     */
    private $domainName;

    /**
     * @var XliffFileDumper
     */
    private $xliffFileDumper;

    /**
     * @param string $defaultLocale
     * @param string $domainName
     * @param XliffFileDumper $xliffFileDumper
     */
    public function __construct(string $defaultLocale, string $domainName, XliffFileDumper $xliffFileDumper)
    {
        $this->defaultLocale = $defaultLocale;
        $this->domainName = $domainName;
        $this->xliffFileDumper = $xliffFileDumper;
    }

    /**
     * {@inheritdoc}
     */
    public function dump(MessageCatalogueInterface $catalog): string
    {
        return $this->xliffFileDumper->formatCatalogue($catalog, $this->domainName, [
            'default_locale' => $this->defaultLocale,
            'xliff_version' => '2.0',
        ]);
    }
}
