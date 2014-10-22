<?php
	
class PlainbookInfos extends PlainbookBase {
	const META_REGEXP = '/^@\w+:.+/im';
	const META_KEY_REGEXP = '/(^@|:.+)/';
	const META_VALUE_REGEXP = '/^@\w+:/i';
	
	const TAGS_REGEXP = '/\s+#(\w+|\w+#\w+|\w+#)\s/im';
	
	protected $raw;
	protected $file;
	protected $url;
	protected $path;
	protected $level;
	protected $isCurrent;
	protected $isParent;
	protected $isFront;
	
	protected $__config;
	
	protected $__lazy_meta;
	protected $__lazy_tags;
	protected $__lazy_template;
	protected $__lazy_content;
	protected $__lazy_excerpt;
	
	public function __construct($config, $file, $currentFile, $fileRawContent){
		$this->__config = $config;
		
		$ext = $this->__config['pb.contents.extension'];
		$uri = preg_replace('/((\/index\\'.$ext.')$|(\\'.$ext.')$)/i', '', $file).'/';
		
		$this->raw = $fileRawContent;
		$this->file = $file;
		$this->path = str_replace($this->__config['pb.contents.dir'], '/', $uri);
		$this->url = ($this->path == '/') ? $this->__config['pb.site.url'] : $this->__config['pb.site.url'].$this->path;
		$this->level = preg_match_all('/\//', $this->path) - 1;
		$this->isCurrent = ($file == $currentFile);
		$this->isFront = ($this->url == $this->__config['pb.site.url']);
		
		if ($this->isCurrent || $this->isFront) $this->isParent = false;
		else $this->isParent = (preg_match_all('/^('.preg_quote($uri, '/').')/', $currentFile) > 0);
	}
	
	protected function getMeta(){
		$meta = array();
		$hasMeta = (preg_match_all(self::META_REGEXP, $this->raw, $fields) > 0);
		
		if ($hasMeta){
			foreach ($fields[0] as $field){
				$key = preg_replace(self::META_KEY_REGEXP, '', $field);
				$value = trim(preg_replace(self::META_VALUE_REGEXP, '', $field));
				$meta[$key] = $value;
			}
		}

		return (object) $meta;
	}
	
	protected function getTags(){
		$tags = array();
		$hasTags = (preg_match_all(self::TAGS_REGEXP, $this->raw, $tagsMatch) > 0);
		
		if ($hasTags){
			foreach ($tagsMatch[0] as $tag){
				$tag = preg_replace('/^#/', '', trim($tag));
				if (!in_array($tag, $tags)) array_push($tags, $tag);
			}
		}
		
		return $tags;
	}
	
	protected function getTemplate(){
		$defaultTemplate = 'default';
		$hasTemplate = preg_match('/^@'.preg_quote(trim($this->__config['pb.keywords.template']), '/').':.+/im', $this->raw, $template);
		$template = $hasTemplate ? trim(preg_replace(self::META_VALUE_REGEXP, '', $template[0])) : $defaultTemplate;
		
		$templateFile = $this->__config['pb.theme.dir'].$template.'.php';
		if (file_exists($templateFile)) return $template;
		
		$templateFile = $this->__config['pb.theme.dir'].$defaultTemplate.'.php';
		if (file_exists($templateFile)) return $defaultTemplate;
		
		return null;
	}
	
	protected function getContent(){
		$markdown = trim(preg_replace(self::META_REGEXP, '', $this->raw));
		$parser = new ParsedownExtra();
		return $parser->text($markdown);
	}
	
	protected function getExcerpt(){
		$words = explode(' ', $this->content);
		$excerpt = trim(implode(' ', array_splice($words, 0, $this->__config['pb.contents.excerpt_lenght'])));
		if (count($words) > $length) $excerpt .= '&hellip;';
		return $excerpt;
	}
}
	
?>