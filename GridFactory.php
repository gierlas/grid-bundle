<?php

namespace Kora\Grid\Symfony;

use Kora\Grid\Symfony\FormBuilder\FormBuilder;


/**
 * Class GridFactory
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class GridFactory
{
	/**
	 * @var FormBuilder
	 */
	private $formBuilder;

	/**
	 * GridFactory constructor.
	 * @param FormBuilder $formBuilder
	 */
	public function __construct(FormBuilder $formBuilder)
	{
		$this->formBuilder = $formBuilder;
	}

	/**
	 * @return Grid
	 */
	public function createGrid(): Grid
	{
		return new Grid($this->formBuilder);
	}
}