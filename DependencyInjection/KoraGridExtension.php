<?php

namespace Kora\GridBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;


/**
 * Class KoraGridExtension
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class KoraGridExtension extends Extension
{
	const CONFIG_KEY = 'kora_grid.twig.types';

	public function load(array $configs, ContainerBuilder $container)
	{
		$config = $this->processConfiguration(new Configuration(), $configs);

		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$loader->load('services.yml');

		$types = $config['twig']['types'] ?? [];
		$container
			->getParameterBag()
			->set(self::CONFIG_KEY, $types);
	}

	public function getAlias()
	{
		return 'kora_grid';
	}
}