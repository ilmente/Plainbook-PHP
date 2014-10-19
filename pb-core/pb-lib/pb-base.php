<?php
	
class PlainbookBase {
	public function __construct(){}
	
	public function __get($property){
		if (strpos($property, '__') === 0) return null;
		return $this->$property;
	}
};
	
?>