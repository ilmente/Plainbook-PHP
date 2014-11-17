<?php

/**
 * Plainbook dummy class
 * @package PB
 */
class PlainbookDummy {
	protected $__config;
	
	/**
	 * Constructor
	 * @param array $config 
	 */
	public function __construct($config){
		$this->__config = $config;
	}
	
	/**
	 * Magic method that exposes the public and protected properties in readonly-mode.
	 * If the property doesn't exist, it returns a new PlainbookDummy instance.
	 * @param string $property 
	 * @return mixed
	 */
	public function __get($property){
		if (property_exists($this, $property)) return $this->property;
		return new PlainbookDummy($this->__config);
	}

	/**
	 * Magic method that returns a PlainbookDummy for any function you will call.
	 * @param string $name 
	 * @param array(mixed) $arguments 
	 * @return PlainbookDummy
	 */
	public function __call($name, $arguments){
    	return new PlainbookDummy($this->__config);
    }

    /**
     * Magic method that returns a PlainbookDummy for any static function you will call.
     * @param string $name 
	 * @param array(mixed) $arguments 
	 * @return PlainbookDummy
     */
    public static function __callStatic($name, $arguments){
    	return new PlainbookDummy($this->__config);
    }

    /**
     * Magic method that returns a dummy string: "pb.dummy" if in debug mode, empty if not.
     * @return string
     */
	public function __toString(){
        return ($this->__config['debug']) ? 'pb.dummy' : '';
    }
};
	
?>