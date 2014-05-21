<?php
return array(
    'adapter' => 'PDO_MYSQL',
    'isDefaultTableAdapter' => true,
    'params' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname' => 'test_daikuan',
        'charset' => 'utf8',
        'driver_options' => array(
            1002 => 'SET NAMES UTF8;',
        )
    ),
    'prefix' => 'sys_'
);