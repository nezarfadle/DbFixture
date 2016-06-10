# DbFixture

This is a light class library working as SQL scripts Executer.

# Installation

``` composer require nezarfadle/dbfixture ```

# Usage

1. Create a Database and name it ``` dbfixture ``` ( This could be any name ).

2. Create a folder and name it ``` fixtures ``` and save your fixtures files inside it:
```
fixtures/articles.create.sql
############################

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

```
fixtures/articles.drop.sql
##########################

DROP TABLE IF EXISTS articles;
```

```
fixtures/articles.insert.sql
############################

INSERT INTO articles values (1, 'PHP')
```
3. Create your own Fixture Class by extending the ``` DbFixture ``` class:

```
// MysqlDbFixture.php 
<?php

use DbFixture\DbFixture;

class MysqlDbFixture extends DbFixture
{

    public function __construct( $dsn, $username, $password )
    {

        $pdo = new \PDO( $dsn, $username, $password, 
        	[
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );

        parent::__construct( $pdo );

        
    }
}
```
instantiate a new ``` MysqlDbFixture ``` instance and start using it:

```
$fixture = new MysqlDbFixture( 'mysql:host=localhost;dbname=dbfixture', 'root', 'password' );

$fixture->runScript('fixtures/articles.create.sql');
$fixture->runScript('fixtures/articles.insert.sql');
$fixture->runScript('fixtures/articles.drop.sql');

```
Use the ``` basePath ``` method to tell the DbFixture where to find the fixtures files:
```
$fixture->basePath(__DIR__ . '/fixtures/'); 

$fixture->runScript('articles.create.sql');
$fixture->runScript('articles.insert.sql');
$fixture->runScript('articles.drop.sql');

```
To load multiple scripts use ``` runScripts ``` method:

```
$fixture->basePath(__DIR__ . '/fixtures/'); 

$fixture->runScripts( 
	[ 
		'articles.create.sql', 
		'articles.insert.sql',
		'articles.drop.sql'
	]
);

```

Use the ``` run ``` method to execute raw SQL statment:
```
$fixture->run( "INSERT INTO articles values (1, 'PHP')" );
```

# How to run the Test

1. Create a database and name it dbfixture ( This could be any name )
2. Edit the ``` tests/MysqlDbFixtureTest.php ```  file, And set the database credentials ( Line 12 )
```
 $pdo = new PDO('mysql:host=localhost;dbname=dbfixture', 'root', 'password');
 ```
 3. run ``` phpunit ``` :

 ```
 phpunit
 ```