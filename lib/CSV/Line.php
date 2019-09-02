<?php
namespace VCob\CSV;

class Line {

	private $fields = [];

	function __construct(...$fields) {
		$this->addFields($fields);
	}

	public function addFields(...$fields) {
		$this->fields = array_merge($this->fields, $fields);
	}

	public function getFields() {
		return $this->fields;
	}

	public function getField($index) {
		return $this->fields[$index];
	}

	public function setField($index, $value) {
		$this->fields[$index] = $value;
	}
}