<?php

namespace Kora\GridBundle\Tests\DependecyInjection\CompilerPass;

use Kora\GridBundle\DependencyInjection\CompilerPass\TwigPass;
use Kora\GridBundle\DependencyInjection\KoraGridExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Mockery as m;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Class TwigPassTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class TwigPassTest extends AbstractCompilerPassTestCase
{
	use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

	protected function registerCompilerPass(ContainerBuilder $container)
	{
		$container->addCompilerPass(new TwigPass());
	}

	public function testServiceNotAddedWhenTwigNotAvailable()
	{
		$this->compile();
		$this->assertContainerBuilderNotHasService(TwigPass::TWIG_EXTENSION_NAME);
	}

	public function testServiceAddedWhenTwigAvailable()
	{
		$types = [
			'foo' => 'bar',
			'asdf' => 'asdf'
		];

		$definition = new Definition();
		$this->setDefinition('twig', $definition);
		$this->setParameter(KoraGridExtension::CONFIG_KEY, $types);

		$this->compile();

		$this->assertContainerBuilderHasService(TwigPass::TWIG_EXTENSION_NAME);

		foreach ($types as $type => $template) {
			$this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
				TwigPass::TWIG_EXTENSION_NAME, 'addType', [$type, $template]
			);
		}
	}
}
