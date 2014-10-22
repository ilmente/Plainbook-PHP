<?php
	
class PlainbookFS extends PlainbookBase {
	protected $__config;
	
	public function __construct($config){
		$this->__config = $config;
	}
		
	public function getFile($path = ''){
		$path = preg_replace('/\?.*/', '', $path);

		if ($path) $file = $this->__config['pb.contents.dir'].$path;
		else $file = $this->__config['pb.contents.dir'].'index';
		
		if (is_dir($file)) $file .= '/index';
		$file .= $this->__config['pb.contents.extension'];

		if (file_exists($file)) return $file;
		return null;
	}
	
	public function getFiles($root = null, &$files = array()){
		if (!isset($root)) $root = $this->__config['pb.contents.dir'];
		
	    if ($handle = opendir($root)){
	        while (false !== ($file = readdir($handle))){
	            if (preg_match('/^[^_|^.]\w+/i', $file) > 0){
					$file = $root.$file;
	                if (is_dir($file)) $this->getFiles($file.'/', $files);
	                else {
						if (preg_match('/\w+(\\'.$this->__config['pb.contents.extension'].')$/i', $file) > 0){
							array_push($files, $file);
						}					
	                }
	            }
	        }
	        closedir($handle);
	    }
		
		return $files;
	}
	
	public function readFile($file){
		if (isset($file) && file_exists($file)) return file_get_contents($file);
		else return '';
	}
};
	
?>