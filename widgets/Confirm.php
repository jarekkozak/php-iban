<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jk\widgets;

/**
 * Description of Confirm
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class Confirm extends \yii\base\Widget
{

    public function run()
    {
        $this->view = \Yii::$app->getView();
        $bundle = ConfirmAsset::register($this->view);
        $bootbox = BootboxAsset::register($this->view);
        
        $js = <<<EOD
bootbox.setDefaults({
    locale: "pl",
});
EOD;
        $this->view->registerJs($js);
    }

}

\Yii::setAlias('@confirm-asset', dirname(__FILE__));

/**
 * Description of ConfirmAsset
 *
 * @author jarek
 */
class ConfirmAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@confirm-asset/assets/confirm';
    
    public $js = [
        'confirm.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}

