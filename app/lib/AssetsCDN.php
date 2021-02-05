<?php declare(strict_types=1);

namespace app\lib;

use app\interfaces\IAssets;

/**
 *  Assets CDN
 */
final class AssetsCDN implements IAssets
{
    /**
     *  Load CDN style
     */
    public function loadStyle( string $style )
    {
        $src = file_get_contents(__DIR__ . '/../templates/css.html');
        $src = str_replace('[[STYLE]]', $style, $src);

        return $src;
    }

    /**
     *  Load CDN script
     */
    public function loadScript( string $script )
    {
        $src = file_get_contents(__DIR__ . '/../templates/js.html');
        $src = str_replace('[[SCRIPT]]', $script, $src);

        return $src;
    }
}
