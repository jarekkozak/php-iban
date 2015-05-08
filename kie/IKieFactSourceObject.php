<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

/**
 * Description of IKieFactSourceObject
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface IKieFactSourceObject
{
    public function getFactName();
    public function getIdentifier();
    public function getNodes();
}