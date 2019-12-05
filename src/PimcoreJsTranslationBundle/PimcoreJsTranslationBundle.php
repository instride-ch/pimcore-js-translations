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

namespace Wvision\Bundle\PimcoreJsTranslationBundle;

use CoreShop\Bundle\ResourceBundle\AbstractResourceBundle;
use CoreShop\Bundle\ResourceBundle\CoreShopResourceBundle;
use Pimcore\Extension\Bundle\Installer\InstallerInterface;
use Pimcore\Extension\Bundle\PimcoreBundleInterface;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Wvision\Bundle\PimcoreJsTranslationBundle\Installer\PimcoreTranslationInstaller;

class PimcoreJsTranslationBundle extends AbstractResourceBundle implements PimcoreBundleInterface
{
    use PackageVersionTrait;

    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers(): array
    {
        return [
            CoreShopResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

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
        return 'w-vision/pimcore-js-translation-bundle';
    }

    /**
     * {@inheritdoc}
     */
    public function getInstaller(): ?InstallerInterface
    {
        return $this->container->get(PimcoreTranslationInstaller::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminIframePath()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getJsPaths(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getCssPaths(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getEditmodeJsPaths(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getEditmodeCssPaths(): array
    {
        return [];
    }
}
