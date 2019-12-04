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

namespace Wvision\Bundle\PimcoreJsTranslationBundle\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
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

        $this->registerDumperConfiguration($container, $mergedConfigs['dumper']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function registerDumperConfiguration(ContainerBuilder $container, array $config): void
    {
        // Default Locale
        $container->setParameter('pimcore_js_translation.dumper.default_locale', $config['default_locale']);

        // Domain Name
        $container->setParameter('pimcore_js_translation.dumper.domain_name', $config['domain_name']);
    }
}
