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

namespace Instride\Bundle\PimcoreJsTranslationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class PimcoreJsTranslationExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $this->registerConfiguration($container, $mergedConfig);
    }

    private function registerConfiguration(ContainerBuilder $container, array $config): void
    {
        // Locale Fallback
        $container->setParameter('pimcore_js_translation.locale_fallback', $config['locale_fallback']);

        // HTTP Cache Time
        $container->setParameter('pimcore_js_translation.http_cache_time', $config['http_cache_time']);
    }
}
