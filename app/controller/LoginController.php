<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\traits\SocialTrait;
use app\interfaces\IController;
use app\lib\Assets;
use app\model\LoginModel;
use app\helpers\Transaction;
use app\lib\LoggerHTML;
use stdClass;
use Exception;
use Google_Service_Oauth2;

/**
 *  Login Controller
 */
class LoginController implements IController
{
    use TemplateTrait;
    use SocialTrait;

    private static $model;
    private $user_failed;

    public function __construct()
    {
        session_start();
        $this->facebookAuth();
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

    /**
     *  Authenticate Google
     *
     *  @return void
     */
    public function googleAuth() : void
    {
        $path = $_SERVER['REQUEST_URI'];

        if (isset($_GET['code']) && strpos($path, 'facebook') === false) {

            $client = $this->googleClient();
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // get profile info
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $data = new stdClass;
            $data->username =  $google_account_info->name;
            $data->email =  $google_account_info->email;
            $data->photo =  $google_account_info->picture;

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

    public function facebookAuth()
    {
        $path = $_SERVER['REQUEST_URI'];

        if( strpos($path, 'facebook') !== false && isset($_GET['code']) ) {

            $client = $this->facebookClient();
            $helper = $client->getRedirectLoginHelper();

            $accessToken = $helper->getAccessToken();

            $response = $client->get('/me?fields=id,name,email,picture', $accessToken->getValue());

            $user = $response->getGraphUser();
            var_dump($user);

        }
    }


}
