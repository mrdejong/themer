<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../../../bootstrap/start.php';
	}

	public function testTestCase()
	{
		$this->assertTrue(true);
	}

	public function mock($class)
	{
		$mock = Mockery::mock($class);
		$this->app->instance($class, $mock);
		return $mock;
	}

}
