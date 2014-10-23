<?php
	
class PlainbookLoader extends PlainbookBase {
	public function __construct($config){
		parent::__construct($config);
	}
	
	public function load($path, $fileNotFound, $httpCode = 200){
		$fs = new PlainbookFS($this->__config);
		$file = $fs->getFile($path);
		
		//if (isset($file)){
			$site = new PlainbookSite($this->__config);
			$data = new PlainbookData($this->__config, $fs, $file);
			$theme = new PlainbookTheme($this->__config, $site, $data);

			$theme->render($data->current->template, $httpCode);
			//} else {
			//$fileNotFound($path);
			//}
	}
};
	
?>