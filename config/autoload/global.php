<?php
$db = array(
        'driver' => 'Pdo',
        //Public IP: 54.244.118.27 ; Private IP : 10.253.74.82        
        'dsn' => 'mysql:dbname=tnd_db;host=54.244.118.27',
        'hostname' => '54.244.118.27',
        'database' => 'tnd_db',
        'username' => 'root',
        'password' => 'bnet2007',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    );

return array(
    
    'service_manager' => array(
        'factories' => array(
            //'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Zend\Db\Adapter\Adapter' => function ($sm) use ($db) {
                $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter(array(
                    'driver'    => 'pdo',
                    'dsn'       => 'mysql:dbname='.$db['database'].';host='.$db['hostname'],
                    'database'  => $db['database'],
                    'username'  => $db['username'],
                    'password'  => $db['password'],
                    'hostname'  => $db['hostname'],
                ));
 
                $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler);
                $adapter->injectProfilingStatementPrototype();
                return $adapter;
            },
        ),
    ),
);