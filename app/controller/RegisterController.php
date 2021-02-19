<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets; 
use app\model\RegisterModel; 
use app\helpers\Transaction;
use app\lib\LoggerHTML;
use Exception;
use stdClass;

/**
 *  Regsiter Controller
 */
class RegisterController
{
    use TemplateTrait;

    private static $model;
    private $userExists;

    public function __construct() 
    {
        $this->hasPost();
        $this->addAssets();
        $this->setTitle('Register');
        $this->layout('register');
    }

    /**
     *  Add Assets to page
     */
    public function addAssets() : void
    {
        $this->setAssets( new Assets );
        $this->addStyle('register');
        $this->addScript('register');
    }

    /**
     *  Verify post data
     */
    public function hasPost() : void
    {
        session_start();
        if( isset($_SESSION['user']) ) {
            header('location: /');
        }
        //var_dump($_SESSION);

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
        }

        $_POST = [];
        //session_destroy();
    }

    /**
     *  Authenticate user
     *  @param {object} $data - data user 
     */
    private function authUser(stdClass $data) : bool
    {
        try {
            Transaction::open('database');
            Transaction::setLogger( new LoggerHTML('log.html') );

            self::$model = new RegisterModel();

            if( $this->userNotExists($data->email) ) {
                if($this->saveUser($data)) {
                    Transaction::close();
                    return true;
                }
            }
            else {
                $this->userExists = true;
            }

            Transaction::close();
            return false;

        } catch( Exception $e ) {
            Transaction::log($e->getMessage());
            Transaction::rollback();
            return false;
        }
        
    }

    /**
     *  User exists
     *  @param {string} $email - user email
     */
    private function userNotExists(string $email) : bool
    {
        return empty(self::$model->find($email));
    }

    /**
     *  Save user
     *  @param {stdClass} $data - user data
     */
    private function saveUser( stdClass $data ) : bool
    {
        return self::$model->save($data);
    }


}
