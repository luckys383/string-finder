<?php
namespace App\Services;

use XMLReader;

class SellerTransactions
{
    protected $file;
    protected $revenue = 0;
    protected $productNames = [];
    protected $podba = [];
    protected $podsl = [];

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function filterTransactions()
    {
        $reader  = new XMLReader();
        $reader->open($this->file);
        while( $reader->read() ) {
            if($reader->name == "Transaction" && $reader->nodeType == XMLReader::ELEMENT) {
                $revenue = (float)$reader->getAttribute('TransactionCharge');
                $this->productNames[] = $reader->getAttribute('ProductName');
                $this->podba[] = $reader->getAttribute('Podba');
                $this->podsl[] = $reader->getAttribute('Podsl');

                $this->revenue += $revenue;
            }
        }
        
        $reader->close();
    }

    public function getRevenue()
    {
        return $this->revenue;
    }

    public function getProductNames()
    {
        if(!$this->productNames) {
            return "";
        }

        $items = collect($this->productNames);
        return $items->unique()->implode(', ');
    }

    public function getPODBA()
    {
        if(!$this->podba) {
            return "";
        }

        $items = collect($this->podba);
        return $items->unique()->implode(', ');
    }

    public function getPODSL()
    {
        if(!$this->podsl) {
            return "";
        }

        $items = collect($this->podsl);
        return $items->unique()->implode(', ');
    }
}