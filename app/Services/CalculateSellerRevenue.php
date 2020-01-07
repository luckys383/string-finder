<?php
namespace App\Services;

use XMLReader;

class CalculateSellerRevenue
{
    protected $file;
    protected $revenue = 0;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function calculate()
    {
        $reader  = new XMLReader();
        $reader->open($this->file);
        while( $reader->read() ) {
            if($reader->name == "Transaction" && $reader->nodeType == XMLReader::ELEMENT) {
                $revenue = (float)$reader->getAttribute('TransactionCharge');
                $this->revenue += $revenue;
            }
        }
        
        $reader->close();
    }

    public function getRevenue()
    {
        return $this->revenue;
    }
}