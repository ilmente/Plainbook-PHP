<?php
	
/**
 * Plainbook data class: it provide the proepries and the methods to access the contents and the informations of the markdown files of the site.
 * @package PB
 */
class PlainbookData extends PlainbookBase {
	protected $current;
	
	protected $__fs;
	protected $__currentFile;
	protected $__all;
	
	protected $__lazy_prev;
	protected $__lazy_next;
	
	/**
	 * Constructor.
	 * @param array(mixed) $config 
	 * @param PlainbookFS $fs 
	 * @param string $currentFile
	 */
	public function __construct($config, $fs, $currentFile){
		parent::__construct($config);

		$this->__fs = $fs;
		$this->__currentFile = $currentFile;
		
		$this->current = $this->getFileInfos($currentFile);
	}
	
	/**
	 * Get the informations of a specific file, giving the file directory.
	 * @param string $file 
	 * @return PlainbookInfos
	 */
	protected function getFileInfos($file){
		$fileRawContent = $this->__fs->readFile($file);
		return new PlainbookInfos($this->__config, $file, $this->__currentFile, $fileRawContent);
	}
	
	/**
	 * Get the informations of all files.
	 * @return array(PlainbookInfos)
	 */
	protected function getFilesInfos(){
		$all = array();
		$files = $this->__fs->getFiles();
		foreach($files as $file) array_push($all, $this->getFileInfos($file));
		return $all;
	}
	
	/**
	 * Get the informations of the previous file.
	 * @return PlainbookInfos
	 */
	protected function getPrev(){
		return $this->getAround(-1);
	}
	
	/**
	 * Get the informations of the next file.
	 * @return PlainbookInfos
	 */
	protected function getNext(){
		return $this->getAround(1);
	}
	
	/**
	 * Get the informations of a specific file, giving the file relative path.
	 * If the file doesn't exist, it return a dummy class.
	 * @param string $path 
	 * @return mixed - PlainbookInfos or PlainbookDummy
	 */
	public function get($path){
		$file = $this->__fs->getFile($path);
		if (isset($file)) return $this->getFileInfos($file);
		return new PlainbookDummy($this->__config);
	}
	
	/**
	 * Get the informations of specific file, giving the offset (in terms of position) of the file.
	 * You can filter them passing a query object. - see below: all().
	 * @param int $offset 
	 * @param array(mixed) $query (optional)
	 * @return PlainbookInfos
	 */
	public function around($offset, $query = array()){
		$filtered = $this->all($query);
		
		$position = array_search($this->current, $filtered);
		if ($position === false) return $this->__dummy;
	
		$position += $offset;
		if ($position < 0 || $position >= count($filtered)) return $this->__dummy;
		
		return $filtered[$position];
	}
	
	/**
	 * Get the informations of all files. 
	 * You can filter them passing a query object.
	 * Default:
	 * 		'root' 		=> root path for filtering: it returns all the files under this path (default: "/", site root)
	 *		'deep' 		=> number of levels the tree must be navigate through, starting from root (default: "0", all levels)
	 *		'orderBy' 	=> meta field used to sort the files (default: configuration settings - alphabetically by path)
	 *		'orderAsc' 	=> sorting direction (default: configuration settings - ASC)
	 * The default query returns all the files inside the site, sorted by path, ASC.
	 * @param type $query (optional)
	 * @return array(PlainbookInfos)
	 */
	public function all($query = array()){
		if (!isset($this->__all)) $this->__all = $this->getFilesInfos();
		if (empty($query)) return $this->__all;
		
		$filtered = array();
		$query = array_merge(array(
			'root' => '/',
			'deep' => 0,
			'orderBy' => $this->__config['pb.contents.orderBy'],
			'orderAsc' => $this->__config['pb.contents.orderAsc'],
			//'limit' => 0
		), $query);
		$deep = substr_count($query['root'], '/') + $query['deep'] - 1;
		
		foreach($this->__all as $infos){
			if (strpos($infos->path, $query['root']) !== false){
				if ($query['deep'] === 0 || $deep >= $infos->level) array_push($filtered, $infos);
			}
		}
		
		if ($query['orderBy'] != ''){
		    uasort($filtered, function($item1, $item2) use ($query){
				$order = $query['orderAsc'] ? 1 : -1;
				$property = $query['orderBy'];
				$item1 = $item1->meta;
				$item2 = $item2->meta;
				$value1 = property_exists($item1, $property) ? $item1->$property : ($query['orderAsc'] ? 99999999 : -1);
				$value2 = property_exists($item2, $property) ? $item2->$property : ($query['orderAsc'] ? 99999999 : -1);
			
				return ($value1 >= $value2) ? $order : -$order;
		    });
		}
		
		return $filtered;
	}
};
	
?>