<?php

namespace Kora\GridBundle\Tests\Twig;

use Kora\Grid\ResultDisplay\Column;
use Kora\GridBundle\Twig\ResultDisplayExtension;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Mockery as m;

/**
 * Class ResultDisplayExtensionTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class ResultDisplayExtensionTest extends TestCase
{
	use MockeryPHPUnitIntegration;

	/**
	 * @expectedException \Kora\GridBundle\Twig\Exception\RequireTemplateException
	 */
	public function testFakeException()
	{
		$columnName = 'test';
		$data = [];

		$twigEnvironment = $this->getMockBuilder(\Twig_Environment::class)
			->disableOriginalConstructor()
			->getMock();

		$column = new Column($columnName);
		$column->setFake(true);

		$extension = new ResultDisplayExtension();

		$extension->renderColumn($twigEnvironment, $column, $data);
	}

	public function testRenderWithTemplate()
	{
		$columnName = 'test';
		$data = [];
		$template = 'template';

		$twigEnvironment = $this->getMockBuilder(\Twig_Environment::class)
			->disableOriginalConstructor()
			->getMock();

		$twigEnvironment
			->expects($this->once())
			->method('render')
			->willReturn('');

		$column = new Column($columnName, '', [
			ResultDisplayExtension::KEY_TEMPLATE => $template
		]);
		$column->setFake(true);

		$twigEnvironment
			->expects($this->once())
			->method('render')
			->with($template, ['row' => $data, 'column' => $column]);

		$extension = new ResultDisplayExtension();
		$extension->renderColumn($twigEnvironment, $column, $data);
	}

	public function testDisplayOnlyValue()
	{
		$columnName = 'test';
		$data = [];
		$value = 'value';

		$twigEnvironment = $this->getMockBuilder(\Twig_Environment::class)
			->disableOriginalConstructor()
			->getMock();

		$column = m::mock(Column::class, [$columnName])
			->shouldDeferMissing();

		$column
			->shouldReceive('getValue')
			->once()
			->with($data)
			->andReturn($value);

		$twigEnvironment
			->expects($this->never())
			->method('render');

		$extension = new ResultDisplayExtension();
		$rendered = $extension->renderColumn($twigEnvironment, $column, $data);

		$this->assertEquals($value, $rendered);
	}

	public function testDisplayValueInTemplate()
	{
		$columnName = 'test';
		$data = [];
		$value = 'value';
		$template = 'template';


		$twigEnvironment = $this->getMockBuilder(\Twig_Environment::class)
			->disableOriginalConstructor()
			->getMock();

		$column = m::mock(Column::class, [$columnName, '', [
			ResultDisplayExtension::KEY_TEMPLATE => $template
		]])
			->shouldDeferMissing();

		$column
			->shouldReceive('getValue')
			->once()
			->with($data)
			->andReturn($value);

		$twigEnvironment
			->expects($this->once())
			->method('render')
			->with($template, [
				'value' => $value,
				'row' => $data,
				'column' => $column
			]);

		$extension = new ResultDisplayExtension();
		$rendered = $extension->renderColumn($twigEnvironment, $column, $data);
	}
}
