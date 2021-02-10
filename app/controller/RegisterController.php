<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\model\RegisterModel;
use app\helpers\Transaction;
use app\lib\LoggerHTML;

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

        $this->hasPost();
    }

    public function addAssets()
    {
        $this->setAssets( new Assets );
        $this->addStyle('register');
    }

    public function hasPost()
    {
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $passwd = isset($_POST['passwd']) ? $_POST['passwd'] : null;
        $conf_passwd = isset($_POST['conf-passwd']) ? $_POST['conf-passwd'] : null;
        var_dump($_POST);
        

        if( $email && $passwd & $conf_passwd ) {
            echo 1;
        }
        else {
            echo 2;
        }


        Transaction::open('database');
        Transaction::setLogger( new LoggerHTML('log.html') );

        $model = new RegisterModel();

        Transaction::close();



    }

}
