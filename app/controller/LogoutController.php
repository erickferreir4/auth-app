<?php declare(strict_types=1);

namespace app\controller;

/**
 *  Logout Controller
 */
class LogoutController
{
    public function __construct()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        header('location: /login');
    }
}
