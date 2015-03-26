<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\dict;

/**
 * Dictionary interface
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface IDictionary
{

    /**
     * Provide dictionary object name
     * @return struing  dictionary name
     */
    public static function dictionary();

    /**
     * Checks if value exists in dictionary.
     *
     * <b>Warning! you have to provide value with the same type as exist
     * in dictionary </b>
     *
     * @param mixed $value value to be checked
     * @return bool true if value exists in dictionary
     */
    public static function isValid($value);

    /**
     * Check if key exist
     * @param string $key name
     * @return bool true if key exists
     */
    public static function exist($key);

    /**
     * Create dictionary object from given value
     * @param mixed $value
     * @return IDictionary created object
     * @throws jarekkozak\dict\DictionaryNotFoundException
     */
    public static function getInstanceFromValue($value);


    /**
     * Creates object instane based on given key
     * @param string $key name
     * @return IDictionary Description
     * @throws jarekkozak\dict\DictionaryNotFoundException
     */
    public static function getInstance($key);

    /**
     * Returns array of dictionary entries
     * @return array array of dictionary objects
     */
    public static function values();

    /**
     * Return dictionary entry value
     * @return mixed value of dictionary entry
     */
    public function value();

    /**
     * Returns dictionary entry key name
     * @return string key name
     */
    public function key();

    /**
     * Compare two dictionary entries. Entries must be the same type and strict
     * value comparison is executed
     * @param type $value
     * @return boolean true if both are equal
     */
    public function equals($value);
}