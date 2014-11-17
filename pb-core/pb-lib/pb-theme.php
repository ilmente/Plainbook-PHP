<?php
	
/**
 * Plainbook theme-management class.
 * @package PB
 */
class PlainbookTheme extends PlainbookBase {
	protected $name;
	protected $url;
	protected $dir;
	protected $__site;
	protected $__data;
	
	/**
	 * Contructor.
	 * @param array(mixed) $config 
	 * @param PlainbookSite &$site 
	 * @param PlainbookData &$data
	 */
	public function __construct($config, &$site, &$data){
		parent::__construct($config);
		
		$this->name = $config['pb.theme.name'];
		$this->url = $config['pb.theme.url'];
		$this->dir = $config['pb.theme.dir'];
		$this->__site = $site;
		$this->__data = $data;
	}
	
	/**
	 * Renders the partial template element for the current page.
	 * It includes $site, $data and $theme in the accessible scope.
	 * @param string $template 
	 * @param integer $httpCode (optional)
	 */
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