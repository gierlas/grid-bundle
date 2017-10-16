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
		if($column->isFake()) {
			return $this->handleFakeColumn($twig, $column, $data);
		}

		$template = $this->getTemplateForColumn($column);
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
	 * @param \Twig_Environment $twig
	 * @param Column            $column
	 * @param                   $data
	 * @return string
	 * @throws RequireTemplateException
	 */
	protected function handleFakeColumn(\Twig_Environment $twig, Column $column, $data): string
	{
		$template = $column->getExtraConfigPart(self::KEY_TEMPLATE);

		if($template === null) {
			throw new RequireTemplateException($column->getName(), 'Fake');
		}

		return $twig->render($template, [
			'row' => $data,
			'column' => $column
		]);
	}

	/**
	 * @param Column $column
	 * @return string|null
	 */
	protected function getTemplateForColumn(Column $column)
	{
		$templateFromConfig = $column->getExtraConfigPart(self::KEY_TEMPLATE);
		return $templateFromConfig ?? ($column->getType() ? $this->getTemplateForType($column->getType()) : null);
	}

	/**
	 * @param string $type
	 * @return string|null
	 */
	protected function getTemplateForType(string $type)
	{
		return $this->types[$type] ?? null;
	}

	/**
	 * @param string $type
	 * @param string $template
	 */
	public function addType(string $type, string $template)
	{
		$this->types[$type] = $template;
	}
}