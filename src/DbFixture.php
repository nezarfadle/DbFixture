<?php  namespace DbFixture;

/**
 * @author Nezar Fadle <nezarfadle@gmail.com>
 */

/**
 * Abstract DbFixture class 	
 * This class  must be inherited.
 * @abstract
 */

abstract class DbFixture
{

	/**
	 * PDO connection
	 * @var \PDO
	 */
	protected $pdo;

	/**
	 * 
	 * @var string
	 */
	protected $basePath = '';
	
	/**
	 * Initializes DbFixture.
	 * 
	 * @param \PDO $pdo PDO connection
	 */
	public function __construct($pdo)
	{
		$this->pdo = $pdo;      
	}

	/**
	 * Set the base path where the SQL scripts located.
	 * This path will be used by runFromScript and runFromScripts if it has been set.
	 * 
	 * @param string $path
	 */
	public function basePath($path)
	{
		$this->basePath = trim( $path );
		return $this;
	}
	
	/**
	 * Execute SQL statments.
	 * 
	 * @param string $sql 	This could be any valid SQL statment: INERT INTO table VALUES(1, 'foo')
	 */
	public function run( $sql )
	{
		$this->pdo->exec( $sql );
	}

	/**
	 * Execute SQL statments from an external SQL file.
	 * 
	 * @param string $scriptPath	A path to an existent SQL file.
	 * @param bool $useGivenPath 	This variable will make the method ignore the basePath.
	 */
	public function runScript( $scriptPath, $useGivenPath = false )
	{
		if ( $this->basePath != '' && !$useGivenPath )
		{
			$scriptPath = $this->basePath . $scriptPath;
		}
		
		$sql = file_get_contents( $scriptPath );
		$this->run( $sql );
	}

	/**
	 * Execute SQL statments from multiple external SQL files.
	 * 
	 * @param array $scripts		A path to a multiple existent SQL files.
	 * @param bool $useGivenPath 	This variable will make the method ignore the basePath.
	 */
	public function runScripts( array $scripts, $useGivenPath = false )
	{
		foreach ($scripts as $script) 
		{
			$this->runScript( $script, $useGivenPath );
		}
	}


}