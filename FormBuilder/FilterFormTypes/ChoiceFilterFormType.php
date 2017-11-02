<?php

namespace Kora\GridBundle\FormBuilder\FilterFormTypes;

use Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilterDefinition;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\GridBundle\FormBuilder\FilterFormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class ChoiceFilterFormType
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class ChoiceFilterFormType implements FilterFormTypeInterface
{
	/**
	 * @param FormBuilderInterface              $formBuilder
	 * @param FilterOperatorDefinitionInterface $filterDefinition
	 * @param array                             $config
	 */
	public function addToBuilder(
		FormBuilderInterface $formBuilder, FilterOperatorDefinitionInterface $filterDefinition, array $config = []
	)
	{
		$finalConfig = array_merge([
			'choices' => $filterDefinition->getChoices(),
			'multiple' => $filterDefinition->isMulti()
		], $config);

		/** @var ChoiceFilterDefinition $filterDefinition */
		$formBuilder->add($filterDefinition->getName(), ChoiceType::class, $finalConfig);
	}
}