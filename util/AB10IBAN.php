<?php
require_once(SITE_PATH.'/protected/extensions/php-iban/php-iban.php');
require_once(SITE_PATH.'/protected/extensions/php-iban/oophp-iban.php');
/**
 * Description of AB10IBAN
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class AB10IBAN extends IBAN {
    
    public function Verify($iban = '') {
        $_iban = str_replace(' ','', $iban);
        _iban_load_registry();
        return parent::Verify($_iban);
    }

}
