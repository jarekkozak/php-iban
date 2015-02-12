<?php

namespace jk\helpers;

use yii\web\JsExpression;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Select2Helper
 *
 * @author jarek
 */
class Select2Helper
{

    /**
     * Wygenerowanie skryptu callback dla select2
     * @param type $url
     */
    public static function initScript($url)
    {
        return <<< SCRIPT
function (element, callback) {
    var id=$(element).val();
    if (id !== "") {
        $.ajax("$url&id=" + id, {
            dataType: "json"
        }).done(function(data) { callback(data.results);});
    }
}
SCRIPT;
    }

    public static function initSelection($url)
    {
        return new JsExpression(Select2Helper::initScript($url));
    }

}
