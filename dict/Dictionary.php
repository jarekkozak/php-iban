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
    protected static $_cache  = [];
    protected $value          = null;
    protected $key            = null;

    public function __construct($key = null)
    {
        $this->init();
        if ($key == null) {
            return;
        }
        if (!isset($this->__dictValues()[$key])) {
            throw new DictionaryNotFoundException("No dictionary entry for key:$key");
        }
        $this->value = $this->__dictValues()[$key];
        $this->key   = $key;
    }

    public static function dictionary()
    {
        return get_called_class();
    }

    final protected function init()
    {
        if (!isset(static::$_cache[$this->dictionary()])) {
            static::$_cache[$this->dictionary()] = array_unique($this->load());
        }
    }

    final protected function __dictValues(){
        return static::$_cache[self::dictionary()];
    }

    protected abstract function load();

    final public function isValid($value)
    {
        return in_array($value, $this->__dictValues(), TRUE);
    }

    /**
     * Check if key exist
     */
    final public function exist($key)
    {
        return array_key_exists($key, $this->__dictValues());
    }

    final public static function getInstanceFromValue($value)
    {
        if (!isset(self::$_cache[self::dictionary()])) {
            self::getInstance(); //In case values are not initialized
        }
        if (($key = array_search($value, static::$_cache[self::dictionary()], true)) === FALSE) {
            throw new DictionaryNotFoundException("No dictionary entry for value:$value");
        }
        return self::getInstance($key);
    }

    final public static function getInstance($key = null)
    {
        $class = new \ReflectionClass(get_called_class());
        return $class->newInstance($key);
    }

    final public function values()
    {
        $ret = [];
        foreach ($this->__dictValues() as $key => $value) {
            $ret[] = self::getInstance($key);
        }
        return $ret;
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