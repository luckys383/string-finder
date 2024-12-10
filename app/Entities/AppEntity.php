<?php

namespace App\Entities;

class AppEntity
{

	protected $fields = [];
	protected $items;

	public function __construct()
	{
		$this->items = collect([]);
	}

	public function setZipFileName($value)
	{
		$this->ZipFileName = $value;
		return $this;
	}

	public function setXmlFileName($value)
	{
		$this->XmlFileName = $value;
		return $this;
	}

	public function setCsvFileName($value)
	{
		$this->CsvFileName = $value;
		return $this;
	}

	public function getAttributes()
	{
		$attributes = [];
		foreach ($this->fields as $key => $field) {
			$attributes[$field] = $this->{$field};
		}

		return $attributes;
	}

	public function setAttributes($reader)
	{
		foreach ($this->fields as $key => $field) {

			/*if(($field == 'Name') && (env('APP_ENV') == "local")) {
				\Log::info($reader->getAttribute($field));
			}*/

			$this->{$field} = $reader->getAttribute($field);
		}

		return $this;
	}

	public function setItems($reader)
	{
		foreach ($reader as $key => $item) {
			$this->setAttributes($item);
			$this->items->push($this->getAttributes());
		}
		return $this;
	}

	public function get()
	{
		return $this->items;
	}

	/**
	 * check value and set bool value in response.
	 *
	 * @param  $value: mix value
	 * @return boolean (true/false/null)
	 */
	public function getBoolFieldValue($value = null)
	{
		if(!trim($value)) {
			return null;
		}

		if(in_array($value, ['Y', 'y', 'Yes', 'yes', 'true', true, '1', 1])) {
			return true;
		}
		return false;
	}
}