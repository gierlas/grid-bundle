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

			$formType = null;
			$formTypeConfig = [
				'required' => false
			];

			if(isset($config[self::FORM_KEY])) {
				$formConfig = $config[self::FORM_KEY];
				$formType = $formConfig[self::FORM_TYPE_KEY] ?? null;
				$formTypeConfig = $formConfig[self::FORM_TYPE_CONFIG_KEY] ?? $formTypeConfig;

				if($formType !== null) {
					$paramVal = $filter->getParamValue();
					if(is_array($paramVal)) {
						$data += $paramVal;
					}
					$formBuilder->add($filter->getName(), $formType, $formTypeConfig);
					continue;
				}
			}

			$filterFormType = $this->guessFormType($filter);

			if($filterFormType === null) {
				throw new CannotGuessFormTypeException($filter);
			}

			$data[$filter->getName()] = $filter->getParamValue();
			$filterFormType->addToBuilder($formBuilder, $formTypeConfig);
		}

		$formBuilder->setData($data);
		return $formBuilder->getForm();
	}

	/**
	 * @param FilterOperatorDefinitionInterface $filter
	 * @return FilterFormTypeInterface|null
	 */
	public function guessFormType(FilterOperatorDefinitionInterface $filter)
	{
		return $this->filterForms[get_class($filter)] ?? null;
	}
}