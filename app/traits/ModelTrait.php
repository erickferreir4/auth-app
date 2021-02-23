<?php declare(strict_types=1);

namespace app\traits;

use app\helpers\Transaction;

trait ModelTrait
{
    private static $conn;

    public function __construct()
    {
        $this->setConnection();
    }

    /**
     *  Set Connection
     *
     *  @return void
     */
    private function setConnection() : void
    {
        if( empty(self::$conn) ) {
            self::$conn = Transaction::get();
            $this->createTableUsers();
        }
    }

    /**
     *  Create table if not exists
     *
     *  @return void
     */
    private function createTableUsers() : void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS users
                (
                    id INTEGER PRIMARY KEY,
                    email VARCHAR(250) NOT NULL,
                    passwd VARCHAR(25) NOT NULL,
                    photo VARCHAR(250),
                    username VARCHAR(100),
                    bio VARCHAR(750),
                    phone VARCHAR(20)
                )'; 

        Transaction::log($sql);
        self::$conn->exec($sql);
    }

    /**
     *  Find in database
     *
     * @param {string} $email - email find in database
     * @return object result
     */
    public function find(string $email) 
    {
        $sql = 'SELECT * FROM users
                WHERE
                    email = :email';

        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function all()
    {
        $sql = 'SELECT * FROM users';

        $result = self::$conn->query($sql);

        return $result->fetchAll(PDO::FETCH_CLASS, 'stdClass');
    }
}


