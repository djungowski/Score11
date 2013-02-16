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
	
	public function testGetDefaultImageIfNecessaryTrue()
	{
		$image = new Image();
		$expected = 'img/logo-movie.png';
		$movie = array(
			'hasimage' => 'n'
		);
		$actual = $image->getDefaultImageIfNecessary($movie['hasimage']);
		self::assertSame($expected, $actual);
	}
}