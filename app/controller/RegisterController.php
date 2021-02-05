<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;

/**
 *  Regsiter Controller
 */
class RegisterController
{
    use TemplateTrait;

    public function __construct() {

        $this->addAssets();
        $this->setTitle('Register');
        $this->layout('register');
    }

    public function addAssets()
    {
        $this->setAssets( new Assets );
        $this->addStyle('register');
    }
}
