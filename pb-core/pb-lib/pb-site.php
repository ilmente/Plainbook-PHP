<?php
	
class PlainbookSite extends PlainbookBase {
	protected $name;
	protected $url;
	protected $config;
	
	public function __construct($config){
		parent::__construct($config);
		
		$this->name = $config['pb.site.name'];
		$this->url = $config['pb.site.url'];
		$this->config = (object) $config;
	}
};
	
?>