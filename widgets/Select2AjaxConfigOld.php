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
class Select2AjaxConfigOld extends Object
{
    public $url = NULL;
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
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => $this->url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                    'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                ],
                'initSelection' => $this->initSelection(),
            ]
        ];
        return ArrayHelper::merge($out,$this->options);
    }

    /**
     * Wygenerowanie skryptu callback dla select2
     * @param type $url
     */
    public function initScript()
    {
        return <<< SCRIPT
function (element, callback) {
    var id=$(element).val();
    if (id !== "") {
        $.ajax("$this->url&id=" + id, {
            dataType: "json"
        }).done(function(data) { callback(data.results);});
    }
}
SCRIPT;
    }

    public function initSelection()
    {
        return new JsExpression($this->initScript());
    }
}