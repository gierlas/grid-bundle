<?php

namespace Kora\GridBundle\FormBuilder;

use Kora\DataProvider\DataProviderOperatorsSetup;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\GridBundle\FormBuilder\Exception\CannotGuessFormTypeException;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormBuilder
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class FormBuilder
{
	const FORM_KEY = 'form';

	const FORM_TYPE_KEY = 'type';

	const FORM_TYPE_CONFIG_KEY = 'type_config';

	/**
	 * @var FormFactory
	 */
	private $formFactory;

	/**
	 * @var FilterFormTypeInterface[]
	 */
	private $filterForms = [];

	/**
	 * FormBuilder constructor.
	 * @param FormFactory $formFactory
	 */
	public function __construct(FormFactory $formFactory)
	{
		$this->formFactory = $formFactory;
	}

	/**
	 * @param string                  $code
	 * @param FilterFormTypeInterface $filterFormType
	 * @return FormBuilder
	 */
	public function addFormFilterType(string $code, FilterFormTypeInterface $filterFormType): FormBuilder
	{
		$this->filterForms[$code] = $filterFormType;
		return $this;
	}

	/**
	 * @param FilterOperatorDefinitionInterface $filter
	 * @return FilterFormTypeInterface
	 * @throws \Kora\GridBundle\FormBuilder\Exception\CannotGuessFormTypeException
	 */
	public function guessFormType(FilterOperatorDefinitionInterface $filter): FilterFormTypeInterface
	{
		$filterFormType = $this->filterForms[get_class($filter)] ?? null;
		if($filterFormType === null) {
			throw new CannotGuessFormTypeException($filter);
		}

		return $filterFormType;
	}

	/**
	 * @param DataProviderOperatorsSetup $dataProviderOperatorsSetup
	 * @return FormInterface
	 * @throws CannotGuessFormTypeException
	 */
	public function buildForm(DataProviderOperatorsSetup $dataProviderOperatorsSetup): FormInterface
	{
		$formBuilder = $this->formFactory->createNamedBuilder('');
		$data = [];

		foreach ($dataProviderOperatorsSetup->getFiltersWithExtraConfigIterator() as $name => list($filter, $config))
		{
			/** @var FilterOperatorDefinitionInterface $filter */
			$formConfig = $config[self::FORM_KEY] ?? [];
			$formType = $formConfig[self::FORM_TYPE_KEY] ?? null;
			$formTypeConfig = $formConfig[self::FORM_TYPE_CONFIG_KEY] ?? [ 'required' => false ];

			$data[$filter->getName()] = $filter->getParamValue();

			if($formType !== null) {
				$formBuilder->add($filter->getName(), $formType, $formTypeConfig);
				continue;
			}

			$filterFormType = $this->guessFormType($filter);
			$filterFormType->addToBuilder($formBuilder, $formTypeConfig);
		}

		$formBuilder->setData($data);
		return $formBuilder->getForm();
	}
}