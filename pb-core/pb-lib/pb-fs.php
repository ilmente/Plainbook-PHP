<?php
	
class PlainbookFS extends PlainbookBase {
	public function __construct(){}
		
	public function getFile($path = ''){
		if ($path == ''){
			$requestPath = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
			$scriptPath = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
		}

		if ($requestPath != $scriptPath) $path = trim(preg_replace('/'.str_replace('/', '\/', str_replace('index.php', '', $scriptPath)).'/', '', $requestPath, 1), '/');
		$path = preg_replace('/\?.*/', '', $path);

		if ($path) $file = PB_CONTENT_DIR.$path;
		else $file = PB_CONTENT_DIR.'index';
	
		if (is_dir($file)) return PB_CONTENT_DIR.$path.'/index'.PB_CONTENT_EXT;
		return $file.PB_CONTENT_EXT;
	}
	
	public function getAllFiles($root = PB_CONTENT_DIR, &$files = array()){
	    if ($handle = opendir($root)){
	        while (false !== ($file = readdir($handle))){
	            if (preg_match('/^[^_|^.]\w+/i', $file) > 0){
					$file = $root.$file;
				
	                if (is_dir($file)) $this->getAllFiles($file.'/', $files);
	                else if (preg_match('/\w+(\\'.PB_CONTENT_EXT.')$/i', $file) > 0) array_push($files, $file);
	            }
	        }
	        closedir($handle);
	    }
		return $files;
	}
	
	public function readFile($file, $return404IfNotFound = true){
		if (file_exists($file)) return file_get_contents($file);
			
		if ($return404IfNotFound){
			header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
			return file_get_contents(PB_CONTENT_DIR.'_404'.PB_CONTENT_EXT);
		}
		
		return '';
	}
};
	
?>