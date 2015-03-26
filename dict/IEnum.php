<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\dict;

/**
 * Description of Enum
 *
 * @link http://stackoverflow.com/questions/254514/php-and-enumerations
 * 
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface IEnum
{
    /**
     * Returns array of const values. Const name is a key.
     * @return array
     */
    public static function values();

    /**
     * Check if given value is constant
     * @param mixed $value
     * @return boolean
     */
    public static function isValid($value);

    /**
     * Returns constant name for given value
     * @param type $value
     * @return string
     *
     */
    public static function name($value);

    /**
     * Returns value for given name
     * @param string $name
     * @return mixed
     */
    public static function value($name);

    /**
     * Returns enum name
     * @return string
     */
    public static function enumName();

    /**
     * Returns an instancje of dictionary
     * @return IEnum Description
     */
    public static function getInstance();
    
}