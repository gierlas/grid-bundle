<?php

namespace Kora\Grid\Symfony\Tests\FormBuilder;

use Kora\DataProvider\DataProviderOperatorsSetup;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\Grid\Symfony\FormBuilder\FilterFormTypeInterface;
use Kora\Grid\Symfony\FormBuilder\FormBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormBuilder as SymfonyFormBuilder;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormBuilderTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class FormBuilderTest extends TestCase
{
	/**
	 * @expectedException \Kora\Grid\Symfony\FormBuilder\Exception\CannotGuessFormTypeException
	 */
	public function testCannotGuessException()
	{
		$formFactory = $this->getMockBuilder(FormFactory::class)
			->disableOriginalConstructor()
			->getMock();

		$filter = $this->getMockBuilder(FilterOperatorDefinitionInterface::class)
			->getMock();

		$dataProviderSetup = new DataProviderOperatorsSetup();
		$dataProviderSetup
			->addFilter($filter);

		$formBuilder = new FormBuilder($formFactory);

		$formBuilder->buildForm($dataProviderSetup);
	}

	public function testGuessFormType()
	{
		$formBuilder = $this->getMockBuilder(SymfonyFormBuilder::class)
			->disableOriginalConstructor()
			->getMock();

		$formBuilder
			->method('getForm')
			->willReturn($this->getMockBuilder(FormInterface::class)->getMock());

		$formFactory = $this->getMockBuilder(FormFactory::class)
			->disableOriginalConstructor()
			->getMock();

		$formFactory
			->method('createNamedBuilder')
			->willReturn($formBuilder);

		$filter = $this->getMockBuilder(FilterOperatorDefinitionInterface::class)
			->getMock();

		$filterFormType = $this->getMockBuilder(FilterFormTypeInterface::class)
			->getMock();

		$filterFormType
			->expects($this->once())
			->method('addToBuilder');

		$dataProviderSetup = new DataProviderOperatorsSetup();
		$dataProviderSetup
			->addFilter($filter);

		$formBuilder = new FormBuilder($formFactory);
		$formBuilder
			->addFormFilterType(get_class($filter), $filterFormType);

		$formBuilder->buildForm($dataProviderSetup);
	}

	public function testFormFromFilterConfig()
	{
		$filterName = 'test';
		$formType = 'form';
		$formConfig = ['asdf' => 'asdf'];

		$symfonyFormBuilder = $this->getMockBuilder(SymfonyFormBuilder::class)
			->disableOriginalConstructor()
			->getMock();

		$symfonyFormBuilder
			->method('getForm')
			->willReturn($this->getMockBuilder(FormInterface::class)->getMock());

		$formFactory = $this->getMockBuilder(FormFactory::class)
			->disableOriginalConstructor()
			->getMock();

		$formFactory
			->method('createNamedBuilder')
			->willReturn($symfonyFormBuilder);

		$filter = $this->getMockBuilder(FilterOperatorDefinitionInterface::class)
			->getMock();
		$filter->method('getName')->willReturn($filterName);

		$dataProviderSetup = new DataProviderOperatorsSetup();
		$dataProviderSetup
			->addFilter($filter, [
				FormBuilder::FORM_KEY => [
					FormBuilder::FORM_TYPE_KEY        => $formType,
					FormBuilder::FORM_TYPE_CONFIG_KEY => $formConfig
				]
			]);

		$symfonyFormBuilder
			->expects($this->once())
			->method('add')
			->with($filterName, $formType, $formConfig);

		$formBuilder = new FormBuilder($formFactory);
		$formBuilder->buildForm($dataProviderSetup);
	}
}
