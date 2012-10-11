<?php

/**
 * ManiaConnect-IPB - Allow users to sign into IPB through ManiaConnect service (ManiaPlanet)
 * 
 * @see         https://github.com/Anthodev/ManiaConnect-ipb
 * @copyright   Copyright (c) 2009-2012 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @author      Cedric Anthony (Cerovan)
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