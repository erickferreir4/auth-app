<?php declare(strict_types=1);

namespace app\model;

use app\helpers\Transaction;
use app\traits\ModelTrait;
use PDO;


class RegisterModel
{
    use ModelTrait;

    public function save($data)
    {
        $sql = 'INSERT INTO users
                    (email, passwd)
                VALUES
                    (:email, :passwd)';

        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue('email', $data->email);
        $stmt->bindValue('passwd', password_hash($data->passwd, PASSWORD_DEFAULT));

        return $stmt->execute() ? true : false;
    }
}
