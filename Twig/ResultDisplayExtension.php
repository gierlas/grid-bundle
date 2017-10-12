<?php

namespace Kora\GridBundle\Twig;

use Kora\Grid\ResultDisplay\Column;
use Kora\GridBundle\Twig\Exception\RequireTemplateException;


/**
 * Class ResultDisplayExtension
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class ResultDisplayExtension extends \Twig_Extension
{
	const KEY_TEMPLATE = 'template';

	protected $types = [];

	public function getFunctions()
	{
		return [
			new \Twig_Function(
				'kora_render_column', [$this, 'renderColumn'], [
					'needs_environment' => true
				]
			)
		];
	}

	public function renderColumn(\Twig_Environment $twig, Column $column, $data)
	{
		$template = $column->getExtraConfigPart(self::KEY_TEMPLATE);

		if($column->isFake()) {
			if($template === null) {
				throw new RequireTemplateException($column->getName(), 'Fake');
			}

			return $twig->render($template, [
				'row' => $data,
				'column' => $column
			]);
		}

		$value = $column->getValue($data);

		return $template === null
			? $value
			: $twig->render($template, [
				'value' => $value,
				'row' => $data,
				'column' => $column
			]);
	}

	/**
	 * @param string $type
	 * @param string $template
	 */
	public function addType(string $type, string $template)
	{
		$this->types[$type] = $template;
	}

	/**
	 * @param string $type
	 * @return mixed|null
	 */
	protected function getTemplateForType(string $type)
	{
		return $this->types[$type] ?? null;
	}
}