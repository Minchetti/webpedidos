<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'default';
$query_builder = TRUE;

#189.84.193.78
$db['default'] = array(
	'dsn'	=> 'pgsql:host=189.84.193.78;port=5432;dbname=gestaoM;sslmode=require',
	'hostname' => '189.84.193.78',
	'username' => 'postgres',
	'password' => 'fita.756',
	'database' => 'gestaoM',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'iso88591',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(
		array(
			'dsn'	=> 'pgsql:host=177.44.70.70;port=5432;dbname=gestaoM;sslmode=require',
			'hostname' => '177.44.70.70',
			'username' => 'postgres',
			'password' => 'fita.756',
			'database' => 'gestaoM',
			'dbdriver' => 'pdo',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'latin1',
			'dbcollat' => 'iso88591',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE
		)
	),
	'save_queries' => TRUE
);
/*

$db['fitassul8T'] = array(
	'dsn'	=> 'pgsql:host=189.84.193.78;port=5432;dbname=fitassul8T;sslmode=require',
	'hostname' => '189.84.193.78',
	'username' => 'postgres',
	'password' => 'fita.756',
	'database' => 'fitassul8T',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'iso88591',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(
		array(
			'dsn'	=> 'pgsql:host=177.44.70.70;port=5432;dbname=fitassul8T;sslmode=require',
			'hostname' => '177.44.70.70',
			'username' => 'postgres',
			'password' => 'fita.756',
			'database' => 'fitassul8T',
			'dbdriver' => 'pdo',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'latin1',
			'dbcollat' => 'iso88591',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE
		)
	),
	'save_queries' => TRUE
);
orc tooth, vampire tooth, rope belt, sabretooth, bloody pincers, elvish talisman, silencer claws, protective charm*/
// INSERT INTO "pedidos" ("aprovar", "data_emissao", "data_fechado", "dh_aprovacao", "entrega_local", "entrega_turno", "id_centro_custo", "id_depto", "key_clientes", "key_clientes_aprovador", "key_clientes_solicitante", "key_funcionarios", "key_funcionarios_aprovador", "key_funcionarios_solicitante", "numero", "obs") VALUES ('1','2018-08-28',NULL,'2018-08-28 16:21:23','',1,'75008280','44.013.159/0031-31','44.013.159/0031-31','44.013.159/0031-31','','33021887','33021887','0',49470,'')
// INSERT INTO "pedidos" ("aprovar", "data_emissao", "data_fechado", "dh_aprovacao", "entrega_local", "entrega_turno", "id_centro_custo", "id_depto", "key_clientes", "key_clientes_aprovador", "key_clientes_solicitante", "key_funcionarios", "key_funcionarios_aprovador", "key_funcionarios_solicitante", "numero", "obs") VALUES ('1','2018-08-28',NULL,'2018-08-28 16:21:23','',1,'75008280','44.013.159/0031-31','44.013.159/0031-31','44.013.159/0031-31','44.013.159/0031-31','33021887','33021887','33021887',49470,'')

$db['fitassul13'] = array( //LOGIN 2
	'dsn'	=> 'pgsql:host=189.84.193.78;port=5432;dbname=fitassul13M;sslmode=require',
	'hostname' => '189.84.193.78',
	'username' => 'postgres',
	'password' => 'fita.756',
	'database' => 'fitassul13M',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'iso88591',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(
		array(
			'dsn'	=> 'pgsql:host=177.44.70.70;port=5432;dbname=fitassul13M;sslmode=require',
			'hostname' => '177.44.70.70',
			'username' => 'postgres',
			'password' => 'fita.756',
			'database' => 'fitassul13M',
			'dbdriver' => 'pdo',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'latin1',
			'dbcollat' => 'iso88591',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE
		)
	),
	'save_queries' => TRUE
);
/* SZ78wDCx
$db['fitassul13T1'] = array(
	'dsn'	=> 'pgsql:host=189.84.193.78;port=5432;dbname=fitassul13T1;sslmode=require',
	'hostname' => '189.84.193.78',
	'username' => 'postgres',
	'password' => 'fita.756',
	'database' => 'fitassul13T1',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'iso88591',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(
		array(
			'dsn'	=> 'pgsql:host=177.44.70.70;port=5432;dbname=fitassul13T1;sslmode=require',
			'hostname' => '177.44.70.70',
			'username' => 'postgres',
			'password' => 'fita.756',
			'database' => 'fitassul13T1',
			'dbdriver' => 'pdo',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'latin1',
			'dbcollat' => 'iso88591',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE
		)
	),
	'save_queries' => TRUE
);

$db['fitassul8T1'] = array(
	'dsn'	=> 'pgsql:host=189.84.193.78;port=5432;dbname=fitassul8T1;sslmode=require',
	'hostname' => '189.84.193.78',
	'username' => 'postgres',
	'password' => 'fita.756',
	'database' => 'fitassul8T1',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'iso88591',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(
		array(
			'dsn'	=> 'pgsql:host=177.44.70.70;port=5432;dbname=fitassul8T1;sslmode=require',
			'hostname' => '177.44.70.70',
			'username' => 'postgres',
			'password' => 'fita.756',
			'database' => 'fitassul8T1',
			'dbdriver' => 'pdo',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'latin1',
			'dbcollat' => 'iso88591',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE
		)
	),
	'save_queries' => TRUE
);
*/
$db['fitassul7'] = array( //LOGIN 9
	'dsn'	=> 'pgsql:host=189.84.193.78;port=5432;dbname=fitassul7M;sslmode=require',
	'hostname' => '189.84.193.78',
	'username' => 'postgres',
	'password' => 'fita.756',
	'database' => 'fitassul7M',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'iso88591',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(
		array(
			'dsn'	=> 'pgsql:host=177.44.70.70;port=5432;dbname=fitassul7M;sslmode=require',
			'hostname' => '177.44.70.70',
			'username' => 'postgres',
			'password' => 'fita.756',
			'database' => 'fitassul7M',
			'dbdriver' => 'pdo',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'latin1',
			'dbcollat' => 'iso88591',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE
		)
	),
	'save_queries' => TRUE
);

// $db['fitassul9'] = array(
// 	'dsn'	=> 'pgsql:host=189.84.193.78;port=5432;dbname=fitassul9;sslmode=require',
// 	'hostname' => '189.84.193.78',
// 	'username' => 'postgres',
// 	'password' => 'fita.756',
// 	'database' => 'fitassul9',
// 	'dbdriver' => 'pdo',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'latin1',
// 	'dbcollat' => 'iso88591',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(
// 		array(
// 			'dsn'	=> 'pgsql:host=177.44.70.70;port=5432;dbname=fitassul9;sslmode=require',
// 			'hostname' => '177.44.70.70',
// 			'username' => 'postgres',
// 			'password' => 'fita.756',
// 			'database' => 'fitassul9',
// 			'dbdriver' => 'pdo',
// 			'dbprefix' => '',
// 			'pconnect' => FALSE,
// 			'db_debug' => (ENVIRONMENT !== 'production'),
// 			'cache_on' => FALSE,
// 			'cachedir' => '',
// 			'char_set' => 'latin1',
// 			'dbcollat' => 'iso88591',
// 			'swap_pre' => '',
// 			'encrypt' => FALSE,
// 			'compress' => FALSE,
// 			'stricton' => FALSE
// 		)
// 	),
// 	'save_queries' => TRUE
// );