<?php
	
class PlainbookInfos extends PlainbookBase {
	protected $uri;
	protected $path;
	protected $level;
	protected $meta;
	protected $raw;
	protected $content;
	protected $excerpt;
	protected $isCurrent;
	protected $isFront;
	
	public function __construct($file, $currentFile, $fileRawContent, $loadContent){
		$fileForUri = preg_replace('/((\/index\\'.PB_CONTENT_EXT.')$|(\\'.PB_CONTENT_EXT.')$)/i', '', $file).'/';
		$templateKeyword = PB_CONTENT_META_TEMPLATE;
		
		$this->path = str_replace(PB_CONTENT_DIR, '/', $fileForUri);
		$this->uri = ($path == '/') ? PB_BASE_URL : PB_BASE_URL.$this->path;
		$this->level = preg_match_all('/\//m', $this->path) - 1;
		$this->meta = $this->getMeta($fileRawContent);
		$this->template = property_exists($this->meta, $templateKeyword) ? $this->meta->$templateKeyword : 'default';
		$this->isCurrent = ($file == $currentFile);
		$this->isFront = ($uri == PB_BASE_URL);
		
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