<?php

namespace Kora\GridBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Kora\GridBundle\Twig\ResultDisplayExtension;


/**
 * Class TwigPass
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class TwigPass implements CompilerPassInterface
{
	//- [ 'addType', ['date', 'AppAdminBundle:Analytics:date.html.twig'] ]

	const TWIG_EXTENSION_NAME = 'kora_grid.twig_extension';

	public function process(ContainerBuilder $container)
	{
		//Skip if twig is not loaded
		if (false === $container->hasDefinition('twig')) {
			return;
		}

		$definition = new Definition(ResultDisplayExtension::class);
		$definition->addTag('twig.extension');

		$container->setDefinition(self::TWIG_EXTENSION_NAME, $definition);
	}

}