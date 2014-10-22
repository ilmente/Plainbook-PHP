<?php
	
class PlainbookTheme extends PlainbookBase {
	protected $name;
	protected $url;
	protected $dir;
	protected $__site;
	protected $__data;
	
	public function __construct($config, &$site, &$data){
		$this->name = $config['pb.theme.name'];
		$this->url = $config['pb.theme.url'];
		$this->dir = $config['pb.theme.dir'];
		$this->__site = $site;
		$this->__data = $data;
	}
	
	public function render($template, $httpCode = 200){
		$pb = \Slim\Slim::getInstance();
		$pb->render($template.'.php', array(
			'site' => $this->__site,
			'data' => $this->__data,
			'theme' => $this
		), $httpCode);
	}

};
	
?>