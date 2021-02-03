<?php declare(strict_types=1);

namespace app\controller;

/**
 *  App Controller
 */
final class AppController
{
    public function __construct()
    {
    }

    /**
     *  Load Router Uri
     */
    public function router() : void
    {
        $load = $this->getUri();
        new $load();
    }

    /**
     *  Get Uri
     */
    private function getUri()
    {
        $path = $_SERVER['REQUEST_URI'];

        $relativeClass = ucfirst(explode('/', $path)[1]);

        if( $relativeClass === 'Index' || $relativeClass === 'App' || $relativeClass == '' ) {
            return 'app\controller\IndexController';
        }

        $file = __DIR__ . '/' . $relativeClass . 'Controller.php';

        if( file_exists($file) ) {
            return 'app\controller\\' . $relativeClass . 'Controller';
        }

        return 'app\controller\NotFoundController';
    }
}
