<?php

namespace Kora\GridBundle\FormBuilder\FilterFormTypes;

use Kora\DataProvider\OperatorDefinition\Filter\DateRangeFilterDefinition;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\GridBundle\FormBuilder\FilterFormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class DateRangeFilterFormType
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DateRangeFilterFormType implements FilterFormTypeInterface
{
	public function addToBuilder(
		FormBuilderInterface $formBuilder, FilterOperatorDefinitionInterface $filterDefinition, array $config = []
	)
	{
		/** @var DateRangeFilterDefinition $filterDefinition */
		$dateRangeForm = $formBuilder->create($filterDefinition->getName(), null, [
			'compound' => true
		]);

		$dateRangeForm->add($filterDefinition->getStartName(), null, [
			'required' => false
		]);

		$dateRangeForm->add($filterDefinition->getEndName(), null, [
			'required' => false
		]);

		$formBuilder->add($dateRangeForm);
	}

}