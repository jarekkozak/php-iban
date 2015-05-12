<?php

namespace jarekkozak\widgets;

use yii\base\InvalidConfigException;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Kartik Select2 options helper.
 *
 * Siply add minimum necessary js scripts to run Select2 in ajax mode
 *
 *
 * ~~~
 *
 * $helper = new Select2Options([
 *      'url'=>"ajax action url",
 *      "config" => "custom select2 configurationsee kartik select2 doc"
 * ]);
 *
 * in select2 widget configuration us
 *
 * Select2::widget($helper->getConfig(['url'=>'url','options'=>[],'pluginOptions'=>......));
 *
 *
 * ~~~
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com
 */
class Select2AjaxConfig extends Object
{
    public $url = NULL;
    public $initValueText = '';
    public $options = [];

    public function init()
    {
        parent::init();
        if($this->url === NULL) {
            throw new InvalidConfigException('url must be provided');
        }
        $this->url = Url::to($this->url,true);
    }

    public function getConfig()
    {

        $out = [
            'options' => ['placeholder' => 'Enter data...'],
            'initValueText' => $this->initValueText,
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => $this->url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {search:params.term}; }'),
                    'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(result) { return result.text; }'),
                'templateSelection' => new JsExpression('function (result) { return result.text; }'),
            ]
        ];
        return ArrayHelper::merge($out,$this->options);
    }

}