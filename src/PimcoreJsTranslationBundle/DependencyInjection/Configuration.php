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

use Symfony\Component\Config\Definition\Builder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): Builder\TreeBuilder
    {
        $treeBuilder = new Builder\TreeBuilder('pimcore_js_translation');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->addDefaultsIfNotSet()
            ->info('Configuration of the Pimcore JavaScript Translation bundle.')
            ->children()

                // Default Locale
                ->scalarNode('default_locale')
                    ->info('The source language from which the translations are made.')
                    ->defaultValue('en')
                ->end()

                // Domain Name
                ->scalarNode('domain_name')
                    ->info('The name of the translation domain used for Pimcore translations.')
                    ->defaultValue('pimcore')
                ->end()

            ->end();

        return $treeBuilder;
    }
}
