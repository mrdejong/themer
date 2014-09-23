<?php

use Mrdejong\Themer\ThemeFinder;
use Illuminate\Support\Facades\Config;

class ThemeFinderTest extends TestCase {
	public function setUp()
	{
		parent::setUp();
	}

	public function tearDown()
	{
		parent::tearDown();
	}

	public function testFindDefaultTheme()
	{
		Config::shouldReceive('get')->once()->andReturn(__DIR__.'/themes');

		$theme = new ThemeFinder();

		$this->assertTrue(($theme->find('default') == realpath(__DIR__.'/themes/default')));
	}

	/**
	 * @expectedException Mrdejong\Themer\Exceptions\ThemeNotFoundException
	 */
	public function testThemeNotFound()
	{
		Config::shouldReceive('get')->twice()->andReturn(__DIR__.'/themes');

		$theme = new ThemeFinder();

		$theme->find('hello');
	}
}