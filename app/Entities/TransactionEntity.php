<?php

namespace App\Entities;

use App\Entities\AppEntity;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionEntity extends AppEntity
{
	protected $fields = [
		'Uid', 'contract_id', 'token', 'TransactionGroupRef', 'BeginDate', 
		'EndDate', 'TimeZone', 'TradeDate', 'Podba', 'Podsl', 'Class', 
		'Term', 'Increment', 'IncrementPeaking', 'ProductName', 
		'Quantity', 'StandardizedQuantity', 'Price', 'StandardizedPrice', 
		'RateUnits', 'RateType', 'TotalTransmissionCharge', 
		'TransactionCharge', 'FilingType', 'PodslHub', 'BrokerExchange'
	];

	public function setContractId($contractId)
	{
		$this->contract_id = $contractId;
		return $this;
	}

	public function setToken($token)
	{
		$this->token = $token;
		return $this;
	}

	/**
	 * set fields for save data to transactions table.
	 * 
	 * @return string of all the fields concatinated with comma.
	 */
	/*public function getFields()
	{
		$fields = [
			'uid', 'contract_id', 'transaction_group_ref','time_zone','trade_date',
			'podba','podsl','transaction_class','term','increment','increment_peaking',
			'product_name','quantity','standardized_quantity','price','standardized_price',
			'rate_units','rate_type','total_transmission_charge','transaction_charge',
			'filing_type', 'podsl_hub', 'broker_exchange', 'token'
		];
		$fields = implode(',',$fields);

		return $fields;
	}*/

	public function getQuery()
	{
		$transactionModel = new Transaction;
		$transactionModel->setItems($this->getAttributes());
		$dataArr = $transactionModel->toArray();
		$fields = $transactionModel->getFillable();

		$data = [];
		foreach ($fields as $key => $field) {
			$data[$field] = isset($dataArr[$field]) ? $dataArr[$field] : null;
		}
		return $data;
	}
	
}