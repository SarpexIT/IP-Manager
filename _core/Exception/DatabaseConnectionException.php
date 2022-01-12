<?php
/**
 * IP-Manager - DatabaseConnectionException.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file DatabaseConnectionException.php
 * @date 12.01.2022 21:28
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

namespace SarpexIT\IPManager\Exception;

use JetBrains\PhpStorm\Pure;

/**
 * DatabaseConnectionException is thrown when a configured database connection can not be established.
 */
class DatabaseConnectionException extends \Exception
{
    protected $message = 'Database connection can not be established! Please check connection details!';


    #[Pure] public function errorMessage(): string
    {
        return $this->getMessage();
    }
}