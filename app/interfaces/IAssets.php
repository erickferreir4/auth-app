<?php declare(strict_types=1);

namespace app\interfaces;

/**
 *  Interface Assets
 */
interface IAssets
{
    public function loadStyle( string $style );

    public function loadScript( string $script );
}
