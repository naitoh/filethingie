<?php
/**
 * PHPUnit bootstrap file.
 *
 * Defines PHPUNIT_TESTING to prevent ft2.php from executing its main block,
 * then sets up required constants and loads function definitions.
 */

define('PHPUNIT_TESTING', true);

// Define constants required by ft2.php functions.
define('USERNAME', 'testuser');
define('PASSWORD', 'testpass');
define('DIR', '.');
define('LANG', 'en');
define('FILEBLACKLIST', 'ft2.php config.php');
define('FOLDERBLACKLIST', 'plugins js css locales');
define('FILETYPEBLACKLIST', 'php phtml php3 php4 php5');
define('FILETYPEWHITELIST', '');

// Initialize global $ft array.
$ft = array();
$ft['settings'] = array();
$ft['groups'] = array();
$ft['users'] = array();
$ft['plugins'] = array();

// Load function definitions from ft2.php (main block is skipped by PHPUNIT_TESTING guard).
require_once __DIR__ . '/../ft2.php';
