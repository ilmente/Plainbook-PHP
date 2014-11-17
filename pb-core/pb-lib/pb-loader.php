<?php
	
/**
 * Plainbook CMS pages loader class.
 * @package PB
 */
class PlainbookLoader extends PlainbookBase {

	/**
	 * Constructor.
	 * @param array(mixed) $config 
	 */
	public function __construct($config){
		parent::__construct($config);
	}
	
	/**
	 * Load a single page.
	 * @param string $path 
	 * @param function $fileNotFound 
	 * @param integer $httpCode (optional)
	 */
	public function single($path, $fileNotFound, $httpCode = 200){
		$this->pagination($path, 0, $fileNotFound, $httpCode);
	}
	
	/**
	 * Load a list of pages, paginated. #WIP
	 * @param string $path 
	 * @param integer $page 
	 * @param function $fileNotFound 
	 * @param integer $httpCode (optional)
	 */
	public function pagination($path, $page, $fileNotFound, $httpCode = 200){
		$fs = new PlainbookFS($this->__config);
		$file = $fs->getFile($path);
		
		if (isset($file)){
			$site = new PlainbookSite($this->__config);
			$data = new PlainbookData($this->__config, $fs, $file);
			$theme = new PlainbookTheme($this->__config, $site, $data);

			$theme->render($data->current->template, $httpCode);
		} else {
			$fileNotFound($path);
		}
	}
};
	
?>