<?php
	
class PlainbookInfos extends PlainbookBase {
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
	
	public function __construct($file, $currentFile, $fileRawContent, $loadContent){
		$fileForUri = preg_replace('/((\/index\\'.PB_CONTENT_EXT.')$|(\\'.PB_CONTENT_EXT.')$)/i', '', $file).'/';
		$templateKeyword = PB_CONTENT_META_TEMPLATE;
		
		$this->path = str_replace(PB_CONTENT_DIR, '/', $fileForUri);
		$this->uri = ($this->path == '/') ? PB_BASE_URL : PB_BASE_URL.$this->path;
		$this->level = preg_match_all('/\//', $this->path) - 1;
		$this->meta = $this->getMeta($fileRawContent);
		$this->tags = $this->getTags($fileRawContent);
		$this->template = property_exists($this->meta, $templateKeyword) ? $this->meta->$templateKeyword : 'default';
		$this->isCurrent = ($file == $currentFile);
		$this->isFront = ($this->uri == PB_BASE_URL);
		
		if ($this->isCurrent || $this->isFront) $this->isParent = false;
		else $this->isParent = (preg_match_all('/^('.preg_quote($fileForUri, '/').')/', $currentFile) > 0);
		
		if ($loadContent){
			$this->raw = $fileRawContent;
			$this->content = $this->getContent($fileRawContent);
			$this->excerpt = $this->getExcerpt($this->content, PB_CONTENT_EXCERPT_LENGTH);
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