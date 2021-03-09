<?php declare(strict_types=1);

namespace app\model;

use app\traits\ModelTrait;

/**
 *  Edit Model
 */
class EditModel
{
    use ModelTrait;

    /**
     *  Edit save
     *  
     *  @param {object} $data - object save data
     *  @return boolean
     */
    public function save($data) : bool
    {
        $sql = 'UPDATE users
                SET username = :username,
                    email = :email,
                    photo = :photo,
                    bio = :bio,
                    phone = :phone,
                    passwd = :passwd
                WHERE
                    email = :email_id';

        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':username', $data->username);
        $stmt->bindValue(':email', $data->email);
        $stmt->bindValue(':photo', $data->photo);
        $stmt->bindValue(':bio', $data->bio);
        $stmt->bindValue(':phone', $data->phone);
        $stmt->bindValue(':passwd', password_hash($data->passwd, PASSWORD_DEFAULT));

        $stmt->bindValue(':email_id', $data->email);

        return $stmt->execute() ? true : false;
    }
}
