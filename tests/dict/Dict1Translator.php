<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\tests\dict;

use jarekkozak\dict\IDictionary;
use jarekkozak\dict\IDictionaryTranslation;

/**
 * Description of DictSelectDecorator
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class Dict1Translator implements IDictionaryTranslation
{
    public function translate(IDictionary $dict)
    {
        return $dict->key().'-TRANSLATED-'.$dict->dictionary();
    }
}