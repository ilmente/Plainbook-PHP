<?php
	
/**
 * Plainbook filesystem class.
 * @package PB
 */
class PlainbookFS extends PlainbookBase {

	/**
	 * Constructor.
	 * @param array(mixed) $config 
	 */
	public function __construct($config){
		parent::__construct($config);
	}
	
	/**
	 * Returns the full path (directory) of a given file relative path (default is root).
	 * @param string $path (optional)
	 * @return string or null
	 */	
	public function getFile($path = '/'){
		$path = preg_replace($this->__config['pb.regexp.path'], '', $path);

		if ($path) $file = $this->__config['pb.contents.dir'].$path;
		else $file = $this->__config['pb.contents.dir'].'index';
		
		if (is_dir($file)) $file .= '/index';
		$file .= $this->__config['pb.contents.extension'];

		if (file_exists($file)) return $file;
		return null;
	}
	
	/**
	 * Returns the full path (directory) of each file under a certain root.
	 * @param string $root (optional)
	 * @param type &$files (optional)
	 * @return array(string)
	 */
	public function getFiles($root = null, &$files = array()){
		if (!isset($root)) $root = $this->__config['pb.contents.dir'];
		
	    if ($handle = opendir($root)){
	        while (($file = readdir($handle)) !== false){
	            if (strpos($file, '.') !== 0){
					$file = $root.$file;
	                if (is_dir($file)){
	                	if (preg_match($this->__config['pb.regexp.visible_directories'], $file) > 0){
	                		$this->getFiles($file.'/', $files);
	                	}
	                } else {
						if (preg_match($this->__config['pb.regexp.visible_files'], $file) > 0){
							array_push($files, $file);
						}					
	                }
	            }
	        }
	        closedir($handle);
	    }
		
	    uasort($files, function($file1, $file2){
			$uri1 = preg_replace($this->__config['pb.regexp.uri'], '', $file1).'/';
			$uri2 = preg_replace($this->__config['pb.regexp.uri'], '', $file2).'/';
			
			return ($uri1 >= $uri2) ? 1 : -1;
	    });
		
		return $files;
	}
	
	/**
	 * Reads the contents of a specific file (giving its directory).
	 * @param string $file 
	 * @return string
	 */
	public function readFile($file){
		if (isset($file) && file_exists($file)) return file_get_contents($file);
		else return '';
	}
};
	
?>