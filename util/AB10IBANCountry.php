<?php

require_once(SITE_PATH . '/protected/extensions/php-iban/php-iban.php');
require_once(SITE_PATH . '/protected/extensions/php-iban/oophp-iban.php');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AB10IBAN
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class AB10IBANCountry extends IBANCountry {

    public function __construct($code = '') {
        parent::__construct($code);
        _iban_load_registry();
    }

}

