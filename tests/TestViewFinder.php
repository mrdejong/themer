<?php

class TestViewFinder extends TestCase {
	public function tearDown()
	{
		//\Mockery::close();
	}

	public function testFallsBackToLaravel()
	{
		$this->assertTrue(false);
	}

	public function testFindsThemeView()
	{
		$this->assertTrue(false);
	}
}