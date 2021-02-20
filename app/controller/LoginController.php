<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
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
class LoginController
{
    use TemplateTrait;

    private static $model;
    private $user_failed;
    private $googleUrl;

    public function __construct()
    {
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
        session_start();
        if( isset($_SESSION['user']) ) {
            header('location: /');
        }

        $data = new stdClass;

        $data->email = isset($_POST['email']) ? 
                    filter_var($_POST['email'], FILTER_SANITIZE_EMAIL ) : null;

        $data->passwd = isset($_POST['passwd']) ? 
                    filter_var($_POST['passwd'], FILTER_SANITIZE_SPECIAL_CHARS) : null;
        
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
    public function authUser(stdClass $data) : bool
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
        $redirectUri = 'http://localhost:8082/login';

        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__ . '/../config/client_google.json');
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // get profile info
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name =  $google_account_info->name;

            var_dump($google_account_info);
            // now you can use this profile info to create account in your website and make user logged in.
        } else {
            $this->googleUrl = $client->createAuthUrl();
        }
    }
}
