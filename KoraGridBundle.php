<?php

namespace Kora\GridBundle;

use Kora\GridBundle\DependencyInjection\CompilerPass\TwigPass;
use Kora\GridBundle\DependencyInjection\CompilerPass\FilterFormTypePass;
use Kora\GridBundle\DependencyInjection\KoraGridExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;


/**
 * Class KoraGridBundle
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class KoraGridBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new TwigPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 100);
		$container->addCompilerPass(new FilterFormTypePass());
	}


	/**
	 * @inheritdoc
	 */
	public function getContainerExtension()
	{
		if (null === $this->extension) {
			$this->extension = new KoraGridExtension();
		}

		return $this->extension;
	}
}