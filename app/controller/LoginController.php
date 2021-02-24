<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\traits\GoogleTrait;
use app\interfaces\IController;
use app\lib\Assets;
use app\model\LoginModel;
use app\helpers\Transaction;
use app\lib\LoggerHTML;
use stdClass;
use Exception;
use Google_Client;
use Google_Service_Oauth2;

/**
 *  Login Controller
 */
class LoginController implements IController
{
    use TemplateTrait;
    use GoogleTrait;

    private static $model;
    private $user_failed;

    public function __construct()
    {
        session_start();
        $this->googleAuth();
        $this->hasPost();
        $this->addAssets();
        $this->setTitle('Login');
        $this->layout('Login');
    }

    /**
     *  Add assets to page
     *
     *  @return void
     */
    public function addAssets() : void
    {
        $this->setAssets( new Assets );
        $this->addStyle('login');
    }
    
    /**
     *  Has post form
     *
     *  @return void
     */
    public function hasPost() : void
    {
        if( isset($_SESSION['user']) ) {
            header('location: /');
        }

        $data = new stdClass;

        $data->email = isset($_POST['email']) ? 
                    filter_var($_POST['email'], FILTER_SANITIZE_EMAIL ) : null;

        $data->passwd = isset($_POST['passwd']) ? 
                    filter_var($_POST['passwd'], FILTER_SANITIZE_SPECIAL_CHARS) : null;
        
        //Transaction::open('database');
        //Transaction::setLogger( new LoggerHTML('log.html') );

        //self::$model = new LoginModel;
        //$result = self::$model->all();
        //echo '<pre>';
        //var_dump($result);

        //Transaction::close();


        if( $data->email && $data->passwd ) {
            if( $this->authUser($data) ) {
                $_SESSION['user'] = $data->email;
                header('location: /');
            }
            else {
                $this->user_failed = true;
            }
        }

        $_POST = [];
    }

    /**
     *  Authenticate user
     *
     *  @param {stdClass} $data - object post form
     *  @return boolean
     */
    public function authUser($data) : bool
    {
        try {
            Transaction::open('database');
            Transaction::setLogger( new LoggerHTML('log.html') );

            self::$model = new LoginModel;
            $result = self::$model->find($data->email);

            if( !empty($result) ) {
                return password_verify($data->passwd, $result->passwd);
            }

            Transaction::close();
            return FALSE;
        } catch( Exception $e ) {
            Transaction::log($e->getMessage());
            Transaction::rollback();
        }   

        return FALSE;
    }

    public function googleAuth()
    {
        $client = $this->googleClient();

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // get profile info
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $data = new stdClass;
            $data->username =  $google_account_info->name;
            $data->email =  $google_account_info->email;
            $data->photo =  $google_account_info->picture;

            //var_dump($data);
            try {
                Transaction::open('database');
                Transaction::setLogger( new LoggerHTML('log.html') );

                self::$model = new LoginModel;
                self::$model->googleSave($data);

                Transaction::close();

                $_SESSION['user'] = $data->email;
                header('location: /');

            } catch( Exception $e ) {
                Transaction::log($e->getMessage());
                Transaction::rollback();
            }   
        } 
    }
}
