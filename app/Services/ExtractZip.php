<?php 
namespace App\Services;

use ZipArchive;

class ExtractZip {

	protected $sourcePath;
	protected $destinationPath;

	public function __construct($path, $destinationPath = null)
	{
		$this->sourcePath = $path;
		$this->destinationPath = $destinationPath ?? storage_path('/');
	}

	public function setSourceLocation($sourcePath)
	{
		$this->sourcePath = $sourcePath;
	}

	/**
	 * change destination path.
	 * 
	 * @param string of path.
	 */
	public function setDestinationPath($path)
	{
		$this->destinationPath = $path;
		return $this;
	}

	/**
	 * extract zip file and place extracted files to destination location.
	 * 
	 * @return boolean true.
	 */
	public function extract()
	{
		$zip = new ZipArchive;
		$res = $zip->open($this->sourcePath);
		if ($res === TRUE) {
		    $zip->extractTo($this->destinationPath);
		    $zip->close();
		} else {
			dd('file could not be extract.');
		}
		return true;
	}

	/**
	 * clean up destination folder.
	 * 
	 * @return boolean true.
	 */
	public function cleanDestinationFolder($path)
	{
		$files = glob($path.'/*');
		if(empty($files)) {
			return true;
		}

		foreach ($files as $key => $file) {
			if(is_dir($file)) { 
				$this->cleanDestinationFolder($file);
				rmdir($file);
			} else {
				unlink($file);
			}
		}

		return true;
	}

}