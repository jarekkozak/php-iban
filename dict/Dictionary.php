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
    protected $value          = null;
    protected $key            = null;

    public function __construct($key = null)
    {
        $this->init();
        if ($key == null) {
            return;
        }
        if (!isset(self::$_values[$key])) {
            throw new DictionaryNotFoundException("No dictionary entry for key:$key");
        }
        $this->value = self::$_values[$key];
        $this->key   = $key;
    }

    public function dictionary()
    {
        return get_class($this);
    }

    final protected function init()
    {
        if (static::$_values == null) {
            static::$_values = array_unique($this->load());
        }
    }

    protected abstract function load();

    final public function isValid($value)
    {
        return in_array($value, static::$_values, TRUE);
    }

    /**
     * Check if key exist
     */
    final public function exist($key)
    {
        return array_key_exists($key, static::$_values);
    }

    final public static function getInstanceFromValue($value)
    {
        if (self::$_values == null) {
            self::getInstance(); //In case values are not initialized
        }
        if (($key = array_search($value, static::$_values, true)) === FALSE) {
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
        foreach (self::$_values as $key => $value) {
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