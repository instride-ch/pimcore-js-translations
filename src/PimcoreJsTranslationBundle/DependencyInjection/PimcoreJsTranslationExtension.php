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

namespace Wvision\Bundle\PimcoreJsTranslationBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class PimcoreJsTranslationExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function loadInternal(array $mergedConfigs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $this->registerConfiguration($container, $mergedConfigs);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function registerConfiguration(ContainerBuilder $container, array $config): void
    {
        // Locale Fallback
        $container->setParameter('pimcore_js_translation.locale_fallback', $config['locale_fallback']);

        // HTTP Cache Time
        $container->setParameter('pimcore_js_translation.http_cache_time', $config['http_cache_time']);
    }
}
