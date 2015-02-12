<?php
namespace jk\widgets;

use yii\web\AssetBundle;

/**
 * @author Jaroslaw Kozak <jaroslaw.kozak68@gmail.com>
 */
class BootboxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/bootbox';
    
    public $css = [
    ];
    
    public $js = [
        'bootbox.js',
    ];
    
    public $depends = [
    ];
    
}
