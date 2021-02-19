<?php declare(strict_types=1);

namespace app\model;

use app\helpers\Transaction;
use PDO;

class LoginModel
{
    private static $conn;

    public function __construct()
    {
        $this->setConnection();
    }

    private function setConnection() : void
    {
        if( empty(self::$conn) ) {
            self::$conn = Transaction::get();
            $this->createTableUsers();
        }
    }

    private function createTableUsers()
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

    public function all()
    {
        $sql = 'SELECT * FROM users';

        $result = self::$conn->query($sql);

        return $result->fetchAll(PDO::FETCH_CLASS, 'stdClass');
    }

    public function find(string $email)
    {
        $sql = 'SELECT * FROM users
                WHERE
                    email =: email';

        
        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}
