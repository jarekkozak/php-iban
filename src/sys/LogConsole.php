<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace jk\sys;
/**
 * Description of LogConsole
 *
 * @author jarek
 */
class LogConsole extends \yii\base\Object implements ILog
{
    public function log($message, $type = ILog::INFO)
    {
        $date = new \DateTime();
        print_r("\n" . $date->format(\DateTime::ISO8601) .':'. $type.':'. $message);
    }

}