<?php

namespace Kora\GridBundle\FormBuilder\FilterFormTypes;

use Kora\GridBundle\FormBuilder\FilterFormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class TestForm
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class TestForm implements FilterFormTypeInterface
{
	public function addToBuilder(FormBuilderInterface $formBuilder, array $config = [])
	{

	}
}