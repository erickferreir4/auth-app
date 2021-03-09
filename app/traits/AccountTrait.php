<?php declare(strict_types=1);

namespace app\traits;

use app\helpers\Transaction;
use app\model\AccountModel;
use app\lib\LoggerHTML;
use Exception;

/**
 *  Account Trait
 */
trait AccountTrait
{
    /**
     *  Get info by email
     *
     *  @param {string} $email - email user
     */
    private function getInfo(string $email)
    {
        try {
            Transaction::open('database');
            Transaction::setLogger(new LoggerHTML('log.html'));

            $model = new AccountModel;
            $result = $model->find($email);

            Transaction::close();
            return $result;

        } catch (  Exception $e) {
            Transaction::log($e->getMessage());
            Transaction::rollback();
        }
    }
}
