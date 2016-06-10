<?php  namespace App;

use DbFixture\DbFixture;

class MysqlDbFixture extends DbFixture
{

    public function __construct( $dsn, $username, $password, $basePath = '' )
    {

        if ( trim ( $basePath != '' ) )
        {
            $this->basePath = $basePath;
        }

        $pdo = new \PDO( 
                $dsn, 
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION
                ]
        );
        parent::__construct( $pdo );

        
    }
}