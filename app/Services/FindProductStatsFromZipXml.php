<?php
namespace App\Services;

use XMLReader;
use Illuminate\Support\Str;
use App\Entities\TransactionEntity;

class FindProductStatsFromZipXml
{
    protected $string = "Energy";
    protected $limit = "all";
    protected $quarter = 1;
    protected $year = 2019;
    protected $progressBar;

    protected $totalRevenue = 0;
    protected $totalQuantity = 0;

    public function __construct()
    {
    }

    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    public function setQuarter($quarter)
    {
        $this->quarter = $quarter;
        return $this;
    }

    public function setString($string)
    {
        $this->string = $string;
        return $this;
    }
    
    public function getSearchString()
    {
        return $this->string;
    }

    public function setLimit($limit = "all")
    {
        $this->limit = $limit;
        return $this;
    }

    public function setProgressBar($progressBar)
    {
        $this->progressBar = $progressBar;
        return $this;
    }

    public function exec()
    {
        $path = config("string_finder.xml_path");
        $path = sprintf($path, $this->year);
        $path .= "_".$this->quarter;
        $tmpPath = $path . "/tmp";
        $files = glob($path . '/*.[zZ][iI][pP]');
        $totalFiles = count($files);

        $bar = $this->progressBar->createProgressBar($totalFiles);
        $bar->start();

        foreach ($files as $key => $file) {
            
            if(($this->limit != "all") && ($key == $this->limit)) {
                break;
            }
            $zipFileName = basename($file);
            // error_log('Extraction Started');
            // extract files
            $extractZip = new ExtractZip($file, $tmpPath);
            
            // clean up tmp directory before extract files.
			$extractZip->cleanDestinationFolder($tmpPath);

			// extract zip file inside tmp folder.
            $extractZip->extract();
            // error_log('Extraction Completed');
            $isFindString = $this->readFilesFromDir($zipFileName, $tmpPath);
            // error_log('Result found');
            // remove extracted files.
            $extractZip->cleanDestinationFolder($tmpPath);
            $this->moveToBackupDir($file);
            // error_log('backup dir');
            // unlink($file);
            // if(($key+1)%10 == 0) {
            //     error_log("Total number of processed files are " . ($key+1) . "/" . $totalFiles);
            // }
            $bar->advance();

            // if($isFindString) {
            //     break;
            // }
        }
        $bar->finish();

        error_log("Product Name:- " . $this->string);
        error_log("Total Revenue:- " . $this->totalRevenue);
        error_log("Total Quantity:- " . $this->totalQuantity);
    }

    public function restoreFiles()
    {
        $path = config("string_finder.xml_path");
        $path = sprintf($path, $this->year);
        $path .= "_".$this->quarter;
        $backupPath = $path . "/backup/";
        $files = glob($backupPath . '/*.[zZ][iI][pP]');
        foreach($files as $file)
        {
            $zipFileName = basename($file);
            \File::move($file, $path."/".$zipFileName);
        }
    }

    private function readFilesFromDir($zipFileName, $tmpPath)
    {
        $files = glob($tmpPath . '/*.[xX][mM][lL]');
        $isFindString = false;
        foreach($files as $file)
        {
            $isFindString = $this->findString($zipFileName, $file);
        }
        return $isFindString;
    }

    public function findString($zipFileName, $file)
    {

        $searchString = Str::lower($this->getSearchString());
        $isFindString = false;
        $reader  = new XMLReader();
        $reader->open($file);

        while( $reader->read() ) {
            if($reader->name == "Transaction" && $reader->nodeType == XMLReader::ELEMENT) {
                
                $productName = $reader->getAttribute('ProductName');
                if(Str::lower($productName) != $searchString) {
                    continue;
                }
                $amount = (float)$reader->getAttribute('TransactionCharge');
                $sQuantity = $reader->getAttribute('StandardizedQuantity');
                $quantity = (float)$reader->getAttribute('Quantity');
                $this->totalRevenue += ((float) $amount) ?? 0;
                if($sQuantity != null) {
                    $this->totalQuantity += (float)$sQuantity;
                } else {
                    $this->totalQuantity += $quantity;
                }
                // $transactionEntity = new TransactionEntity;
				// $transactionEntity->setAttributes($reader);
                // $tData = $transactionEntity->getQuery();

                // $productName = isset($tData['product_name']) ? $tData['product_name'] : null;

                // if(Str::lower($productName) != $searchString) {
                //     continue;
                // }

                // $this->totalRevenue += ((float) $tData['transaction_charge']) ?? 0;


            }
            // if($reader->name == "Organization" && $reader->nodeType == XMLReader::ELEMENT) {
            //     $name = $reader->getAttribute('Name');
                
            //     $isSeller = $reader->getAttribute('IsSeller');
            //     $isBuyer = $reader->getAttribute('IsBuyer');
            //     if(strtolower($name) == strtolower($this->string)) {

            //         $calcuateRevenueObj = new SellerTransactions($file);
            //         $calcuateRevenueObj->filterTransactions();
            //         $revenue = $calcuateRevenueObj->getRevenue();
            //         $products = $calcuateRevenueObj->getProductNames();
            //         $podba = $calcuateRevenueObj->getPODBA();
            //         $podsl = $calcuateRevenueObj->getPODSL();
            //         error_log(" --------------------------------- ");
            //         error_log("'" . $name . "' string found in zip file name:- " . $zipFileName);
            //         error_log("Quarter: ".$this->quarter);
            //         error_log("Total Revenue: $revenue");
            //         error_log("Product Names: $products");
            //         error_log("Balancing Authorities: $podba");
            //         error_log("PODSL: $podsl");
            //         error_log("Is Seller: $isSeller");
            //         error_log("Is Buyer: $isBuyer");
            //         error_log(" --------------------------------- ");
            //         $isFindString = true;
            //         // break;
            //     }
            // }
        }

        $reader->close();
        // error_log($this->totalRevenue );
        return $isFindString;
    }

    private function moveToBackupDir($file)
    {
        $zipFileName = basename($file);
        $path = config("string_finder.xml_path");
        $path = sprintf($path, $this->year);
        $path .= "_".$this->quarter;
        $backupPath = $path . "/backup/$zipFileName";

        \File::move($file, $backupPath);
    }
}
