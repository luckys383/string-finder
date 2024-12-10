<?php

namespace App\Models;

use App\Models\AppModel;
use Carbon\Carbon;

class Transaction extends AppModel
{
    
    protected $table = 'transactions';

    protected $fillable = [
        'uid', 'contract_id', 'transaction_group_ref', 'begin_date', 'end_date',
        'time_zone', 'trade_date', 'podba', 'podsl', 'transaction_class',
        'term', 'increment', 'increment_peaking', 'product_name', 'quantity',
        'standardized_quantity', 'price', 'standardized_price', 'rate_units',
        'rate_type', 'total_transmission_charge', 'transaction_charge', 'filing_type',
        'podsl_hub', 'broker_exchange', 'contract_token'
    ];

    const YEARLY_REPORTED_PERIOD_KEY = 'Y';
    const MONTHLY_REPORTED_PERIOD_KEY = 'M';
    const WEEKLY_REPORTED_PERIOD_KEY = 'W';
    const DAILY_REPORTED_PERIOD_KEY = 'D';
    const HOURLY_REPORTED_PERIOD_KEY = 'H';

    const YEARLY_REPORTED_PERIOD_LABEL = 'yearly';
    const HALF_YEARLY_REPORTED_PERIOD_LABEL = 'half_yearly';
    const QUARTERLY_REPORTED_PERIOD_LABEL = 'quarterly';
    const MONTHLY_REPORTED_PERIOD_LABEL = 'monthly';
    const HALF_MONTHLY_REPORTED_PERIOD_LABEL = 'half_monthly';
    const WEEKLY_REPORTED_PERIOD_LABEL = 'weekly';
    const DAILY_REPORTED_PERIOD_LABEL = 'daily';
    const HOURLY_REPORTED_PERIOD_LABEL = 'hourly';


    /**
     * set contract id.
     *
     * @param $value: integer of contract id.
     */
    public function setContractId($value)
    {
        $this->contract_id = $value;
        return $this;
    }

    /**
     * get integer of contract id.
     *
     * @return integer of contract id.
     */
    public function getContractId()
    {
        if (!$this->contract_id) {
            return "N/A";
        }
        return $this->contract_id;
    }

    /**
     * set uid of contract.
     *
     * @param $value: integer uid.
     */
    public function setUid($value)
    {
        $this->uid = $value;
        return $this;
    }

    /**
     * get uid of contract.
     *
     * @return integer uid.
     */
    public function getUid()
    {
        if (!$this->uid) {
            return "N/A";
        }
        return $this->uid;
    }

    public function getContractServiceAgreementId()
    {
        if (!$this->contract) {
            return 'N/A';
        }

        return $this->contract->getContractServiceagreement();
    }

    /**
     * set transaction group ref of contract.
     *
     * @param $value: string transaction group ref.
     */
    public function setTransactionGropuRef($value)
    {
        $this->transaction_group_ref = $value;
        return $this;
    }

    /**
     * get transaction group ref of contract.
     *
     * @return string transaction group ref.
     */
    public function getTransactionGropuRef()
    {
        if (!$this->transaction_group_ref) {
            return "N/A";
        }
        return $this->transaction_group_ref;
    }

    /**
     * set begin date of contract.
     *
     * @param $value: begin date.
     */
    public function setBeginDate($value)
    {
        if (!$value) {
            $this->begin_date = "1970-01-01 00:00:00";
            return $this;
        }

        $date = new Carbon($value);
        $this->begin_date = $date->format(self::DB_DATETIME_FORMAT);
        return $this;
    }

    /**
     * get begin date of contract.
     *
     * @return begin date.
     */
    public function getBeginDate()
    {
        if (!$this->begin_date) {
            return "N/A";
        }
        $date = new Carbon($this->begin_date);
        return $date->format(self::DISPLAY_DATETIME_FORMAT);
    }

    /**
     * set end date of contract.
     *
     * @param $value: end date.
     */
    public function setEndDate($value)
    {
        if (!$value) {
            $this->end_date = "1970-01-01 00:00:00";
            return $this;
        }

        $date = new Carbon($value);
        $this->end_date = $date->format(self::DB_DATETIME_FORMAT);
        return $this;
    }

    /**
     * get end date of contract.
     *
     * @return end date.
     */
    public function getEndDate()
    {
        if (!$this->end_date) {
            return "N/A";
        }
        $date = new Carbon($this->end_date);
        return $date->format(self::DISPLAY_DATETIME_FORMAT);
    }

    /**
     * set time zone of contract.
     *
     * @param $value: integer time zone.
     */
    public function setTimeZone($value)
    {
        $this->time_zone = $value;
        return $this;
    }

    /**
     * get time zone of contract.
     *
     * @return integer time zone.
     */
    public function getTimeZone()
    {
        if (!$this->time_zone) {
            return "N/A";
        }
        return $this->time_zone;
    }

    /**
     * set trade date of contract.
     *
     * @param $value: trade date.
     */
    public function setTradeDate($value)
    {
        if (!$value) {
            $this->trade_date = "1970-01-01 00:00:00";
            return $this;
        }

        $date = new Carbon($value);
        $this->trade_date = $date->format(self::DB_DATETIME_FORMAT);
        return $this;
    }

    /**
     * get trade date of contract.
     *
     * @return trade date.
     */
    public function getTradeDate()
    {
        if (!$this->trade_date) {
            return "N/A";
        }
        $date = new Carbon($this->trade_date);
        return $date->format(self::DISPLAY_DATETIME_FORMAT);
    }

    /**
     * set podba of contract.
     *
     * @param $value: string podba.
     */
    public function setPodba($value)
    {
        $this->podba = $value;
        return $this;
    }

    /**
     * get podba of contract.
     *
     * @return string podba.
     */
    public function getPodba()
    {
        if (!$this->podba) {
            return "N/A";
        }
        return $this->podba;
    }

    /**
     * set podsl of contract.
     *
     * @param $value: string podsl.
     */
    public function setPodsl($value)
    {
        $this->podsl = $value;
        return $this;
    }

    /**
     * get podsl of contract.
     *
     * @return string podsl.
     */
    public function getPodsl()
    {
        if (!$this->podsl) {
            return "N/A";
        }
        return $this->podsl;
    }

    /**
     * set transaction class of contract.
     *
     * @param $value: string transaction class.
     */
    public function setClass($value)
    {
        $this->transaction_class = $value;
        return $this;
    }

    /**
     * get transaction class of contract.
     *
     * @return string transaction class.
     */
    public function getClass()
    {
        if (!$this->transaction_class) {
            return "N/A";
        }
        return $this->transaction_class;
    }

    /**
     * set term of contract.
     *
     * @param $value: string term.
     */
    public function setTerm($value)
    {
        $this->term = $value;
        return $this;
    }

    /**
     * get term of contract.
     *
     * @return string term.
     */
    public function getTerm()
    {
        if (!$this->term) {
            return "N/A";
        }
        return $this->term;
    }

    /**
     * set increment of contract.
     *
     * @param $value: string increment.
     */
    public function setIncrement($value)
    {
        $this->increment = $value;
        return $this;
    }

    /**
     * get increment of contract.
     *
     * @return string increment.
     */
    public function getIncrement()
    {
        if (!$this->increment) {
            return "N/A";
        }
        return $this->increment;
    }

    /**
     * set increment peaking of contract.
     *
     * @param $value: string increment peaking.
     */
    public function setIncrementPeaking($value)
    {
        $this->increment_peaking = $value;
        return $this;
    }

    /**
     * get increment peaking of contract.
     *
     * @return string increment peaking.
     */
    public function getIncrementPeaking()
    {
        if (!$this->increment_peaking) {
            return "N/A";
        }
        return $this->increment_peaking;
    }

    /**
     * set product name of contract.
     *
     * @param $value: string product name.
     */
    public function setProductName($value)
    {
        $this->product_name = $value;
        return $this;
    }

    /**
     * get product name of contract.
     *
     * @return string product name.
     */
    public function getProductName()
    {
        if (!$this->product_name) {
            return "N/A";
        }
        return $this->product_name;
    }

    /**
     * set quantity of contract.
     *
     * @param $value: string quantity.
     */
    public function setQuantity($value)
    {
        $this->quantity = $value;
        return $this;
    }

    /**
     * get quantity of contract.
     *
     * @return string quantity.
     */
    public function getQuantity()
    {
        if (!$this->quantity) {
            return "N/A";
        }
        return $this->quantity;
    }

    /**
     * set standardized quantity of contract.
     *
     * @param $value: string standardized quantity.
     */
    public function setStandardizedQuantity($value)
    {
        $this->standardized_quantity = $value;
        return $this;
    }

    /**
     * get standardized quantity of contract.
     *
     * @return string standardized quantity.
     */
    public function getStandardizedQuantity()
    {
        if (!$this->standardized_quantity) {
            return "N/A";
        }
        return $this->standardized_quantity;
    }

    /**
     * set price of contract.
     *
     * @param $value: float price.
     */
    public function setPrice($value)
    {
        $this->price = $value;
        return $this;
    }

    /**
     * get price of contract.
     *
     * @return float price.
     */
    public function getPrice()
    {
        if (!$this->price) {
            return "N/A";
        }
        return $this->price;
    }

    /**
     * set standardized price of contract.
     *
     * @param $value: float standardized price.
     */
    public function setStandardizedPrice($value)
    {
        $this->standardized_price = (double)$value;
        return $this;
    }

    /**
     * get standardized price of contract.
     *
     * @return float standardized price.
     */
    public function getStandardizedPrice()
    {
        if (!$this->standardized_price) {
            return "N/A";
        }
        return (double)$this->standardized_price;
    }

    /**
     * set rate units of contract.
     *
     * @param $value: string rate units.
     */
    public function setRateUnits($value)
    {
        $this->rate_units = $value;
        return $this;
    }

    /**
     * get rate units of contract.
     *
     * @return string rate units.
     */
    public function getRateUnits()
    {
        if (!$this->rate_units) {
            return "N/A";
        }
        return $this->rate_units;
    }

    /**
     * set rate type of contract.
     *
     * @param $value: string rate type.
     */
    public function setRateType($value)
    {
        $this->rate_type = $value;
        return $this;
    }

    /**
     * get rate type of contract.
     *
     * @return string rate type.
     */
    public function getRateType()
    {
        if (!$this->rate_type) {
            return "N/A";
        }
        return $this->rate_type;
    }

    /**
     * set total transmission charge of contract.
     *
     * @param $value: float total transmission charge.
     */
    public function setTotalTransmissionCharge($value)
    {
        $this->total_transmission_charge = $value;
        return $this;
    }

    /**
     * get total transmission charge of contract.
     *
     * @return float total transmission charge.
     */
    public function getTotalTransmissionCharge()
    {
        if (!$this->total_transmission_charge) {
            return "N/A";
        }
        return $this->total_transmission_charge;
    }

    /**
     * set transaction charge of contract.
     *
     * @param $value: float transaction charge.
     */
    public function setTransactionCharge($value)
    {
        $this->transaction_charge = $value;
        return $this;
    }

    /**
     * get transaction charge of contract.
     *
     * @return float transaction charge.
     */
    public function getTransactionCharge()
    {
        if (!$this->transaction_charge) {
            return "N/A";
        }
        return $this->transaction_charge;
    }

    /**
     * set filing type of contract.
     *
     * @param $value: string filing type.
     */
    public function setFilingType($value)
    {
        $this->filing_type = $value;
        return $this;
    }

    /**
     * get filing type of contract.
     *
     * @return string filing type.
     */
    public function getFilingType()
    {
        if (!$this->filing_type) {
            return "N/A";
        }
        return $this->filing_type;
    }


    /**
     * Sets the value of podsl_hub.
     *
     * @param mixed $podsl_hub the podsl hub
     *
     * @return self
     */
    public function setPodslHub($podsl_hub)
    {
        $this->podsl_hub = $podsl_hub;

        return $this;
    }

    /**
     * Gets the value of podsl_hub.
     *
     * @return mixed
     */
    public function getPodslHub()
    {
        return $this->podsl_hub;
    }

    /**
     * Sets the value of broker_exchange.
     *
     * @param mixed $broker_exchange the broker exchange
     *
     * @return self
     */
    public function setBrokerExchange($broker_exchange)
    {
        $this->broker_exchange = $broker_exchange;

        return $this;
    }

    /**
     * Gets the value of broker_exchange.
     *
     * @return mixed
     */
    public function getBrokerExchange()
    {
        return $this->broker_exchange;
    }

    /**
     * Sets the value of contract_token.
     *
     * @param mixed $contract_token the contract token
     *
     * @return self
     */
    public function setContractToken($contract_token)
    {
        $this->contract_token = $contract_token;

        return $this;
    }

    /**
     * Gets the value of contract_token.
     *
     * @return mixed
     */
    public function getContractToken()
    {
        return $this->contract_token;
    }

    public function setItems($data)
    {

        $standardizedQuantity = null;
        if($this->ine($data, 'StandardizedQuantity') > 0) {
            $standardizedQuantity = $this->ine($data, 'StandardizedQuantity');
        }

        $this->setUid($this->ine($data, 'Uid'))
                ->setContractId($this->ine($data, 'contract_id'))
                ->setContractToken($this->ine($data, 'token'))
                ->setTransactionGropuRef($this->ine($data, 'TransactionGroupRef'))
                ->setBeginDate($this->ine($data, 'BeginDate'))
                ->setEndDate($this->ine($data, 'EndDate'))
                ->setTimeZone($this->ine($data, 'TimeZone'))
                ->setTradeDate($this->ine($data, 'TradeDate'))
                ->setPodba($this->ine($data, 'Podba'))
                ->setPodsl($this->ine($data, 'Podsl'))
                ->setClass($this->ine($data, 'Class'))
                ->setTerm($this->ine($data, 'Term'))
                ->setIncrement($this->ine($data, 'Increment'))
                ->setIncrementPeaking($this->ine($data, 'IncrementPeaking'))
                ->setProductName($this->ine($data, 'ProductName'))
                ->setQuantity($this->ine($data, 'Quantity'))
                ->setStandardizedQuantity($standardizedQuantity)
                ->setPrice($this->ine($data, 'Price'))
                ->setStandardizedPrice($this->ine($data, 'StandardizedPrice'))
                ->setRateUnits($this->ine($data, 'RateUnits'))
                ->setRateType($this->ine($data, 'RateType'))
                ->setTotalTransmissionCharge($this->ine($data, 'TotalTransmissionCharge'))
                ->setTransactionCharge($this->ine($data, 'TransactionCharge'))
                ->setFilingType($this->ine($data, 'FilingType'))
                ->setPodslHub($this->ine($data, 'PodslHub'))
                ->setBrokerExchange($this->ine($data, 'BrokerExchange'));

        return $this;
    }

    public function ine($dataArr = [], $key = null)
    {
        if(isset($dataArr[$key])) {
            return $dataArr[$key];
        }
        return null;
    }
}