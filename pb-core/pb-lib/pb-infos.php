<?php
	
/**
 * Plainbook informations-management class.
 * @package PB
 */
class PlainbookInfos extends PlainbookBase {	
	protected $content;
	protected $exists;
	protected $file;
	protected $url;
	protected $path;
	protected $level;
	protected $isCurrent;
	protected $isParent;
	protected $isFront;
	
	protected $__lazy_meta;
	protected $__lazy_template;
	
	/**
	 * Contructor.
	 * @param array(mixed) $config 
	 * @param string $file 
	 * @param string $currentFile 
	 * @param string $fileRawContent 
	 */
	public function __construct($config, $file, $currentFile, $fileRawContent){
		parent::__construct($config);
		
		$uri = preg_replace($config['pb.regexp.uri'], '', $file).'/';
		
		$this->content = new PlainbookContent($config, $fileRawContent);
		$this->exists = true;
		$this->file = $file;
		$this->path = str_replace($this->__config['pb.contents.dir'], '/', $uri);
		$this->url = ($this->path == '/') ? $this->__config['pb.site.url'] : $this->__config['pb.site.url'].$this->path;
		$this->level = substr_count($this->path, '/') - 1;
		$this->isCurrent = ($file == $currentFile);
		$this->isFront = ($this->url == $this->__config['pb.site.url']);
		
		if ($this->isCurrent || $this->isFront) $this->isParent = false;
		else $this->isParent = (strpos($currentFile, $uri) !== false);
	}
	
	protected function getMeta(){
		$meta = array();
		$hasMeta = (preg_match_all($this->__config['pb.regexp.meta.all'], $this->content->raw, $fields) > 0);
		
		if ($hasMeta){
			foreach ($fields[0] as $field){
				$key = preg_replace($this->__config['pb.regexp.meta.key'], '', $field);
				$value = trim(preg_replace($this->__config['pb.regexp.meta.value'], '', $field));
				$meta[$key] = new PlainbookMeta($this->__config, $value);
			}
		}

		return (object) $meta;
	}
	
	protected function getTemplate(){
		$defaultTemplate = 'default';
		$hasTemplate = preg_match($this->__config['pb.regexp.meta.template'], $this->content->raw, $template);
		$template = $hasTemplate ? trim(preg_replace($this->__config['pb.regexp.meta.value'], '', $template[0])) : $defaultTemplate;
		
		$templateFile = $this->__config['pb.theme.dir'].$template.'.php';
		if (file_exists($templateFile)) return $template;
		
		$templateFile = $this->__config['pb.theme.dir'].$defaultTemplate.'.php';
		if (file_exists($templateFile)) return $defaultTemplate;
		
		return null;
	}
}
	
?>