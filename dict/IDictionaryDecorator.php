<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\dict;

/**
 * Interface for dicrionary values array decorator
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface IDictionaryDecorator
{

    /**
     * Prepare array of values where key is dictionary value
     * @param IEnum $enum
     * @return array
     */
    public function values(array $values);
}