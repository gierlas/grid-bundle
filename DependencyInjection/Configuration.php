<?php

namespace Kora\GridBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


/**
 * Class Configuration
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('kora_grid');

		$rootNode
			->children()
				->arrayNode('twig')
					->addDefaultsIfNotSet()
					->children()
						->arrayNode('types')
							->useAttributeAsKey('id')
							->prototype('scalar');


		return $treeBuilder;
	}
}