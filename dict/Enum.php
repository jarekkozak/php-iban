<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\dict;

use ReflectionClass;

/**
 * Description of Enum
 *
 * @link http://stackoverflow.com/questions/254514/php-and-enumerations
 * 
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
abstract class Enum implements IEnum
{
    const NONE = null;

    /**
     * @see IEnum::values()
     */
    final public static function values()
    {
        return (new \ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * {@inheritdoc}
     */
    final public static function isValid($value)
    {
        return in_array($value, static::values(), TRUE);
    }

    /**
     * {@inheritdoc}
     */
    final public static function name($value){
        return array_search($value, static::values(), TRUE);
    }

    /**
     * {@inheritdoc}
     */
    final static function value($name){
        return array_key_exists($name,$values=static::values())?$values[$name]:$values['NONE'];
    }

    /**
     * {@inheritdoc}
     */
    final static function enumName()
    {
        return get_called_class();
    }

    /**
     * {@inheritdoc} tes
     */
    final static function getInstance(){
        $class = new ReflectionClass(self::enumName());
        return $class->newInstanceArgs();
    }

}