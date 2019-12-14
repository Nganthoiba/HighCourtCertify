<?php
//Configuration set up file
Config::set("app_name", "Applications For Copy");/*Name of the application*/
Config::set("site_name", "Applications For Copy");
Config::set("languages", array('en','fr'));
Config::set("default_time_zone", "Asia/Kolkata");
Config::set('routes', array(
    'admin'=>'_admin_'
));
Config::set('default_route', 'default');
Config::set('default_controller', 'Default');
Config::set('default_action', 'index');
Config::set('default_language', 'en');

//Domain configuration
//Config::set('host', 'http://192.168.225.42/php_mvc');
Config::set('host', 'http://copying.nic.in');

/*** Database Configuration ***/
Config::set('DB_HOST', 'localhost');
/*
    For setting database driver. Use the followings:
 * 1. mysql     :-  for MySql Database Server
 * 2. pgsql     :-  for Postgres Database Server
 * 3. sqlsrv    :-  for Microsoft SQL Database Server
 */
Config::set('DB_DRIVER', 'pgsql');//for postgres
Config::set('DBNAME', 'applications_for_copy');
Config::set('DB_USERNAME', 'postgres');
Config::set('DB_PASSWORD', 'postgres');
