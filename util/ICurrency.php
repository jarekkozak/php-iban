<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace jarekkozak\util;
/**
 * Description of ICurrency
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface ICurrency
{

    public function setConverter($converter);
    public function getConverter();
    public function setPrice();
    public function getPrice();
    public function convert($currency,$amount);

}