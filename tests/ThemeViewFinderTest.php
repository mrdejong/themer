<?php

use Mockery as m;

class ThemeViewFinderTest extends TestCase {
	private $viewFinder;
	private $finder;

	public function setUp()
	{
		parent::setUp();



		$this->viewFinder = new Mrdejong\Themer\ThemeViewFinder(new Illuminate\Filesystem\Filesystem(), array(
			__DIR__.'/themes/default',
			__DIR__.'/../../../../app/views'
		));
	}

	public function testFallsBackToLaravel()
	{
		$this->assertTrue((realpath($this->viewFinder->find('login')) == realpath(__DIR__.'/../../../../app/views/login.php')));
	}

	public function testFindsThemeView()
	{
		$this->assertTrue((realpath($this->viewFinder->find('hello')) == realpath(__DIR__.'/themes/default/hello.php')));
	}
}