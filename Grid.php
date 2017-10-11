<?php

namespace Kora\GridBundle;

use Kora\Grid\Grid as GridBase;
use Kora\GridBundle\FormBuilder\FormBuilder;
use Symfony\Component\Form\FormInterface;

/**
 * Class Grid
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class Grid extends GridBase
{
	/**
	 * @var FormBuilder
	 */
	protected $formBuilder;

	/**
	 * Grid constructor.
	 * @param FormBuilder         $formBuilder
	 */
	public function __construct(FormBuilder $formBuilder)
	{
		$this->formBuilder = $formBuilder;
		parent::__construct();
	}

	/**
	 * @return FormInterface
	 */
	public function getFilterForm(): FormInterface
	{
		return $this->formBuilder->buildForm($this);
	}
}