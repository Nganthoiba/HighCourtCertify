<?php
//Configuration set up file
Config::set("app_name", "Application For Copy");/*Name of the application*/
Config::set("site_name", "Application For Copy");
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
Config::set('host', 'http://copying.nic.in');

/*** Database Configuration ***/
Config::set('DB_HOST', 'localhost');
/*
    For setting database driver. Use the followings:
 * 1. mysql     :-  for MySql Database Server
 * 2. pgsql     :-  for Postgres Database Server
 * 3. sqlsrv    :-  for Microsoft SQL Database Server
 */

Config::set('DB_CONFIG', [
    "DB_HOST" => "localhost",
    "DB_PORT" => 5432,
    "DB_DRIVER"=>"pgsql", /*Database driver*/
    "DB_NAME" => "applications_for_copy",
    "DB_USERNAME" => "postgres",
    "DB_PASSWORD" => "postgres",//postgres
    "PERSISTENT" => false
]);

/********* Paypal Configuration ********/
Config::set("business", "khangembamc@gmail.com");//paypal business account
Config::set("IdentityToken","xyvzY6f0sSDiz5W1G9Z-kpTdQDka1JIxTFVKIcaCFdM31R0ZIXExkJoL7ly");
Config::set("IsSandbox",true);
Config::set("currency_code","INR");
Config::set("return_url",Config::get('host')."/Paypal/RedirectFromPaypal");
Config::set("cancel_return",Config::get('host')."/Paypal/CancelFromPaypal");
Config::set("notify_url",Config::get('host')."/Paypal/NotifyFromPaypal");
Config::set("test_url","https://www.sandbox.paypal.com/cgi-bin/webscr");
Config::set("prod_url","https://www.paypal.com/cgi-bin/webscr");
/**** End of Paypal Configuration *****/
