<?php

namespace Kora\GridBundle\DependencyInjection\CompilerPass;

use Kora\GridBundle\DependencyInjection\CompilerPass\Exception\FormTypeRequireFilterException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


/**
 * Class FilterFormTypePass
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class FilterFormTypePass implements CompilerPassInterface
{
	const FILTER_FORM_BUILDER_NAME = 'kora_grid.form_builder';
	const FILTER_FORM_TAG = 'kora_grid.filter_form';

	public function process(ContainerBuilder $container)
	{
		$filterFormBuilder = $container->getDefinition(self::FILTER_FORM_BUILDER_NAME);

		$filterFormTypes = $container ->findTaggedServiceIds(self::FILTER_FORM_TAG);

		foreach ($filterFormTypes as $filterFormType => $params) {
			$filter = $params[0]['filter'] ?? null;

			if($filter === null) {
				throw new FormTypeRequireFilterException($filterFormType);
			}

			$filterFormBuilder
				->addMethodCall('addFormFilterType', [$filter, new Reference($filterFormType)]);
		}
	}

}