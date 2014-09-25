<?php

class TestMetaData extends TestCase {
	public function testGetTag()
	{
		$meta = $this->app['themer.metadata'];

		$this->assertTrue(($meta->get('default.theme') == 'default'));
	}

	public function testFailedGetTag()
	{
		$meta = $this->app['themer.metadata'];

		$this->assertNull($meta->get('tag.not.exists'));
	}

	public function testSetTag()
	{
		$meta = $this->app['themer.metadata'];

		$meta->set('test_tag', true);

		$this->assertTrue(($meta->get('test_tag') == true));
	}
	
	public function testRemoveTag()
	{
		$meta = $this->app['themer.metadata'];

		$meta->remove('test_tag');

		$this->assertNull($meta->get('test_tag'));
	}

}