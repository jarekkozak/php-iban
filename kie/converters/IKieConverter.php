<?php

namespace jarekkozak\kie\converters;

/**
 * Converts data into requested format interface
 * 
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface IKieConverter
{
    /**
     * @param mixed $object
     * @return string Description
     */
    public function toString($object);

    /**
     * Converts string into value
     * @param string $value
     * 
     */
    public function toObject($value);

}