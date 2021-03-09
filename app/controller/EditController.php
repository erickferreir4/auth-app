<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\traits\AccountTop;
use app\traits\AccountTrait;
use app\model\EditModel;
use app\helpers\Transaction;
use app\lib\LoggerHTML;
use stdClass;
use Exception;
use DateTime;

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
        if( empty($_SESSION['user']) ) {
            header('location: /login');
        }

        $this->data = $this->getInfo($_SESSION['user']);

        $this->callMethod();
        $this->addAssets();
        $this->setTitle('Edit');
        $this->layout('edit');
    }

    /**
     *  add assets in page
     *
     *  @return void
     */
    public function addAssets() : void
    {
        $this->setAssets( new Assets );
        $this->addStyle('edit');
        $this->addScript('edit');
    }

    /**
     *  Call endpoint front
     *
     *  @return void
     */
    public function callMethod() : void
    {
        $path = preg_split('/(\/|\?)/', $_SERVER['REQUEST_URI'])[2];
        $method = $path === null ? '' : $path;
        if( method_exists($this, $method) ) {
            $this->$method();
        }
    }

    /**
     *  load template edit
     *
     *  @return string
     */
    public function personalEdit() : string
    {
        $info = file_get_contents(__DIR__ . '/../templates/personal_edit.html');

        $info = str_replace('[[NAME]]', isset($this->data->username) ? $this->data->username : '', $info);
        $info = str_replace('[[EMAIL]]', isset($this->data->email) ? $this->data->email : '', $info);
        $info = preg_replace(
            '/src=.*[[PHOTO]].*"/', 
            isset($this->data->photo) ? 'src="'.$this->data->photo.'"': 'src=/assets/imgs/[[PHOTO]].png', $info
        );
        $info = str_replace('[[BIO]]', isset($this->data->bio) ? $this->data->bio : '', $info);
        $info = str_replace('[[PHONE]]', isset($this->data->phone) ? $this->data->phone : '', $info);
        $info = str_replace('[[OLD_FILE]]', isset($this->data->photo) ? $this->data->photo : '', $info);

        return $info;
    }

    /**
     *  Transaction save in db
     *
     *  @return void
     */
    public function save() : void
    {
        $data = new stdClass;

        $data->username = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data->email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data->bio = filter_var($_POST['bio'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data->phone = filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data->passwd = filter_var($_POST['passwd'], FILTER_SANITIZE_SPECIAL_CHARS);

        $date = new DateTime();
        $uploaddir = '/var/www/html/app/assets/uploads/';
        $filename = $date->getTimestamp() . '-'. basename($_FILES['userfile']['name']);
        $uploadfile = $uploaddir . $filename;


        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            $data->photo = '/assets/uploads/' . $filename;

            $oldfile = '/var/www/html/app' . $_POST['old-userfile'];
            if(file_exists($oldfile)) {
                unlink($oldfile);
            }
        } 
        else if (!empty($_POST['old-userfile'])) {
            $oldfile = $_POST['old-userfile'];
            $data->photo = $oldfile;
        }

        try {
            Transaction::open('database');
            Transaction::setLogger( new LoggerHTML('log.html') );

            $model = new EditModel;
            $model->save($data);

            Transaction::close();

            header('location: /');

        } catch( Exception $e ) {
            Transaction::log($e->getMessage());
            Transaction::rollback();
            header('location: /');
        }
    }
}
