<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\traits\AccountTop;

/**
 * Edit Controller;
 */
class EditController
{
    use TemplateTrait;
    use AccountTop;

    public function __construct()
    {
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
