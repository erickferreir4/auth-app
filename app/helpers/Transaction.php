<?php declare(strict_types=1);

namespace app\helpers;

use app\helpers\ConnectionFactory;
use app\interfaces\ILogger;
use PDO;

/**
 *  Transaction
 */
class Transaction
{
    private static $conn;
    private static $logger;

    private function __construct()
    {
    }

    /**
     *  Open connection database
     *
     *  @param {string} $database - ini file in config
     */
    public static function open(string $database) : void
    {
        if( empty(self::$conn) ) {
            self::$conn = ConnectionFactory::open($database);
            self::$conn->beginTransaction();
        }
    }

    /**
     *  Get PDO connection
     *
     *  @return - PDO connection
     */
    public static function get() : PDO
    {
        return self::$conn;
    }

    /**
     *  Rollback database
     */
    public static function rollback() : void
    {
        if( self::$conn ) {
            self::$conn->rollback();
            self::$conn = null;
        }
    }


    /**
     *  Finish(close connection)
     */
    public static function close() : void
    {
        if( self::$conn ) {
            self::$conn->commit();
            self::$conn = null;
        }
    }

    /**
     *  Set logger class
     *
     *  @param {ILogger} $logger - class logger 
     */
    public static function setLogger(ILogger $logger) : void
    {
        self::$logger = $logger; 
    }
    
    /**
     *  Register log 
     *
     *  @param {string} $message - message to register
     */
    public static function log(string $message) : void
    {
        self::$logger->write($message);
    }
}
