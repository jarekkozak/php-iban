<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * <?
 *  
 * Description of VAT
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class VAT extends CComponent {

    private $_vat;

    public function __construct($vat) {
        $this->_vat = $vat;
    }

    public function isValid() {
        $str = preg_replace("/[^0-9]+/", "", $this->_vat);
        if (strlen($str) != 10) {
            return false;
        }

        $arrSteps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
        $intSum = 0;
        for ($i = 0; $i < 9; $i++) {
            $intSum += $arrSteps[$i] * $str[$i];
        }
        $int = $intSum % 11;

        $intControlNr = ($int == 10) ? 0 : $int;
        if ($intControlNr == $str[9]) {
            return true;
        }
        return false;
    }

}
