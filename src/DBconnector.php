<?php

namespace Doginator;
use \PDO;

class DBconnector
{
    const HOST = '192.168.20.20';
    const DBNAME = 'doginator';
    const USER = 'root';
    const PASSWORD = '';

    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DBNAME, self::USER, self::PASSWORD);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}