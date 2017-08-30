<?php

namespace App;

abstract class DbFixture_TestCase extends \PHPUnit_Extensions_Database_TestCase
{
	protected $pdo;

	public function __construct()
	{
		$this->pdo = $this->getConnection()->getConnection();
	}

    public function assertTableIsExists($tableName)
    {
    	try {
    		$this->pdo->exec("select 1 from $tableName");
    	} catch (\Exception $e) {
    		$this->fail("Failed asserting the $tableName table is exists");
    	}
    }

    public function assertTableIsNotExists($tableName)
    {
    	try {
    		$this->pdo->exec("select 1 from $tableName");
    	} catch (\Exception $e) {
    		return;
    	}
		
		$this->fail("Failed asserting the $tableName is not exists");
		
    }

}