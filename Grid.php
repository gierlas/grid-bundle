<?php

namespace Kora\GridBundle;

use Kora\Grid\Grid as GridBase;
use Kora\GridBundle\FormBuilder\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
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
	 * @return FormBuilderInterface
	 * @throws \Kora\GridBundle\FormBuilder\Exception\CannotGuessFormTypeException
	 */
	public function getFilterForm(): FormBuilderInterface
	{
		return $this->formBuilder->buildForm($this);
	}
}