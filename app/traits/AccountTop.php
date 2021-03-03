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

        $top = str_replace(
            '[[EMAIL]]', 
            isset($this->data->email) ? $this->data->email : 'empty', $top
        );

        $top = str_replace(
            '[[EMAIL]]', 
            isset($this->data->email) ? $this->data->email : 'empty', $top
        );

        $top = preg_replace(
            '/src=.*[[PHOTO]].*"/', 
            isset($this->data->photo) ? 'src='.$this->data->photo : 'src=/assets/imgs/[[PHOTO]].png', $top
        );

        return $top;
    }
}
