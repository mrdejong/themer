<?php

use Mockery as m;

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

		if (!is_dir(__DIR__.'/themes/default'))
		{
			mkdir(__DIR__.'/themes');
			mkdir(__DIR__.'/themes/default');
			touch(__DIR__.'/themes/default/hello.php');
		}

		// Create a laravel view folder (Just to test)
		if (!is_dir(__DIR__.'/views'))
		{
			mkdir(__DIR__.'/views');
			touch(__DIR__.'/views/login.php');
		}

		// return require __DIR__.'/../../../../bootstrap/start.php';
		require __DIR__.'/../vendor/autoload.php';
	}

	public function testTestCase()
	{
		$this->assertTrue(true);
	}

	public function tearDown()
	{
		parent::tearDown();
		m::close();

		unlink(__DIR__.'/themes/default/hello.php');
		rmdir(__DIR__.'/themes/default');
		rmdir(__DIR__.'/themes');

		unlink(__DIR__.'/views/login.php');
		rmdir(__DIR__.'/views');
	}

	public function mock($class)
	{
		/*$mock = Mockery::mock($class);
		$this->app->instance($class, $mock);
		return $mock;*/
	}

}
