<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\model\LoginModel;
use app\helpers\Transaction;
use app\lib\LoggerHTML;
use stdClass;

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
        $this->hasPost();
    }

    public function addAssets()
    {
        $this->setAssets( new Assets );
        $this->addStyle('login');
    }

    public function hasPost() : void
    {
        //session_start();
        //if( isset($_SESSION['user']) ) {
        //    header('location: /');
        //}

        $data = new stdClass;

        $data->email = isset($_POST['email']) ? 
                    filter_var($_POST['email'], FILTER_SANITIZE_EMAIL ) : null;

        $data->passwd = isset($_POST['passwd']) ? 
                    filter_var($_POST['passwd'], FILTER_SANITIZE_SPECIAL_CHARS) : null;
        
        if( $data->email && $data->passwd ) {
            $this->authUser($data);
            //if( $this->authUser($data) ) {
                //$_SESSION['user'] = $data->email;
                //header('location: /');
            //}
        }
    }

    public function authUser(stdClass $data) : bool
    {
        try {
            Transaction::open('database');
            Transaction::setLogger( new LoggerHTML('log.html') );

            $model = new LoginModel;
            var_dump($model->all());

        } catch( Exception $e ) {
            Transaction::log($e->getMessage());
            Transaction::rollback();
        }   

        return true;
    }
}
