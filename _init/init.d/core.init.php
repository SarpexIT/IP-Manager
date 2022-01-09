<?php
/**
 * IP-Manager - core.init.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file core.init.php
 * @date 09.01.2022 17:29
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

const CORE_DIRECTORY = __DIR__ . '/../../_core';

function load_classes($dir) {
    if (is_dir($dir)) {
        $scan = scandir($dir);
        unset($scan[0], $scan[1]);

        foreach ($scan as $class) {
            if (is_dir($dir . '/' . $class)) {
                load_classes($dir . '/' . $class);
            } else {
                if (str_contains($class, '.php')) {
                    require_once $dir . '/' . $class;
                }
            }
        }
    }
}

// Load classes in core directory
load_classes(CORE_DIRECTORY);