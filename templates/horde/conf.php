<?php
/**
 * Horde Configuration File
 *
 * This file contains intial configuration settings for Horde.
 * It contains basic settings that allow you to log into Horde and
 * complete the configuration with configuration interface. The first
 * change you should do is to select a sensible authentication driver
 * and administrator user name.
 *
 * The only settings that might need changes if you are not running
 * Horde in a "default" setup are documented below.
 *
 * Strings should be enclosed in 'quotes'.
 * Integers should be given literally (without quotes).
 * Boolean values may be true or false (never quotes).
 *
 * $Id: ece403cee0a0710ffebe617031f2847d67550434 $
 */

// Determines how we generate full URLs (for location headers and
// such). Possible values are:
//   0 - Assume that we are not using SSL and never generate https URLS.
//   1 - Assume that we are using SSL and always generate https URLS.
//       NOTE: If you do this, you MUST hardcode the correct HTTPS port
//       number in $conf['server']['port'] below. Otherwise Horde will
//       be unable to generate correct HTTPS URLs when a user tries to
//       access Horde via a non-HTTPS port.
//   2 - Attempt to auto-detect, and generate URLs appropriately.
$conf['use_ssl'] = 1;

// What server name should we use? You'll probably know if you need to
// change this default; only in situations where you need to override
// what Apache thinks the server name is.
$conf['server']['name'] = $_SERVER['SERVER_NAME'];

// What port number is the webserver running on? Again, you shouldn't
// need to change the default, and you probably know it if you do. The
// exception is if you have $conf['use_ssl'] set to 1, as described
// above.
// $conf['server']['port'] = 80;

// What domain should we set cookies from? If you have a cluster that
// needs to share cookies, this might be '.example.com' - the leading
// '.' is important. Most likely, though, you won't have to change the
// default.
$conf['cookie']['domain'] = $_SERVER['SERVER_NAME'];

// What path should we set cookies to? For maximum security this should
// match the URL where Horde is on your webserver.
// If Horde is at /horde, then this should be '/horde'.
// If Horde is installed as the document root, then this
// needs to be '/' - NOT ''.
// ** BUT, if IE will be used to access Horde modules, you should read
//    this first (discussing issues with IE's Content Advisor):
//    http://lists.horde.org/archives/imp/Week-of-Mon-20030113/029149.html
$conf['cookie']['path'] = '/';

// Disable the test script (horde/test.php)? For security reasons, this is
// disabled by default.
$conf['testdisable'] = true;

// YOU SHOULDN'T CHANGE ANTHING BELOW THIS LINE.
$conf['debug_level'] = E_ALL & ~E_NOTICE;
$conf['umask'] = 077;
$conf['compress_pages'] = true;
$conf['max_exec_time'] = 0;
$conf['session']['name'] = 'Horde';
$conf['session']['cache_limiter'] = 'nocache';
$conf['session']['max_time'] = 72000;
$conf['session']['timeout'] = 0;
$conf['auth']['admins'] = array('Administrator');
$conf['auth']['driver'] = 'auto';
$conf['auth']['params'] = array('username' => 'Administrator');
$conf['prefs']['driver'] = 'Sql';
$conf['portal']['fixed_blocks'] = array();
$conf['imsp']['enabled'] = false;
$conf['kolab']['enabled'] = false;
$conf['log']['priority'] = 'INFO';
$conf['log']['ident'] = 'HORDE';
$conf['log']['name'] = 'php://stdout';
$conf['log']['type'] = 'stream';
$conf['log']['enabled'] = true;
$conf['sql']['username'] = $_ENV['HORDE_SQL_USERNAME'];
$conf['sql']['password'] = $_ENV['HORDE_SQL_PASSWORD'];
$conf['sql']['hostspec'] = $_ENV['HORDE_SQL_HOST'];
$conf['sql']['port'] = $_ENV['HORDE_SQL_PORT'];
$conf['sql']['protocol'] = 'tcp';
$conf['sql']['database'] = $_ENV['HORDE_SQL_DATABASE'];
$conf['sql']['charset'] = 'utf-8';
$conf['sql']['ssl'] = false;
$conf['sql']['splitread'] = false;
$conf['sql']['logqueries'] = false;
$conf['sql']['phptype'] = 'mysqli';
$conf['nosql']['phptype'] = false;
$conf['share']['no_sharing'] = false;
$conf['share']['auto_create'] = true;
$conf['share']['world'] = true;
$conf['share']['any_group'] = false;
$conf['share']['hidden'] = false;
$conf['share']['cache'] = false;
$conf['share']['driver'] = 'Sqlng';
$conf['group']['params']['driverconfig'] = 'horde';
$conf['group']['driver'] = 'Sql';
$conf['alarms']['params']['driverconfig'] = 'horde';
$conf['alarms']['params']['ttl'] = 300;
$conf['alarms']['driver'] = 'Sql';
$conf['perms']['driverconfig'] = 'horde';
$conf['perms']['driver'] = 'Sql';
$conf['lock']['params']['driverconfig'] = 'horde';
$conf['lock']['driver'] = 'Sql';
$conf['token']['params']['driverconfig'] = 'horde';
$conf['token']['driver'] = 'Sql';
$conf['history']['params']['driverconfig'] = 'horde';
$conf['history']['driver'] = 'Sql';
$conf['davstorage']['params']['driverconfig'] = 'horde';
$conf['davstorage']['driver'] = 'Sql';
