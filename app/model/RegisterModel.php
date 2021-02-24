<?php declare(strict_types=1);

namespace app\model;

use app\traits\ModelTrait;

/**
 *  Register Model
 */
class RegisterModel
{
    use ModelTrait;

    /**
     *  Save user info in db
     *
     *  @param {stdClass} $data - user object info
     *  @return bool
     */
    public function save($data) : bool
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
