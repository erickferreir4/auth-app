<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\traits\AccountTop;
use app\traits\AccountTrait;

/**
 * Edit Controller;
 */
class EditController
{
    use TemplateTrait;
    use AccountTop;
    use AccountTrait;

    public function __construct()
    {
        session_start();
        $this->data = $this->getInfo($_SESSION['user']);

        $this->addAssets();
        $this->setTitle('Edit');
        $this->layout('edit');
    }
    public function addAssets()
    {
        $this->setAssets( new Assets );
        $this->addStyle('edit');
        $this->addScript('edit');
    }
}
