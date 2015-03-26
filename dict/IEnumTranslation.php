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
interface IEnumTranslation
{
    /**
     * Translate
     * @param string $name
     * @return string Translated string
     */
    public function translate($name,$enumName);
    
}