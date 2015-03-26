<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\dict;

/**
 * Description of IEnumTranslation
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface IDictionaryTranslation
{
    /**
     * Provide human readable key name translation
     * @param IDictionary dictionary to be translated
     */
    public function translate(IDictionary $dict);
    
}