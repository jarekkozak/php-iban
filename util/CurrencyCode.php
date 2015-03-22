<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\util;

/**
 * Description of CurrencyCode
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class CurrencyCode
{
    public $isoLink = 'http://www.currency-iso.org/dam/downloads/table_a1.xml';

    public $currencyList = ['PLN','THB', 'USD', 'AUD', 'HKD', 'CAD', 'NZD', 'SGD', 'EUR',
        'HUF', 'CHF', 'GBP', 'UAH', 'JPY', 'CZK', 'DKK', 'ISK', 'NOK', 'SEK', 'HRK',
        'RON', 'BGN', 'TRY', 'ILS', 'CLP', 'PHP', 'MXN', 'ZAR', 'BRL', 'MYR', 'RUB',
        'IDR', 'INR', 'KRW', 'CNY', 'XDR'];

    public $str2code = [
        "AUD" => 36,
        "BGN" => 975,
        "BRL" => 986,
        "CAD" => 124,
        "CHF" => 756,
        "CLP" => 152,
        "CNY" => 156,
        "CZK" => 203,
        "DKK" => 208,
        "EUR" => 978,
        "GBP" => 826,
        "HKD" => 344,
        "HRK" => 191,
        "HUF" => 348,
        "IDR" => 360,
        "ILS" => 376,
        "INR" => 356,
        "ISK" => 352,
        "JPY" => 392,
        "KRW" => 410,
        "MXN" => 484,
        "MYR" => 458,
        "NOK" => 578,
        "NZD" => 554,
        "PHP" => 608,
        "PLN" => 985,
        "RON" => 946,
        "RUB" => 643,
        "SEK" => 752,
        "SGD" => 702,
        "THB" => 764,
        "TRY" => 949,
        "UAH" => 980,
        "USD" => 840,
        "XDR" => 960,
        "ZAR" => 710,
    ];
    
    public $code2str = [
        124 => "CAD",
        152 => "CLP",
        156 => "CNY",
        191 => "HRK",
        203 => "CZK",
        208 => "DKK",
        344 => "HKD",
        348 => "HUF",
        352 => "ISK",
        356 => "INR",
        360 => "IDR",
        36  => "AUD",
        376 => "ILS",
        392 => "JPY",
        410 => "KRW",
        458 => "MYR",
        484 => "MXN",
        554 => "NZD",
        578 => "NOK",
        608 => "PHP",
        643 => "RUB",
        702 => "SGD",
        710 => "ZAR",
        752 => "SEK",
        756 => "CHF",
        764 => "THB",
        826 => "GBP",
        840 => "USD",
        946 => "RON",
        949 => "TRY",
        960 => "XDR",
        975 => "BGN",
        978 => "EUR",
        980 => "UAH",
        985 => "PLN",
        986 => "BRL",
    ];

    /**
     * Download table with currecy codes deom iso page
     * @return array
     */
    public function downloadISOCodes()
    {

        $out_contry        = [];
        $out_str2code      = [];
        $out_code2currency = [];

        /* @var $iso SimpleXMLElement */
        $iso  = simplexml_load_file($this->isoLink);
        //Publish date
        $date = (string) $iso->attributes()->Pblshd;
        foreach ($iso->CcyTbl->CcyNtry as $value) {
            $country             = (string) $value->CtryNm;
            $currency_name       = (string) $value->CcyNm;
            $currency            = (string) $value->Ccy;
            $currency_code       = (int) $value->CcyNbr;
            $currency_minor_unit = (int) $value->CcyMnrUnts;
            if (in_array($currency, $this->currencyList)) {
                $out_contry[$country]              = [
                    'country' => $country,
                    'currency' => $currency,
                    'name' => $currency_name,
                    'code' => $currency_code,
                    'minor_unit' => $currency_minor_unit
                ];
                $out_str2code[$currency]           = $currency_code;
                $out_code2currency[$currency_code] = $currency;
            }
        }
        return [
            'date' => $date,
            'country' => $out_contry,
            'str2code' => $out_str2code,
            'code2str' => $out_code2currency,
        ];
    }


    /**
     * Gets currency code
     * @param string $currency
     * @return int|boolean
     */
    public function getIsoCode($currency){
        if(isset($this->str2code[$currency])){
            return $this->str2code[$currency];
        }
        return FALSE;
    }

    /**
     * Gets currency string from code
     * @param int $code
     * @return string|boolean
     */
    public function getIsoCurrency($code){
        if(isset($this->code2str[$code])){
            return $this->code2str[$code];
        }
        return FALSE;
    }
    
}