<?php
	
class PlainbookInfos extends PlainbookBase {
	protected $file;
	protected $uri;
	protected $path;
	protected $level;
	protected $meta;
	protected $tags;
	protected $raw;
	protected $content;
	protected $excerpt;
	protected $isCurrent;
	protected $isParent;
	protected $isFront;
	
	public function __construct($config, $file, $currentFile, $fileRawContent, $loadContent){
		$this->__config = $config;
		
		$ext = $this->__config['pb.contents.extension'];
		$fileForUri = preg_replace('/((\/index\\'.$ext.')$|(\\'.$ext.')$)/i', '', $file).'/';
		$templateKeyword = $this->__config['pb.contents.keywords.template'];
		
		$this->file = $file;
		$this->path = str_replace($this->__config['pb.contents.dir'], '/', $fileForUri);
		$this->uri = ($this->path == '/') ? $this->__config['pb.site.url'] : $this->__config['pb.site.url'].$this->path;
		$this->level = preg_match_all('/\//', $this->path) - 1;
		$this->meta = $this->getMeta($fileRawContent);
		$this->tags = $this->getTags($fileRawContent);
		$this->template = $this->getTemplate($this->meta);
		$this->isCurrent = ($file == $currentFile);
		$this->isFront = ($this->uri == $this->__config['pb.site.url']);
		
		if ($this->isCurrent || $this->isFront) $this->isParent = false;
		else $this->isParent = (preg_match_all('/^('.preg_quote($fileForUri, '/').')/', $currentFile) > 0);
		
		if ($loadContent){
			$this->raw = $fileRawContent;
			$this->content = $this->getContent($fileRawContent);
			$this->excerpt = $this->getExcerpt($this->content, $this->__config['pb.contents.excerpt_length']);
		} else {
			$this->raw = '';
			$this->content = '';
			$this->excerpt = '';
		}
	}
	
	protected function getMeta($rawContent){
		$meta = array();
		preg_match_all('/^@\w+:.+/im', $rawContent, $fields);
		
		if (isset($fields)){
			foreach ($fields[0] as $field){
				$key = preg_replace('/(^@|:.+)/', '', $field);
				$value = trim(preg_replace('/^@\w+:/i', '', $field));
				$meta[$key] = $value;
			}
		}

		return (object) $meta;
	}
	
	protected function getTags($rawContent){
		$tags = array();
		
		if (preg_match_all('/\s+#(\w+|\w+#\w+|\w+#)\s/im', $rawContent, $tagsMatch) > 0){
			foreach ($tagsMatch[0] as $tag){
				$tag = preg_replace('/^#/', '', trim($tag));
				if (!in_array($tag, $tags)) array_push($tags, $tag);
			}
		}
		
		return $tags;
	}
	
	protected function getTemplate($meta){
		$defaultTemplate = 'default';
		$template = property_exists($meta, $templateKeyword) ? $meta->$templateKeyword : $defaultTemplate;
		
		$templateFile = $this->__config['pb.theme.dir'].$template.'.php';
		if (file_exists($templateFile)) return $template;
		
		$templateFile = $this->__config['pb.theme.dir'].$defaultTemplate.'.php';
		if (file_exists($templateFile)) return $defaultTemplate;
		
		return null;
	}
	
	protected function getContent($rawContent){
		$markdown = trim(preg_replace('/^@\w+:.+/im', '', $rawContent));
		$parser = new ParsedownExtra();
		return $parser->text($markdown);
	}
	
	protected function getExcerpt($text, $length){
		$words = explode(' ', $text);
		$excerpt = trim(implode(' ', array_splice($words, 0, $length)));
		if (count($words) > $length) $excerpt .= '&hellip;';
		return $excerpt;
	}
}
	
?>