<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\dict;

/**
 * Description of Dictionary
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
abstract class Dictionary implements IDictionary
{
    /**
     * Define const with default values
     */
    protected static $_values = null;

    public static function dictionary()
    {
        return get_called_class();
    }

    final protected function init()
    {
        if (static::$_values == null) {
            static::$_values = array_unique(static::load());
        }
    }

    protected abstract static function load();

    final public static function isValid($value)
    {
        self::init();
        return in_array($value, static::$_values, TRUE);
    }

    /**
     * Check if key exist
     */
    final static function exist($key)
    {
        self::init();
        return array_key_exists($key, static::$_values);
    }

    final static function getInstanceFromValue($value)
    {
        self::init();
        if (($key = array_search($value, static::$_values, true)) === FALSE) {
            throw new DictionaryNotFoundException("No dictionary entry for value:$value");
        }
        return self::getInstance($key);
    }

    final static function getInstance($key){
        if(!self::exist($key)){
            throw new DictionaryNotFoundException("No dictionary entry for value:$value");
        }
        $class = new \ReflectionClass(get_called_class());
        return $class->newInstance($key);
    }

    final static function values()
    {
        self::init();
        $ret = [];
        foreach (static::$_values as $key => $value) {
            $ret[] = self::getInstance($key);
        }
        return $ret;
    }

    public function __construct($key)
    {
        self::init();
        if (!isset(self::$_values[$key])) {
            throw new DictionaryNotFoundException($key);
        }
        $this->value = self::$_values[$key];
        $this->key   = $key;
    }

    public function value()
    {
        return $this->value;
    }

    public function key()
    {
        return $this->key;
    }

    /**
     * Compare two dictionary position
     * @param type $value
     * @return boolean
     */
    public function equals($value)
    {
        if ($value instanceof $this) {
            if ($value->value === $this->value && $value->key === $this->key()) {
                return TRUE;
            }
        }
        return FALSE;
    }


}