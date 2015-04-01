<?php

namespace jarekkozak\util;

use Moment\Moment;

/**
 * Obsługa kursów walut WalutyNBP/ Polish National Bank (NBP),
 * currency exchange ratio
 * 
 * Based on code @author poli25
 *
 * extended and adjusted
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 *
 * @property string $tableType  exchange table type
 * @property Moment $exchangeRateDate Description
 * @property string $linkList address to text file with list of exchange ratio tables
 * @property string $linkDir address to dir where tables are stored
 * @property string $sourceCurrency source currency default PLN
 *
 */
class CurrencyExchangeNBP extends \yii\base\Object implements ICurrencyExchange
{

    const AVERAGE = 'a';
    const SOURCE_CURRENCY = 'PLN';

    protected $exchangeRateDate;
    protected $linkList       = 'http://www.nbp.pl/kursy/xml/dir.txt';
    protected $linkDir        = 'http://www.nbp.pl/kursy/xml';
    protected $tableType      = self::AVERAGE;
    protected $sourceCurrency = self::SOURCE_CURRENCY;

    private $_cache        = NULL;

    protected $table;
    protected $tableDate   = NULL;
    protected $tableNumber = NULL;
    protected $tableName   = NULL;

    public function init()
    {
        parent::init();

        $this->sourceCurrency = self::SOURCE_CURRENCY;

        if ($this->exchangeRateDate == NULL) {
            $this->exchangeRateDate = new Moment();
        } elseif (is_string($this->exchangeRateDate)) {
            $this->exchangeRateDate = new Moment($this->exchangeRateDate);
        }
        $today = new Moment();
        if ($today->isBefore($this->exchangeRateDate)) {
            throw new CurrencyExchangeRateException('You cannot get exchange rate for future. Today:'.$today->format().' Request date:'.$this->exchangeRateDate->format());
        }
    }

    /**
     * Odczytanie wartości numerycznej do float
     */
    protected function parseValue($value)
    {
        return floatval(str_replace(',', '.', $value));
    }

    /**
     * Download table list file 
     * @return type
     */
    protected function getTableList()
    {
        if ($this->_cache == NULL) {
            $this->_cache = file_get_contents($this->linkList);
        }
        return $this->_cache;
    }

    /**
     * Get table name from published table names, based on given date
     * @param char $type of table a,c...
     * @return string|boolean
     *
     */
    public function findTableName($type)
    {
        $day     = $this->exchangeRateDate->format('ymd');
        $pattern = "/".$type."[0-9]{3}[z]{1}".$day."/";
        $list    = $this->getTableList();
        if (preg_match($pattern, $this->getTableList(), $ret) == 1) {
            return $ret[0];
        }
        return FALSE;
    }

    /**
     * Gets all Polish nantional bank (NBP) exchange ratio all table list
     * @param $type letter which tables should be on the list
     * @return array
     */
    public function getExRatioTableList($type = NULL)
    {
        if ($type == NULL) {
            $type = '[a-z]{1}'; //Default all tables
        }
        if (preg_match_all("/".$type."[0-9]{3}[z]{1}[0-9]{6}/",
                $this->getTableList(), $array) > 0) {
            return $array[0];
        };
        return FALSE;
    }

    protected function findPrevTableName(array $names){
        $name = array_pop($names);
        $dateTime = \DateTime::createFromFormat('ymd', substr($name, 5));
        $date = new Moment($dateTime->format('Y-m-d'));
        while ($date->isAfter($this->exchangeRateDate) && count($names)>0) {
            $name = array_pop($names);
            $dateTime = \DateTime::createFromFormat('ymd', substr($name, 5));
            $date = new Moment($dateTime->format('Y-m-d'));
        }
        return $name;
    }

    /**
     * @throws CurrencyExchangeRateException
     */
    protected function downloadTable()
    {
        if ($this->table != NULL) {
            return;
        }
        if (($name = $this->findTableName($this->tableType)) == FALSE) {
            if (($names_table = $this->getExRatioTableList($this->tableType)) == FALSE) {
                throw new CurrencyExchangeRateException('Exchange rate table type:'.$this->tableType.' not exists for date:'.$this->exchangeRateDate->format());
            }
            //$name = array_pop($names_table);
            $name = $this->findPrevTableName($names_table);
        }

        $tableExc = simplexml_load_file($this->linkDir.'/'.$name.'.xml');
        $ratio    = [];
        foreach ($tableExc->pozycja as $rateEx) {
            $kod_waluty                  = $rateEx->kod_waluty;
            $przelicznik                 = $rateEx->przelicznik;
            $kurs_sredni                 = $rateEx->kurs_sredni;
            $ratio[(string) $kod_waluty] = [
                'converter' => (int)((string) $przelicznik),
                'price' => $this->parseValue((string) $kurs_sredni)
            ];
        }
        $this->tableName   = $name;
        $this->tableDate   = new Moment((string) $tableExc->data_publikacji);
        $this->tableNumber = (string) $tableExc->numer_tabeli;
        $this->table       = $ratio;
    }

    /**
     * Convert given currency into source currency based on NBP exchange ratio
     * @param decimal $amount
     * @param string $currency
     */
    public function convert($amount, $currency)
    {
        $this->downloadTable();
        if(!isset($this->table[$currency])){
            throw new CurrencyExchangeRateException('No exchange ratio for '.$currency);
        }
        $cur = $this->table[$currency];
        return round(($amount/$cur['converter']) * $cur['price'],2);
    }

    public function setExchangeRateDate(Moment $date)
    {
        $this->exchangeRateDate = $date;
        $this->table            = NULL;
    }

    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    public function setSourceCurrency($currency)
    {
        //read only
        //$this->sourceCurrency = $currency;
    }

    /**
     *
     * @return string
     */
    public function getSourceCurrency()
    {
        return $this->sourceCurrency;
    }

    public function getLinkList()
    {
        return $this->linkList;
    }

    public function getLinkDir()
    {
        return $this->linkDir;
    }

    /**
     *
     * @return string
     */
    public function getTableType()
    {
        return $this->tableType;
    }

    /**
     *
     * @return Moment
     */
    public function getTableDate()
    {
        $this->downloadTable();
        return $this->tableDate;
    }

    /**
     *
     * @return int
     */
    public function getTableNumber()
    {
        $this->downloadTable();
        return $this->tableNumber;
    }

    protected function setLinkList($linkList)
    {
        $this->linkList = $linkList;
    }

    protected function setLinkDir($linkDir)
    {
        $this->linkDir = $linkDir;
    }

    public function setTableType($tableType)
    {
        $this->tableType = $tableType;
        $this->table     = NULL;
    }

    protected function setTableDate($tableDate)
    {
        // ReadOnly
    }

    protected function setTableNumber($tableNumber)
    {
        // ReadOnly
    }

    public function getTable()
    {
        $this->downloadTable();
        return $this->table;
    }

    protected function setTable($table)
    {
        // Read only
    }

    public function getTableName(){
        $this->downloadTable();
        return $this->tableName;
    }

    protected function setTableName(){
        // Read only
    }

    /**
     * Returns table order number in format
     * yyyyXXX where yyyy - year XXX - number in year
     * @return int
     */
    public function getTableOrderNumber(){
        $nr = $this->getTableNumber();
        return (int)(substr($nr,10,4).substr($nr,0,3));
    }


}