<?php
	
class PlainbookApp extends PlainbookBase {	
	public function __construct(){}
	
	public function run(){
		$pb = new PlainbookContext(); 
		
		function __loadTemplate($pb){
			function partial($partial, $context = null){
				include PB_THEME_DIR.$partial.'.php';
			}
			
			include PB_THEME_DIR.$pb->template.'.php';
		};
		
		$defaultDir = PB_THEME_DIR.'default.php';
		$templateDir = PB_THEME_DIR.$pb->template.'.php';
		
		if (file_exists($templateDir)){
			call_user_func('__loadTemplate', $pb);
			return true;
		}
		
		$pb->template = 'default';
		if (file_exists($defaultDir)){
			call_user_func('__loadTemplate', $pb);
			return true;
		}
		
		return false;
	}
};
	
?>