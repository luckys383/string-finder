<?php
namespace App\Services;

use Illuminate\Support\Str;
use XMLReader;

class FindFromZipXml
{
    protected $string = "Frenchtown II Solar";
    protected $limit = "all";
    protected $quarter = 1;

    public function __construct()
    {
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

    public function setLimit($limit = "all")
    {
        $this->limit = $limit;
        return $this;
    }

    public function exec()
    {
        $path = config("string_finder.xml_path");
        $path .= "_".$this->quarter;
        $tmpPath = $path . "/tmp";
        $files = glob($path . '/*.[zZ][iI][pP]');
        $totalFiles = count($files);

        foreach ($files as $key => $file) {
            
            if(($this->limit != "all") && ($key == $this->limit)) {
                break;
            }
            $zipFileName = basename($file);
            
            // extract files
            $extractZip = new ExtractZip($file, $tmpPath);
            
            // clean up tmp directory before extract files.
			$extractZip->cleanDestinationFolder($tmpPath);

			// extract zip file inside tmp folder.
            $extractZip->extract();

            $this->readFilesFromDir($zipFileName, $tmpPath);

            // remove extracted files.
            $extractZip->cleanDestinationFolder($tmpPath);
            $this->moveToBackupDir($file);
            // unlink($file);
            if(($key+1)%10 == 0) {
                error_log("Total number of processed files are " . ($key+1) . "/" . $totalFiles);
            }
        }
    }

    public function restoreFiles()
    {
        $path = config("string_finder.xml_path");
        $path .= "_".$this->quarter;
        $backupPath = $path . "/backup";
        $files = glob($backupPath . '/*.[zZ][iI][pP]');
        foreach($files as $file)
        {
            \File::move($file, $path);
        }
    }

    private function readFilesFromDir($zipFileName, $tmpPath)
    {
        $files = glob($tmpPath . '/*.[xX][mM][lL]');
        
        foreach($files as $file)
        {
            $this->findString($zipFileName, $file);
        }
    }

    public function findString($zipFileName, $file)
    {
        $reader  = new XMLReader();
        $reader->open($file);
        while( $reader->read() ) {
            if($reader->name == "Organization" && $reader->nodeType == XMLReader::ELEMENT) {
                $name = $reader->getAttribute('Name');
                if(strtolower($name) == strtolower($this->string)) {
                    $isSeller = $reader->getAttribute('IsSeller');
                    $isBuyer = $reader->getAttribute('IsBuyer');

                    error_log(" --------------------------------- ");
                    error_log("'" . $name . "' string found in zip file name:- " . $zipFileName);
                    error_log("Is Seller: $isSeller");
                    error_log("Is Buyer: $isBuyer");
                    error_log(" --------------------------------- ");
                    break;
                }
            }
        }

        $reader->close();
    }

    private function moveToBackupDir($file)
    {
        $zipFileName = basename($file);
        $path = config("string_finder.xml_path");
        $path .= "_".$this->quarter;
        $backupPath = $path . "/backup/$zipFileName";

        \File::move($file, $backupPath);
    }
}
