<?php
	
class PlainbookContext extends PlainbookBase {
	protected $site;
	protected $current;
	protected $__externalContext;
	protected $__fs;
	protected $__all;
	protected $__loadContents;
	
	public function __construct(){
		$this->__fs = new PlainbookFS();
		$this->__loadContents = false;
		
		$currentFile = $this->__fs->getFile();
		$currentFileRawContent = $this->__fs->readFile($currentFile);
		
		$this->site = new PlainbookSite();
		$this->current = new PlainbookInfos($currentFile, $currentFile, $currentFileRawContent, true);
	}
	
	public function get($path){
		$file = $this->__fs->getFile($path);
		$fileRawContent = $this->__fs->readFile($file);
		return new PlainbookInfos($file, $this->current->dir, $fileRawContent, true);
	}
	
	public function query($params = array()){
		$all = $this->getAllInfos();
		$query = array();
		
		$default = array(
			'root' => $this->current->path,
			'deep' => 0,
			'orderBy' => '',
			'orderAsc' => true,
		);
		
		$params = array_merge($default, $params);
		$deep = preg_match_all('/\//m', $params['root']) + $params['deep'] - 1;
		
		foreach($all as $infos){
			if (preg_match('/^('.preg_quote($params['root'], '/').')/', $infos->path) > 0){
				if ($params['deep'] === 0 || $deep >= $infos->level) array_push($query, $infos);
			}
		}
		
	    uasort($query, function($item1, $item2) use ($params){
			$order = $params['orderAsc'] ? 1 : -1;
			$property = 'path';
			
			if ($params['orderBy'] <> ''){
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
	
	public function loadContents($loadContents){
		$this->__all = null;
		return $this->__loadContents = $loadContents;
	}
	
	protected function getAllInfos(){
		if (isset($this->__all)) return $this->__all;

		$currentFile = $this->__fs->getFile();
		$allFiles = $this->__fs->getAllFiles();
		$this->__all = array();
		
		foreach($allFiles as $file){
			$fileRawContent = $this->__fs->readFile($file);
			$infos = new PlainbookInfos($file, $currentFile, $fileRawContent, $this->__loadContents);
			array_push($this->__all, $infos);
		}
		
		return $this->__all;
	}
};
	
?>