<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;

/**
 *  Index Controller
 */
class IndexController
{
    use TemplateTrait;

    public function __construct()
    {
        $this->setTitle('Home');
        $this->layout('index');
    }
}
