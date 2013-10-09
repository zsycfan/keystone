<?php

class ConnectionTest extends PHPUnit_Framework_TestCase {

	public function testTrue()
	{
		$builder = new \Lascaux\Builder;
		$this->assertTrue((bool)$builder->getPdo());
	}

}