<?php
namespace Score11\Models\Movie;

require_once MODELSPATH . '/Movie/Image.php';

class ImageTest extends \PHPUnit_Framework_TestCase
{
	public function testCreation()
	{
		$image = new Image();
		self::assertInstanceOf('Score11\Models\Movie\Image', $image);
	}
}