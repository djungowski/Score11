<?php
namespace Score11\Models;

class Gravatar
{
	const SMALL = 30;
	const LARGE = 120;
	
	private $_baseUrl = 'http://www.gravatar.com/avatar/%s?r=x&s=%d.jpg';
	
	public function getLink($hash, $size)
	{
		return sprintf($this->_baseUrl, $hash, $size);
	}
}