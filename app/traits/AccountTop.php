<?php declare(strict_types=1);

namespace app\traits;

/**
 *  Account Top session
 */
trait AccountTop
{
    public function accountTop()
    {
        $top = file_get_contents(__DIR__ . '/../templates/account_top.html');
        return $top;
    }
}
