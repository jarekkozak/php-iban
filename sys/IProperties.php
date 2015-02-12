<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace jarekkozak\sys;
/**
 * Defines class interface to get property
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface IProperties
{
    /**
     * Returns value of the property
     * @param type $name
     * @param type $default
     * @return type
     */
    public function getProperty($name, $default = NULL);
}