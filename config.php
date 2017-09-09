<?php
return [
// set a database connection as default
// assign the name defined in connection variable
'database' => 'mysql', // mysql is connection name, can be anything
// config database connections
'connection' => [
                        // name of this connection, used in above option only
            'mysql' => [
            'driver'    => 'mysql', //database type
            'host'      => 'localhost', //database host name, on local server it is 'localhost'
            'database'  => 'your database name', // database name
            'username'  => 'your username',  // database username
            'password'  => 'your password',  // user password
            ],
        ],
// set the location of application withour trailing slash
// in my case it is 'http://localhost/todolist'
'root' => '', // example 'http://localhost/todolist' or http://demo.findalltogeher.com
// register apps which are defined in application folder
'apps' => [
        'auth',
        'todo',
        'admin',
        ],
// secret string for encreption
'secret' => 'this_is_secret_string', // example 'fa&k+j@sdf!has^dh-iu!d#dh$sd'
];