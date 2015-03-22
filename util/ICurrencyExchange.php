<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\util;

use Moment\Moment;

/**
 * Description of ICurrencyExchange
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
interface ICurrencyExchange
{

    /**
     * Sets exchange ratio table date
     * @throws CurrencyExchangeRateException
     */
    public function setExchangeRateDate(Moment $date);

    /**
     * Gets exchange ratio table
     * @return Moment exchange ratio table date
     */
    public function getExchangeRateDate();

    /**
     * Set source currency 3lettres abbreviation ISO
     * @param string $currency currency 3lettres abbreviation ISO
     */
    public function setSourceCurrency($currency);

    /**
     * Get source currency
     * @return string currency 3lettres abbreviation ISO
     */
    public function getSourceCurrency();

    /**
     * Convert given currency into source use average ratio exchange
     * @param decimal $amount Amount in currency to be converted
     * @param string $currency currency 3lettres abbreviation ISO
     *
     * @return decimal|boolean amount in source currency, false if error
     * no exchange rate etc...
     */
    public function convert($amount,$currency);

}