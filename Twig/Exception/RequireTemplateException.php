<?php

namespace Kora\GridBundle\Twig\Exception;


/**
 * Class RequireTemplateException
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class RequireTemplateException extends \Exception
{
	public function __construct(string $name, string $type)
	{
		parent::__construct("Column $name of type '$type' requires template.");
	}
}