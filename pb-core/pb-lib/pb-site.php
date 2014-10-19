<?php
	
class PlainbookSite extends PlainbookBase {
	protected $name;
	protected $baseUri;
	protected $themeUri;
	
	public function __construct(){
		$this->name = PB_SITE_NAME;
		$this->baseUri = PB_BASE_URL;
		$this->themeUri = PB_BASE_URL.'/pb-theme';
	}
};
	
?>