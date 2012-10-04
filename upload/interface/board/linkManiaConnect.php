<?php

/**
 * @author Adam Lavin (Lavoaster)
 * @copyright 2012
 * @license http://opensource.org/licenses/mit-license.php The MIT License
 */

/**
* Script type
*
*/
define( 'IPB_THIS_SCRIPT', 'api' );
define( 'IPB_LOAD_SQL'   , 'queries' );
define( 'IPS_PUBLIC_SCRIPT', 'index.php' );

require_once( '../../initdata.php' );/*noLibHook*/

//-----------------------------------------
// Main code
//-----------------------------------------

require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );/*noLibHook*/
require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );/*noLibHook*/

$_GET['app']        = 'core';
$_REQUEST['app']    = 'core';
$_GET['module']     = 'usercp';
$_GET['tab']        = 'core';
$_GET['area']       = 'managemaniaconnect';
$_REQUEST['area']   = 'managemaniaconnect';
$_GET['maniaconnect']      = 'process';

//-----------------------------------------
// Ignore auth key for live requests
//-----------------------------------------

define( 'IGNORE_AUTH_KEY', true );

ipsController::run();

exit();