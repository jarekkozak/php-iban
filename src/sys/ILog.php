<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace jk\sys;
/**
 *
 * @author jarek
 */
interface ILog
{
    const INFO = 'INFO';
    const ERROR = 'ERROR';
    const WARN = 'WARN';
    public function log($message,$type = ILog::INFO);
    
}