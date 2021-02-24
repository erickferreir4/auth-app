<?php declare(strict_types=1);

namespace app\model;

use app\traits\ModelTrait;
use app\helpers\Transaction;

/**
 *  Login Model
 */
class LoginModel
{
    use ModelTrait;

    /**
     *  Save google user
     *
     *  @param {stdClass} $data - user info
     *  @return bool
     */
    public function googleSave($data) : bool
    {
        if( !empty($this->find($data->email)) ) {
            return false;
        }

        $sql = 'INSERT INTO users
                    (email, username, photo)
                VALUES
                    (:email, :username, :photo)';

        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':email', $data->email);
        $stmt->bindValue(':username', $data->username);
        $stmt->bindValue(':photo', $data->photo);

        Transaction::log($sql);

        return $stmt->execute() ? true : false;
    }
}
