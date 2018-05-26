<?php

use Mockery as m;

class TestCase extends Orchestra\Testbench\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function setUp()
	{
		parent::setUp();

		if (!is_dir(__DIR__.'/themes/default'))
		{
			mkdir(__DIR__.'/themes');
			mkdir(__DIR__.'/themes/default');
			touch(__DIR__.'/themes/default/hello.php');
		}

		if (!is_dir(storage_path().'/meta')) {
			mkdir(storage_path().'/meta');
			file_put_contents(storage_path().'/meta/themer.json', json_encode([
				'default' => [
					'theme' => 'default'
				]]
			));
		}

		// Create a laravel view folder (Just to test)
		if (!is_dir(__DIR__.'/views'))
		{
			mkdir(__DIR__.'/views');
			touch(__DIR__.'/views/login.php');
		}
	}

	public function testTestCase()
	{
		$this->assertTrue(true);
	}

	public function tearDown()
	{
		unlink(__DIR__.'/themes/default/hello.php');
		rmdir(__DIR__.'/themes/default');
		rmdir(__DIR__.'/themes');

		unlink(__DIR__.'/views/login.php');
		rmdir(__DIR__.'/views');

		unlink(storage_path().'/meta/themer.json');
		rmdir(storage_path().'/meta');

		m::close();

		parent::tearDown();
	}

	protected function getPackageProviders($app)
	{
		return array(
			'Mrdejong\Themer\ThemerServiceProvider'
		);
	}

	protected function getPackageAliases($app)
	{
		return array(
			'Themer'		=> 'Mrdejong\Themer\Facades\Themer'
		);
	}
}
