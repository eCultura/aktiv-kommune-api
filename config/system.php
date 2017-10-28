<?php
/*
File  Name: system.php
File  URI: https://wiki.aktiv-kommune.no/
Description: Used in Aktiv komunne API files
Version: 0.1.0
Author: Arild M. Halvorsen
Author URI: http://about.me/arild
*/

define( 'HEADER_INC', '../header.inc.php');

$phpgw_info = array();
if (!file_exists(HEADER_INC))
{
    echo '... sorry, header.inc.php do not exist!';
    exit;
}

/**
* Include phpgroupware header
*/
require_once(HEADER_INC);

define( 'DB_HOST', $GLOBALS['phpgw_domain']['default']['db_host']);  // server hostname
define( 'DB_PORT', '5432');                                          // server port number
define( 'DB_NAME', $GLOBALS['phpgw_domain']['default']['db_name']);  // database name
define( 'DB_USER', $GLOBALS['phpgw_domain']['default']['db_user']);  // username
define( 'DB_PASS', $GLOBALS['phpgw_domain']['default']['db_pass']);  // password

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define( 'ROOT_DIR', dirname(__FILE__) );
define( 'BASE_DIR', '/');
define( "PORTICO_URL", "https://aktiv-kommune.no/1299/app/portico");
define( "PORTICO_IMAGES_URL", "https://aktiv-kommune.no/1299/app/portico/bookingfrontend/");
define( 'ORG_IMAGES_URL', 'http://ecultura.no/1299/wp-content/uploads/sites/8/');
define( 'MUNICIPALITY_ID', '1299');
define( 'LOCAL_COUNTRY_NAME', 'Norge' );
define( 'CRON_JOB_OUTPUT', true);