<?php
/**
 * IP-Manager - SQL.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file SQL.php
 * @date 12.01.2022 20:56
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

namespace SarpexIT\IPManager\Storage;

use PDO;
use PDOException;
use PDOStatement;
use SarpexIT\IPManager\Exception\DatabaseConnectionException;

class SQL
{

    /**
     * @var PDO $pdo PHP-Data-Object to store the current database connection
     */
    private PDO $pdo;

    /**
     * Constructs a new database connection
     * @param string|null $host Database hostname (If null -> Value in Config is used)
     * @param int|null $port Database server port (If null -> Value in Config is used)
     * @param string|null $name Database name (If null -> Value in Config is used)
     * @param string|null $user Database username (If null -> Value in Config is used)
     * @param string|null $pass Database user password (If null -> Value in Config is used)
     * @param string $type Database type (default: mysql) (If null -> Value in Config is used)
     * @throws DatabaseConnectionException If database connection can not be established.
     */
    public function __construct(string $host = null, int $port = null, string $name = null, string $user = null, string $pass = null, string $type = 'mysql')
    {
        if (is_null($host) || is_null($port) || is_null($name) || is_null($user) || is_null($pass) || is_null($type)) {
            return;
        }

        if (!$this->setPDO($host, $port, $name, $user, $pass, true, $type)) throw new DatabaseConnectionException("The provided database connection credentials were invalid!");
    }

    /**
     * Checks a database connection
     * @param $host string Database hostname
     * @param $port int Database server port
     * @param $name string Database name
     * @param $user string Database username
     * @param $pass string Database user password
     * @param string $type Database type (default: mysql)
     * @return bool Returns true if database connection was established.
     */
    public static function checkDatabaseConnection(string $host, int $port, string $name, string $user, string $pass, string $type = 'mysql'): bool
    {
        try {
            $conn = new PDO($type . ":host=" . $host . ":" . $port . ";dbname=" . $name, $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Sets a new PHP-Data-Object
     * @param $host string Database hostname
     * @param $port int Database server port
     * @param $name string Database name
     * @param $user string Database username
     * @param $pass string Database user password
     * @param bool $checkConnection Check connection before saving
     * @param string $type Database type (default: mysql)
     * @return bool True if PDO was replaced/set
     */
    public function setPDO(string $host, int $port, string $name, string $user, string $pass, bool $checkConnection = false, string $type = 'mysql'): bool
    {
        if ($checkConnection) {
            if (!self::checkDatabaseConnection(
                $host,
                $port,
                $name,
                $user,
                $pass,
                $type)) return false;
        }
        $this->pdo = new PDO($type . ":host=" . $host . ":" . $port . ";dbname=" . $name, $user, $pass);
        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
        return true;
    }

    /**
     * Gets the currently saved PDO
     * @return PDO Current PHP-Data-Object
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    /**
     * Creates a new SQL-Statement
     * @param string $statement SQL-Statement to prepare
     * @param array $options Preparation options
     * @return bool|PDOStatement If successfully prepared -> PDOStatement
     */
    public function createStatement(string $statement, array $options = []): bool|PDOStatement
    {
        return $this->pdo->prepare($statement, $options);
    }

    /**
     * Destroys PDO connection and object
     * Warning: The SQL Object will become unusable!
     */
    public function close()
    {
        unset($this->pdo);
    }


}