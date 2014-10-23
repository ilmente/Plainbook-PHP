<?php
	
class PlainbookInfos extends PlainbookBase {	
	protected $exists;
	protected $raw;
	protected $file;
	protected $url;
	protected $path;
	protected $level;
	protected $isCurrent;
	protected $isParent;
	protected $isFront;
	
	protected $__lazy_meta;
	protected $__lazy_tags;
	protected $__lazy_template;
	protected $__lazy_content;
	protected $__lazy_excerpt;
	
	public function __construct($config, $file, $currentFile, $fileRawContent){
		parent::__construct($config);
		
		$uri = preg_replace($config['pb.regexp.uri'], '', $file).'/';
		
		$this->exists = true;
		$this->raw = $fileRawContent;
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
		$hasMeta = (preg_match_all($this->__config['pb.regexp.meta.all'], $this->raw, $fields) > 0);
		
		if ($hasMeta){
			foreach ($fields[0] as $field){
				$key = preg_replace($this->__config['pb.regexp.meta.key'], '', $field);
				$value = trim(preg_replace($this->__config['pb.regexp.meta.value'], '', $field));
				$meta[$key] = $value;
			}
		}

		return (object) $meta;
	}
	
	protected function getTags(){
		$tags = array();
		$hasTags = preg_match($this->__config['pb.regexp.meta.tags'], $this->raw, $rawTags);
		$rawTags = $hasTags ? explode(',', trim(preg_replace($this->__config['pb.regexp.meta.value'], '', $rawTags[0]))) : array();
		
		foreach ($rawTags as $rawTag){
			$tag = str_replace(' ', '', $rawTag);
			if (!in_array($tag, $tags)) array_push($tags, $tag);
		}
		
		return $tags;
	}
	
	protected function getTemplate(){
		$defaultTemplate = 'default';
		$hasTemplate = preg_match($this->__config['pb.regexp.meta.template'], $this->raw, $template);
		$template = $hasTemplate ? trim(preg_replace($this->__config['pb.regexp.meta.value'], '', $template[0])) : $defaultTemplate;
		
		$templateFile = $this->__config['pb.theme.dir'].$template.'.php';
		if (file_exists($templateFile)) return $template;
		
		$templateFile = $this->__config['pb.theme.dir'].$defaultTemplate.'.php';
		if (file_exists($templateFile)) return $defaultTemplate;
		
		return null;
	}
	
	protected function getMarkdown(){
		return trim(preg_replace($this->__config['pb.regexp.meta.all'], '', $this->raw));
	}
	
	protected function getContent(){
		$markdown = $this->getMarkdown();
		$parser = new ParsedownExtra();
		return $parser->text($markdown);
	}
	
	protected function getExcerpt(){
		$text = strip_tags($this->content);
		$words = explode(' ', $text);
		$excerpt = trim(implode(' ', array_splice($words, 0, $this->__config['pb.contents.excerpt_length'])));
		if (count($words) > $length) $excerpt .= '&hellip;';
		return $excerpt;
	}
}
	
?>