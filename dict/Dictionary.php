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
class Dictionary
{
    /**
     * Define const with default values
     */
    private static $_values=null;

    /**
     * Actual dictionary value
     * @var type
     */
    protected $value = NULL;

    private function init($key){
        if(self::$_values == null){
            self::$_values = $this->load();
        }
        if(!isset(self::$_values[$key])){
            throw new DictionaryNotFoundException($key);
        }
        $this->value = self::$_values[$key];
    }

    protected function load(){
        return [];
    }

    public function __construct($key){
        $this->init($key);
    }

    public function value(){
        return $this->value;
    }

    /**
     * Compare two dictionary position
     * @param type $value
     * @return boolean
     */
    public function equals($value){
        if($value instanceof $this){
            if($value->value === $this->value){
                return TRUE;
            }
        }
        return FALSE;
    }


}