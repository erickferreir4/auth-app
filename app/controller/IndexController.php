<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\traits\AccountTop;
use app\traits\AccountTrait;

/**
 *  Index Controller
 */
class IndexController
{
    use TemplateTrait;
    use AccountTop;
    use AccountTrait;

    public $data;

    public function __construct()
    {
        session_start();
        if( empty($_SESSION['user']) ) {
            header('location: /login');
        }

        $this->data = $this->getInfo($_SESSION['user']);

        $this->addAssets();
        $this->setTitle('Home');
        $this->layout('index');
    }

    /**
     *  Load assets in page
     *
     *  @return void
     */
    public function addAssets()
    {
        $this->setAssets( new Assets );
        $this->addStyle('index');
        $this->addScript('index');
    }

    /**
     *  Load template
     *
     *  @return string
     */
    public function personalInfo() : string
    {
        $info = file_get_contents(__DIR__ . '/../templates/personal_info.html');

        $info = str_replace('[[NAME]]', isset($this->data->username) ? $this->data->username : 'empty', $info);
        $info = str_replace('[[EMAIL]]', isset($this->data->email) ? $this->data->email : 'empty', $info);
        $info = preg_replace(
            '/src=.*[[PHOTO]].*"/', 
            isset($this->data->photo) ? 'src="'.$this->data->photo.'"' : 'src="/assets/imgs/[[PHOTO]].png"', $info
        );
        $info = str_replace('[[BIO]]', isset($this->data->bio) ? $this->data->bio : 'empty', $info);
        $info = str_replace('[[PHONE]]', isset($this->data->phone) ? $this->data->phone : 'empty', $info);

        return $info;
    }
}
