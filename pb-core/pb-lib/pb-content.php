<?php

/**
 * Plainbook meta field class
 * @package PB
 */
class PlainbookContent extends PlainbookBase {
	protected $raw;

	protected $__lazy_markdown;
	protected $__lazy_content;
	
	public function __construct($config, $raw){
		parent::__construct($config);

		$this->raw = $raw;
	}

	protected function getMarkdown(){
		return trim(preg_replace($this->__config['pb.regexp.meta.all'], '', $this->raw));
	}
	
	protected function getContent(){
		$parser = new ParsedownExtra();
		return $parser->text($this->markdown);
	}
	
	public function getExcerpt($length = 0){
		$length = ($length === 0) ? $this->__config['pb.contents.excerpt_length'] : $length;
		$text = strip_tags($this->content);
		$words = explode(' ', $text);
		$excerpt = trim(implode(' ', array_splice($words, 0, $length)));
		if (count($words) > $length) $excerpt .= '&hellip;';
		return $excerpt;
	}

    /**
     * Magic method that returns the parsed content.
     * @return string
     */
	public function __toString(){
        return $this->content;
    }
};
	
?>