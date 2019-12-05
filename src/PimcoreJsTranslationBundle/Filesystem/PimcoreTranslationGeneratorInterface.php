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

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Filesystem;

use Generator;
use InvalidArgumentException;
use OutOfRangeException;
use Pimcore\Model\Translation\AbstractTranslation;

interface PimcoreTranslationGeneratorInterface
{
    /**
     * Generates translation files for all passed Pimcore translations.
     *
     * @param AbstractTranslation[] $translations
     *
     * @return Generator|null
     *
     * @throws InvalidArgumentException
     */
    public function generate(array $translations): ?Generator;

    /**
     * Looks for translation files and removes them.
     *
     * @param string|null $locale
     */
    public function cleanupTranslationFiles(string $locale = null): void;

    /**
     * Writes a specific Pimcore translation in all languages to translation files.
     *
     * @param AbstractTranslation $translation
     *
     * @throws OutOfRangeException
     */
    public function update(AbstractTranslation $translation): void;

    /**
     * Removes a specific Pimcore translation in all languages from translation files.
     *
     * @param AbstractTranslation $translation
     *
     * @throws OutOfRangeException
     */
    public function remove(AbstractTranslation $translation): void;
}
