<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace jk\sys;

/**
 * Dependency manage is intended to register global dependencies provided
 * in array. Each array element must be valid as a pair of Container params.
 *
 * @see yii\di\Container
 *
 * @author jarek
 */
class DependencyManager
{
    /**
     * Register dependencies
     * @param array $config
     */
    public static function register(array $config)
    {
        foreach ($config as $key => $value) {
            \Yii::$container->clear($key);
            \Yii::$container->set($key, $value);
        }
    }
}