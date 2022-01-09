<?php
/**
 * IP-Manager - Setup.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file Setup.php
 * @date 09.01.2022 17:43
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

namespace SarpexIT\IPManager\Setup;

class Setup
{
    private const DEFAULT_LNG_DIR = __DIR__ . '/../../_lng';
    private string $statusFile = __DIR__ . '/../../_setup/data/setup.ini';

    /**
     * Setup constructor.
     * @param string|null $statusFile Absolute path to setup status file
     */
    public function __construct(?string $statusFile = null)
    {
        if (!is_null($statusFile)) $this->statusFile = $statusFile;
    }


    public function getSetupLanguages(?string $lngDir = null): array|false
    {
        $lngDir = is_null($lngDir) ? self::DEFAULT_LNG_DIR : $lngDir;
        if (!is_dir($lngDir)) return false;

        $scan = scandir($lngDir);
        unset($scan[0], $scan[1]);
        $lngs = [];
        foreach ($scan as $file) {
            if (!is_dir($lngDir . '/' . $file)) {
                $pathinfo = pathinfo($lngDir . '/' . $file);
                if ($pathinfo['extension'] == "ctp") {
                    $lngs[$pathinfo['filename']] = $lngDir . '/' . $file;
                }
            }
        }
        return $lngs;
    }

    public function setSetupProperty(string $section, string $property, mixed $value)
    {
        $config_data = parse_ini_file($this->statusFile, true);
        $config_data[$section][$property] = ($value == false) ? "0" : $value;
        $new_content = '';
        foreach ($config_data as $section => $section_content) {
            $section_content = array_map(function($value, $key) {
                return "$key=$value";
            }, array_values($section_content), array_keys($section_content));
            $section_content = implode("\n", $section_content);
            $new_content .= "[$section]\n$section_content\n";
        }
        file_put_contents($this->statusFile, $new_content);
    }

    public function getSetupProperty(string $section, string $property): mixed
    {
        $data = parse_ini_file($this->statusFile, true);
        return $data[$section][$property];
    }

    public function exitSetup()
    {
        $this->setSetupProperty("status", "finished", true);
        header("Location: ../");
    }

}