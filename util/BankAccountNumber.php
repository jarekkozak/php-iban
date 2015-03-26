<?php
namespace jarekkozak\util;

require_once __DIR__.'/../lib/iban/php-iban.php';
require_once __DIR__.'/../lib/iban/oophp-iban.php';

/**
 * Description of AB10IBAN
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class BankAccountNumber extends \IBAN {
    
    public function Verify($iban = '') {
        $_iban = str_replace(' ','', $iban);
        _iban_load_registry();
        return parent::Verify($_iban);
    }

}
