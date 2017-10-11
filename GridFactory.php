<?php

namespace Kora\GridBundle;

use Kora\GridBundle\FormBuilder\FormBuilder;


/**
 * Class GridFactory
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
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