<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace jk\sys;
/**
 * Description of LogDummy
 *
 * @author jarek
 */
class LogDummy extends \yii\base\Object implements ILog
{
    /**
     * Dummy method just to implement log
     * @param type $message
     * @param type $type
     */
    public function log($message, $type = ILog::INFO) {
    }
}