<?php
	
class PlainbookApp extends PlainbookBase {	
	public function __construct(){}
	
	public function run(){
		$pb = new PlainbookContext(); 
		
		function loadTemplate($pb){
			function partial($partial, $context = null){
				include PB_BASE_DIR.'pb-theme/'.$partial.'.php';
			}
			
			include PB_BASE_DIR.'pb-theme/'.$pb->template.'.php';
		};
		
		$defaultDir = PB_BASE_DIR.'pb-theme/default.php';
		$templateDir = PB_BASE_DIR.'pb-theme/'.$pb->template.'.php';
		
		if (file_exists($templateDir)){
			call_user_func('loadTemplate', $pb);
			return true;
		}
		
		$pb->template = 'default';
		if (file_exists($defaultDir)){
			call_user_func('loadTemplate', $pb);
			return true;
		}
		
		return false;
	}
};
	
?>