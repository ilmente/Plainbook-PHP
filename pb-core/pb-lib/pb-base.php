<?php

/**
 * Plainbook base class.
 * @package PB
 */
class PlainbookBase {
	protected $__config;
	
	/**
	 * Constructor.
	 * @param array(mixed) $config 
	 */
	public function __construct($config){
		$this->__config = $config;
	}
	
	/**
	 * Magic method that exposes the public and protected properties in readonly-mode.
	 * If the property starts with "__", it means that it cannot be accessed.
	 * If exists a property called "__lazy_".$property, it checks the value:
	 * - missing value: the method tries to retrieve the value calling a specific function ('get'.$property), saves the value and returns it;
	 * - existing value: it's returned.
	 * @param string $property 
	 * @return mixed
	 */
	public function __get($property){
		if (strpos($property, '__') === 0) return null;
		
		$lazyProperty = '__lazy_'.$property;
		$lazyPropertyGetter = 'get'.ucfirst($property);
		
		if (property_exists($this, $lazyProperty)){
			if (isset($this->$lazyProperty)) return $this->$lazyProperty;
			
			if (method_exists($this, $lazyPropertyGetter)){
				$this->$lazyProperty = call_user_func(array($this, $lazyPropertyGetter));
			}
			
			return $this->$lazyProperty;
		} else {
			return $this->$property;
		}
	}

	/**
	 * Magic method that return the classname everytime this class is printed.
	 * @return string
	 */
	public function __toString(){
        return get_class($this);
    }
};
	
?>