<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\tests\dict;

/**
 * Description of Dict1
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class Dict1 extends \jarekkozak\dict\Dictionary
{
    const VALUE1 = 'com.common.value1';
    const VALUE2 = 'com.common.value2';

    /**
     * Load dictionary values
     * @return type
     */
    protected function load()
    {
        return [
            self::VALUE1 => 1,
            self::VALUE2 => 2
        ];
    }

}