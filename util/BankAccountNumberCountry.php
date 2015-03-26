<?php
namespace jarekkozak\util;

require_once(__DIR__.'/../lib/iban/php-iban.php');
require_once(__DIR__.'/../lib/iban/oophp-iban.php');

/**
 * Country for IBAN
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class BankAccountNumberCountry extends \IBANCountry {

    public function __construct($code = '') {
        parent::__construct($code);
        _iban_load_registry();
    }

}

