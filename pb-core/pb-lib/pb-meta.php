<?php

/**
 * Plainbook meta field class
 * @package PB
 */
class PlainbookMeta extends PlainbookBase {
	protected $__value;
	
	/**
	 * Constructor
	 * @param array $config 
	 * @param string $value 
	 */
	public function __construct($config, $value){
		parent::__construct($config);
		
		$this->__value = $value;
	}


	public function toList($separator = ','){
		$rawList = explode($separator, $this->__value);
		$list = array();

		foreach ($rawList as $item){
			$item = trim($item);
			if ($item != '') array_push($list, $item);	
		}

		return $list;
	}

	public function toJSON(){
		return json_decode($this->__value);
	}

    /**
     * Magic method that returns the value of the field.
     * @return string
     */
	public function __toString(){
        return $this->__value;
    }
};
	
?>