<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;

/**
 *  Login Controller
 */
class LoginController
{
    use TemplateTrait;

    public function __construct()
    {
        $this->addAssets();
        $this->setTitle('Login');
        $this->layout('Login');
    }

    public function addAssets()
    {
        $this->setAssets( new Assets );
        $this->addStyle('login');
    }
}
