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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('pimcore_js_translation');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->addDefaultsIfNotSet()
            ->info('Configuration of the Pimcore JavaScript Translation bundle.')
            ->children()

                // Locale Fallback
                ->scalarNode('locale_fallback')
                    ->info('The fallback language for non-existent translations.')
                    ->defaultValue('en')
                ->end()

                // HTTP Cache Time
                ->integerNode('http_cache_time')
                    ->info('The amount of seconds the translation content is cached.')
                    ->defaultValue(86400)
                ->end()

            ->end();

        return $treeBuilder;
    }
}
