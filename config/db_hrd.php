<?php
return [
    'class' => 'yii\db\Connection',
    'driverName' => 'sqlsrv',
	'dsn' => 'sqlsrv:server=168.168.0.41;database=HR_APPLICATION',
    'username' => 'user_bpkb',
    'password' => '123456!@#$%^',
    'charset' => 'utf8',
	//local
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];