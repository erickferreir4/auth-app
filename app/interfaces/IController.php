<?php declare(strict_types=1);

namespace app\interfaces;

/**
 *  Interface Controller
 */
interface IController
{
    public function addAssets() : void;

    public function hasPost() : void;

    public function authUser($data) : bool;
}
