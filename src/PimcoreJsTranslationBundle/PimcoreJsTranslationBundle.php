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

namespace Instride\Bundle\PimcoreJsTranslationBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

class PimcoreJsTranslationBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    /**
     * {@inheritdoc}
     */
    public function getNiceName(): string
    {
        return 'Pimcore JavaScript Translations';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'A pretty nice way to expose your Pimcore shared translation messages to your client applications.';
    }

    /**
     * {@inheritdoc}
     */
    protected function getComposerPackageName(): string
    {
        return 'instride/pimcore-js-translation';
    }
}
