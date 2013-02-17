<?php
namespace Score11\Models\Movie;
use Score11\Api;
use Score11\Models\Gravatar;

require_once LIBPATH . '/Score11/Api/Transformator.php';
require_once MODELSPATH . '/Gravatar.php';

class Comments extends Api\Transformator
{
	/**
	 * Gravatar Lib
	 * 
	 * @var Score11\Models\Gravatar
	 */
	private $_gravatar;
	
	private $_allowedTags = '<a><p><b><i><strong><ul><li><span><font><u>';
	
	protected function init()
	{
		$this->_gravatar = new Gravatar();
	}
	
	public function transform($params = array())
	{
		$config = \Zend_Registry::get('config');
		$comments = $this->getApi()->get($params);
		foreach ($comments as $key => $comment) {
			$comments[$key]['gravatar'] = $this->getGravatar($comment['gravatar']);
			$comments[$key]['text'] = $this->stripTags($comment['text']);
			$comments[$key]['text'] = nl2br($comments[$key]['text']);
			
			$timestamp = strtotime($comment['timestamp']);
			// Verwendete Datumsformate erstellen
			$comments[$key]['timestamp'] = strftime($config->dates->comments->time, $timestamp);
		}
		return $comments;
	}
	
	private function getGravatar($hash)
	{
		return $this->_gravatar->getLink($hash, Gravatar::SMALL);
	}
	
	private function stripTags($text)
	{
		// <3 Herzen zulassen
		$text = preg_replace('/<3/', '%3', $text);
		$text = strip_tags($text, $this->_allowedTags);
		$text = preg_replace('/%3/', '<3', $text);
		return $text;
	}
}