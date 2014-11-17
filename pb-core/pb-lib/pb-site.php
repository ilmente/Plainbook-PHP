<?php
	
/**
 * Plainbook site informations class.
 * @package PB
 */
class PlainbookSite extends PlainbookBase {
	protected $name;
	protected $url;
	protected $config;
	
	/**
	 * Contructor.
	 * @param array(mixed) $config 
	 */
	public function __construct($config){
		parent::__construct($config);
		
		$this->name = $config['pb.site.name'];
		$this->url = $config['pb.site.url'];
		$this->config = (object) $config;
	}
};
	
?>