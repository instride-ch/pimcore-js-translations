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

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Loader;

use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\MessageCatalogue;

class XliffTranslationLoader implements TranslationLoaderInterface
{
    /**
     * @var string
     */
    private $domainName;

    /**
     * @var XliffFileLoader
     */
    private $xliffFileLoader;

    /**
     * @param string          $domainName
     * @param XliffFileLoader $xliffFileLoader
     */
    public function __construct(string $domainName, XliffFileLoader $xliffFileLoader)
    {
        $this->domainName = $domainName;
        $this->xliffFileLoader = $xliffFileLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function load(string $resource, string $locale): MessageCatalogue
    {
        return $this->xliffFileLoader->load($resource, $locale, $this->domainName);
    }
}
