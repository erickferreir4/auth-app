<?php declare(strict_types=1);

namespace app\traits;

use app\interfaces\IAssets;
use app\lib\Assets;
use app\lib\AssetsCDN;

/**
 *  Template Trait
 */
trait TemplateTrait
{
    private $title;
    private $assets;
    private $styles;
    private $scripts;

    public function __construct()
    {
    }

    /**
     *  Load default layout
     *  @param {string} $layout - view name
     */
    private function layout(string $layout)
    {
        $this->general();
        require_once __DIR__ . '/../view/_includes/_head.php';
        require_once __DIR__ . '/../view/_includes/_header.php';
        require_once __DIR__ . '/../view/' . ucfirst($layout) . 'View.php';
        require_once __DIR__ . '/../view/_includes/_footer.php';
    }

    /**
     *  Set title page
     *  @param {string} $title - title page
     */
    private function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    /**
     *  Set assets class
     *  @param {IAssets} $assets - class load
     */
    private function setAssets( IAssets $assets ) : void
    {
        $this->assets = $assets;
    }

    /**
     *  Add style
     *  @param {string} $style - style assets
     */
    private function addStyle(string $style) : void
    {
        $this->styles = $this->assets->loadStyle($style) . $this->styles;
    }

    /**
     *  Add script 
     *  @param {string} $script - script assets
     */
    private function addScript(string $script) : void
    {
        $this->scripts = $this->assets->loadScript($script) . $this->scripts;
    }

    /**
     *  Load general assets
     */
    private function general() : void
    {
        $this->setAssets( new Assets );

        $this->addStyle('general');
        $this->addStyle('reset');
        $this->addScript('general');

        $this->setAssets( new AssetsCDN );
        $this->addStyle('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap');
    }
}
