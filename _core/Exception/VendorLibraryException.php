<?php
/**
 * IP-Manager - VendorLibraryException.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file VendorLibraryException.php
 * @date 19.01.2022 20:31
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

namespace SarpexIT\IPManager\Exception;

use JetBrains\PhpStorm\Pure;

class VendorLibraryException extends \Exception
{

    protected $message = 'Vendor libraries can not be loaded because of missing vendor library';

    #[Pure] public function errorMessage(): string
    {
        return $this->getMessage();
    }

}