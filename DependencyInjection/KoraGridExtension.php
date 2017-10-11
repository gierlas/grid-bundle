<?php

namespace Kora\GridBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;


/**
 * Class KoraGridExtension
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class KoraGridExtension extends Extension implements ExtensionInterface
{
	public function load(array $configs, ContainerBuilder $container)
	{
		$config = $this->processConfiguration(new Configuration(), $configs);

		$loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$loader->load('services.xml');

	}

	public function getAlias()
	{
		return 'kora_grid';
	}
}