<?php
	
class PlainbookData extends PlainbookBase {
	protected $current;
	protected $__currentFile;
	protected $__fs;
	protected $__all;
	
	public function __construct($config, $fs, $currentFile){
		parent::__construct($config);
		
		$this->__fs = $fs;
		$this->__currentFile = $currentFile;
		$this->current = $this->getFileInfos($currentFile);
	}
	
	protected function getFileInfos($file){
		$fileRawContent = $this->__fs->readFile($file);
		return new PlainbookInfos($this->__config, $file, $this->__currentFile, $fileRawContent);
	}
	
	protected function getFilesInfos(){
		$all = array();
		$files = $this->__fs->getFiles();
		foreach($files as $file) array_push($all, $this->getFileInfos($file));
		return $all;
	}
	
	public function get($path){
		$file = $this->__fs->getFile($path);
		if (isset($file)) return $this->getFileInfos($file);
		
		return (object) array(
			'exists' => false
		);
	}
	
	public function query($params = array()){
		if (!isset($this->__all)) $this->__all = $this->getFilesInfos();
		
		$query = array();
		$params = array_merge(array(
			'root' => $this->current->path,
			'deep' => 0,
			'orderBy' => '',
			'orderAsc' => true,
			//'limit' => 0
		), $params);
		$deep = substr_count($params['root'], '/') + $params['deep'] - 1;
		
		foreach($this->__all as $infos){
			if (strpos($infos->path, $params['root']) !== false){
				if ($params['deep'] === 0 || $deep >= $infos->level) array_push($query, $infos);
			}
		}
		
	    uasort($query, function($item1, $item2) use ($params){
			$order = $params['orderAsc'] ? 1 : -1;
			$property = 'path';
			
			if ($params['orderBy'] != ''){
				$property = $params['orderBy'];
				$item1 = $item1->meta;
				$item2 = $item2->meta;
			}
			
			$value1 = property_exists($item1, $property) ? $item1->$property : ($params['orderAsc'] ? 99999999 : -1);
			$value2 = property_exists($item2, $property) ? $item2->$property : ($params['orderAsc'] ? 99999999 : -1);
			
			return ($value1 >= $value2) ? $order : -$order;
	    });
		
		return $query;
	}
};
	
?>