<?php  

use DbFixture\MysqlDbFixture;
use DbFixture\DbFixture_TestCase;

class MysqlDbFixtureTest extends DbFixture_TestCase
{
	private $fixture;

	public function getConnection()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=dbfixture', 'root', 'password');
        return $this->createDefaultDBConnection($pdo);
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_DefaultDataSet();
    }

    public function setup()
    {
    	$this->fixture = new MysqlDbFixture( 
			'mysql:host=localhost;dbname=dbfixture',
			'root',
			'password',
			__DIR__ . "/fixtures/"
		);
    }

	public function test_ArticlesTable_ShouldBeCreated()
	{
		// Run the Script and Drop the articles table
		$this->fixture->runScript('articles.drop.sql');

		// Assert articles table is not exists
		$this->assertTableIsNotExists('articles');
		
		// Run the Script and Create the articles table
		$this->fixture->runScript('articles.create.sql');

		// Assert articles table is exists
		$this->assertTableIsExists('articles');

		// Run the Script and Drop the articles table
		$this->fixture->runScript('articles.drop.sql');
		
	}

	public function test_ArticlesTable_ShouldBeCreated_And_A_RowShoudBeInserted()
	{
		// Run the Script and Drop the articles table
		$this->fixture->runScript('articles.drop.sql');

		// Assert articles table is not exists
		$this->assertTableIsNotExists('articles');
		
		// Run the Script and Create the articles table
		$this->fixture->runScript('articles.create.sql');

		// Assert articles table is exists
		$this->assertTableIsExists('articles');

		$rowsCount = $this->getConnection()->getRowCount('articles'); // Rows count in the articles table should be 0
    	$this->assertEquals( 0, $rowsCount);

    	// Execute a Raw SQL statment
    	$this->fixture->run("INSERT INTO articles values (1, 'PHP')");

    	$rowsCount = $this->getConnection()->getRowCount('articles'); // Rows count in the articles table should be 1
    	$this->assertEquals( 1, $rowsCount);

		// Run the Script and Drop the articles table
		$this->fixture->runScript('articles.drop.sql');
		
	}

	public function test_MultipleScripts_ShouldBeExecuted()
	{
		// Run the Script and Drop the articles table
		$this->fixture->runScript('articles.drop.sql');

		// Assert articles table is not exists
		$this->assertTableIsNotExists('articles');
		
		// Run multiple Scripts to create and insert to the Articles table
		$this->fixture->runScripts([
			'articles.create.sql',
			'articles.insert.sql',
		]);

		$rowsCount = $this->getConnection()->getRowCount('articles'); // Rows count in the articles table should be 1
    	$this->assertEquals( 1, $rowsCount);

		// Run the Script and Drop the articles table
		$this->fixture->runScript('articles.drop.sql');
		
	}
}