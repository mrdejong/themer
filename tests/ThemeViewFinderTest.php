<?php

class ThemeViewFinderTest extends TestCase {
	private $finder;

	public function setUp()
	{
		parent::setUp();

		//$this->finder = $this->mock('Mrdejong\Themer\ThemeViewFinder');
	}

	public function tearDown()
	{
		\Mockery::close();
	}

	public function testFallsBackToLaravel()
	{
		$this->assertTrue(true);
	}

	public function testFindsThemeView()
	{
		$this->assertTrue(true);
	}
}