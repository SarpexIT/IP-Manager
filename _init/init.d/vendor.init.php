<?php
/**
 * IP-Manager - vendor.init.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file vendor.init.php
 * @date 19.01.2022 20:30
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

// Import VendorLibraryException
use SarpexIT\IPManager\Exception\VendorLibraryException;
require_once __DIR__ . '/../../_core/Exception/VendorLibraryException.php';

// Check if composer dependencies are installed
if (!file_exists(__DIR__ . "/../../vendor")) {
    throw new VendorLibraryException();
}

// Load vendor libs
require_once __DIR__ . '/../../vendor/autoload.php';