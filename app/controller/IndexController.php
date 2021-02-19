<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\traits\AccountTop;

/**
 *  Index Controller
 */
class IndexController
{
    use TemplateTrait;
    use AccountTop;

    public function __construct()
    {
        $this->addAssets();
        $this->setTitle('Home');
        $this->layout('index');

        //session_start();
        //var_dump($_SESSION['user']);

    }

    public function addAssets()
    {
        $this->setAssets( new Assets );
        $this->addStyle('index');
        $this->addScript('index');
    }

    public function personalInfo()
    {
        $info = file_get_contents(__DIR__ . '/../templates/personal_info.html');

        return $info;
    }
}
