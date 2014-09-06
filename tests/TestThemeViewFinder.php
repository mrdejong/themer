<?php

class TestThemeViewFinder extends TestCase {
	private $finder;

	public function setUp()
	{
		parent::setUp();

		$this->finder = $this->mock('Mrdejong\Themer\ThemeViewFinder');
	}

	public function tearDown()
	{
		\Mockery::close();
	}

	public function testFallsBackToLaravel()
	{
		
	}

	public function testFindsThemeView()
	{
		$this->assertTrue(false);
	}
}