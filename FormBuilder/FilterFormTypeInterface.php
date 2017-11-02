<?php

namespace Kora\GridBundle\FormBuilder;

use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Interface FilterFormTypeInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface FilterFormTypeInterface
{
	public function addToBuilder(
		FormBuilderInterface $formBuilder, FilterOperatorDefinitionInterface $filterDefinition, array $config = []
	);
}