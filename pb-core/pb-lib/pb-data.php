<?php
	
class PlainbookData extends PlainbookBase {
	protected $current;
	
	protected $__fs;
	protected $__currentFile;
	protected $__dummy;
	protected $__all;
	
	protected $__lazy_prev;
	protected $__lazy_next;
	
	public function __construct($config, $fs, $currentFile){
		parent::__construct($config);

		$this->__fs = $fs;
		$this->__currentFile = $currentFile;
		$this->__dummy = (object) array(
			'exists' => false
		);
		
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
	
	protected function getPrev(){
		return $this->getAround(-1);
	}
	
	protected function getNext(){
		return $this->getAround(1);
	}
	
	public function get($path){
		$file = $this->__fs->getFile($path);
		if (isset($file)) return $this->getFileInfos($file);
		return $this->__dummy;
	}
	
	public function around($offset, $params = array()){
		$filtered = $this->all($params);
		
		$position = array_search($this->current, $filtered);
		if ($position === false) return $this->__dummy;
	
		$position += $offset;
		if ($position < 0 || $position >= count($filtered)) return $this->__dummy;
		
		return $filtered[$position];
	}
	
	public function all($params = array()){
		if (!isset($this->__all)) $this->__all = $this->getFilesInfos();
		if (empty($params)) return $this->__all;
		
		$filtered = array();
		$params = array_merge(array(
			'root' => '/',
			'deep' => 0,
			'orderBy' => $this->__config['pb.contents.orderBy'],
			'orderAsc' => $this->__config['pb.contents.orderAsc'],
			//'limit' => 0
		), $params);
		$deep = substr_count($params['root'], '/') + $params['deep'] - 1;
		
		foreach($this->__all as $infos){
			if (strpos($infos->path, $params['root']) !== false){
				if ($params['deep'] === 0 || $deep >= $infos->level) array_push($filtered, $infos);
			}
		}
		
		if ($params['orderBy'] != ''){
		    uasort($filtered, function($item1, $item2) use ($params){
				$order = $params['orderAsc'] ? 1 : -1;
				$property = $params['orderBy'];
				$item1 = $item1->meta;
				$item2 = $item2->meta;
				$value1 = property_exists($item1, $property) ? $item1->$property : ($params['orderAsc'] ? 99999999 : -1);
				$value2 = property_exists($item2, $property) ? $item2->$property : ($params['orderAsc'] ? 99999999 : -1);
			
				return ($value1 >= $value2) ? $order : -$order;
		    });
		}
		
		return $filtered;
	}
};
	
?>