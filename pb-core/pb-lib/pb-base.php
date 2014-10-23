<?php
	
class PlainbookBase {
	protected $__config;
	
	public function __construct($config){
		$this->__config = $config;
	}
	
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
};
	
?>