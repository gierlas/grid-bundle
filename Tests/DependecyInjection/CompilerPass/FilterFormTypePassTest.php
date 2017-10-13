<?php

namespace Kora\GridBundle\Tests\DependecyInjection\CompilerPass;

use Kora\GridBundle\DependencyInjection\CompilerPass\FilterFormTypePass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FilterFormTypePassTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class FilterFormTypePassTest extends AbstractCompilerPassTestCase
{
	protected function registerCompilerPass(ContainerBuilder $container)
	{
		$container->addCompilerPass(new FilterFormTypePass());
	}

	/**
	 * @expectedException \Kora\GridBundle\DependencyInjection\CompilerPass\Exception\FormTypeRequireFilterException
	 */
	public function testFilterRequired()
	{
		$filterServiceName = 'foo';
		$formBuilderDefinition = new Definition();
		$this->setDefinition(FilterFormTypePass::FILTER_FORM_BUILDER_NAME, $formBuilderDefinition);

		$missingFilterDefinition = new Definition();
		$missingFilterDefinition
			->addTag(FilterFormTypePass::FILTER_FORM_TAG, []);

		$this->setDefinition($filterServiceName, $missingFilterDefinition);

		$this->compile();
	}

	public function testFilterFormAdded()
	{
		$filterServiceName = 'foo';
		$filterName = 'bar';

		$formBuilderDefinition = new Definition();
		$this->setDefinition(FilterFormTypePass::FILTER_FORM_BUILDER_NAME, $formBuilderDefinition);

		$missingFilterDefinition = new Definition();
		$missingFilterDefinition
			->addTag(FilterFormTypePass::FILTER_FORM_TAG, ['filter' => $filterName]);

		$this->setDefinition($filterServiceName, $missingFilterDefinition);

		$this->compile();

		$this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
			FilterFormTypePass::FILTER_FORM_BUILDER_NAME, 'addFormFilterType',
			[$filterName, new Reference($filterServiceName)]
		);
	}
}
