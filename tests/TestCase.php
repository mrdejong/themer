<?php

class TestCase extends PHPUnit_Framework_TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function setUp()
	{
		parent::setUp();
		$unitTesting = true;

		$testEnvironment = 'testing';

		// return require __DIR__.'/../../../../bootstrap/start.php';
		require __DIR__.'/../vendor/autoload.php';
	}

	public function testTestCase()
	{
		$this->assertTrue(true);
	}

	public function mock($class)
	{
		/*$mock = Mockery::mock($class);
		$this->app->instance($class, $mock);
		return $mock;*/
	}

}
