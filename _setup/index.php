<?php
/**
 * IP-Manager - index.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file index.php
 * @date 09.01.2022 16:53
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

const SETUP_STATUS_FILE = __DIR__ . '/../_setup/data/setup.ini';

// Check if PHP-Version is >= 8.0
if (PHP_VERSION < 8.0) die("<code>PHP-Version: <b>".PHP_VERSION."</b><br/>PHP-Version needs to be 8.0 or greater!</code>");

// Check if dependencies are installed
if (!is_dir(__DIR__ . '/../vendor')) die("<code>Dependencies are not installed.<br />Please install all dependencies using composer!</code>");

// Load files
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../_init/init.d/core.init.php';
require_once __DIR__ . '/../_config/mySQL.php';

// Imports
use SarpexIT\IPManager\Setup\Setup;

// Create Setup Object
$stp = new Setup(SETUP_STATUS_FILE);

// Define accessible pages
$pages = [
    '/welcome'          => 'pages/welcome.ctp',
    '/license'          => 'pages/license.ctp',
    '/requirements'     => 'pages/requirements.ctp',
    '/database'         => 'pages/database.ctp',
    '/database/init'    => 'scripts/db_init.php',
    '/configuration'    => 'pages/configuration.ctp',
    '/summary'          => 'pages/summary.ctp'
];

// Check if setup is already finished
if (intval($stp->getSetupProperty("status", "finished")) !== 0) {
    die("<code><p>Access denied!<br />The WebApp is already configured!</p><p>Click <a href='../'>here</a> to access the app.</p></code>");
}

// Listen for setup exit
if (isset($_GET['exit'])) $stp->exitSetup();

// Update setup path
if (isset($_GET['update']) && array_key_exists($_GET['path'], $pages) && $stp->getSetupProperty("setup_config", "path") != $_GET['path']) $stp->setSetupProperty("setup_config", "path", $_GET['path']);

// Listen for appearance switches
if (isset($_GET['toggleAppearance'])) $stp->setSetupProperty("setup_config", "darkmode", !boolval($stp->getSetupProperty("setup_config", "darkmode")));

// Listen for language switches
if (isset($_GET['lng']) && array_key_exists($_GET['lng'], $stp->getSetupLanguages()) && $stp->getSetupProperty("setup_config", "lng") != $_GET['lng']) $stp->setSetupProperty("setup_config", "lng", $_GET['lng']);

// Redirect user back to page if setup got interrupted
if (!isset($_GET['update']) && $_GET['path'] != $stp->getSetupProperty("setup_config", "path")) {
    header('Location: ?path=' . $stp->getSetupProperty("setup_config", "path"));
}

// Load language file
file_exists($lf = $stp->getSetupLanguages()[$stp->getSetupProperty("setup_config", "lng")]) ? require_once $lf : die("<code>Error: Language file <i>" . $stp->getSetupProperty("setup_config", "lng") . "</i> could not be loaded!</code>");

// Load page
file_exists($file = __DIR__ . $pages[$stp->getSetupProperty("setup_config", "path")]) ? require_once $file : die("<code>Error: Page file for page <i>'" . $stp->getSetupProperty("setup_config", "path") . "'</i> could not be loaded!</code>");