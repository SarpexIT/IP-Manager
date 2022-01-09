<?php
/**
 * IP-Manager - index.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file index.php
 * @date 09.01.2022 16:50
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2021–)
 * @author Sarpex IT Services <info@sarpex.eu> (2021–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

/*
|--------------------------------------------------------------------------
| Load setup information
|--------------------------------------------------------------------------
|
| Import Setup status and set current setup status
|
*/
intval(parse_ini_file(__DIR__ . '/_setup/data/setup.ini')['finished']) !== 1 ? define('SETUP_FINISHED', false) : define('SETUP_FINISHED', true);

/*
|--------------------------------------------------------------------------
| Start setup / Initialize the app
|--------------------------------------------------------------------------
|
| Start Setup or run initialization.
|
*/
!SETUP_FINISHED ? header('Location: ' . (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/_setup/') : require_once __DIR__ . '/_init/init.php';