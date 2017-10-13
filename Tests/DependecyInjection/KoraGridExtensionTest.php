<?php

namespace Kora\GridBundle\Tests\DependecyInjection;

use Kora\GridBundle\DependencyInjection\KoraGridExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class KoraGridExtensionTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class KoraGridExtensionTest extends AbstractExtensionTestCase
{
	/**
	 * @return array
	 */
	protected function getContainerExtensions()
	{
		return [
			new KoraGridExtension()
		];
	}

	/**
	 * @dataProvider addTwigParameterProvider
	 * @param $config
	 * @param $expectedValue
	 */
	public function testAddTwigParameter($config, $expectedValue)
	{
		$this->load($config);

		$this->assertContainerBuilderHasParameter(KoraGridExtension::CONFIG_KEY, $expectedValue);
	}

	public function addTwigParameterProvider()
	{
		$types = [
			'test' => 'test'
		];

		return [
			[[], []],
			[['twig' => ['types' => $types]], $types]
		];
	}
}
