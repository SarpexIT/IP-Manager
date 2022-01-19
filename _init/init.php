<?php
/**
 * IP-Manager - init.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file init.php
 * @date 09.01.2022 17:17
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

// Import RuntimeInitializationException
use SarpexIT\IPManager\Exception\RuntimeInitializationException;
require_once __DIR__ . '/../_core/Exception/RuntimeInitializationException.php';

// Define initialization components & order
$components = $order = [
    'core',
    'vendor',
    'config'
];

// Load initialization components
foreach ($components as $component) {
    $file = __DIR__ . '/init.d/' . $component . '.init.php';
    if (file_exists($file)) {
        require_once $file;
    }
    else {
        throw new RuntimeInitializationException("A required runtime component (" . $component . ") could not be initialized! Please check the initialization components!");
    }
}
