<?php

namespace Kora\GridBundle\DependencyInjection\CompilerPass\Exception;

use Throwable;


/**
 * Class FormTypeRequireFilterException
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class FormTypeRequireFilterException extends \Exception
{
	public function __construct(string $serviceName)
	{
		parent::__construct("Filter form type $serviceName requires 'filter' param.");
	}
}