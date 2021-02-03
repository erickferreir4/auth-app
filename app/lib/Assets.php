<?php declare(strict_types=1);

namespace app\lib;

use app\interfaces\IAssets;

/**
 *  Assets
 */
final class Assets implements IAssets
{
    /**
     *  Load styles
     *  @param {string} $style - name style
     *  @return {string} $src - style html
     */
    public function loadStyle(string $style)
    {
        $src = file_get_contents(__DIR__ . '/../templates/css.html');
        $src = str_replace('[[STYLE]]', '/assets/css/'.$style.'.css', $src);

        return $src;
    }

    /**
     *  Load script
     *  @param {string} $scrpt - name script
     *  @return {string} $src - script html
     */
    public function loadScript(string $script)
    {
        $src = file_get_contents(__DIR__ . '/../templates/js.html');
        $src = str_replace('[[SCRIPT]]', '/assets/js/'.$script.'.js', $src);

        return $src;
    }
}
