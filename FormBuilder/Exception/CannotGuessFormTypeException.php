<?php

namespace Kora\GridBundle\FormBuilder\Exception;

use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;


/**
 * Class CannotGuessFormType
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class CannotGuessFormTypeException extends \Exception
{
	public function __construct(FilterOperatorDefinitionInterface $filterOperatorDefinition)
	{
		$class = get_class($filterOperatorDefinition);
		parent::__construct("Cannot guess form type for $class");
	}
}