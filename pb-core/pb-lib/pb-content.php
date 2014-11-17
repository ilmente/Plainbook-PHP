<?php

/**
 * Plainbook meta field class
 * @package PB
 */
class PlainbookContent extends PlainbookBase {
	protected $raw;

	protected $__lazy_content;
	protected $__lazy_excerpt;
	
	public function __construct($config, $raw){
		parent::__construct($config);

		$this->raw = $raw;
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

    /**
     * Magic method that returns the parsed content.
     * @return string
     */
	public function __toString(){
        return $this->content;
    }
};
	
?>