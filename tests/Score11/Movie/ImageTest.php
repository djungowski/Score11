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
	
	public function testGetLinkReturnsDefaultImage()
	{
		$image = new Image();
		$expected = 'img/logo-movie.png';
		$movie = array(
			'hasimage' => 'n'
		);
		$actual = $image->getDefaultImageIfNecessary($movie);
		self::assertSame($expected, $actual);
	}
	
	public function testGetLinkReturnsMovieImage()
	{
		$image = new Image();
		$expected = 'http://www.score11.de/p/10/54510';
		$movie = array(
			'image' => $expected,
			'hasimage' => 'y'
		);
		$actual = $image->getDefaultImageIfNecessary($movie);
		self::assertSame($expected, $actual);
	}
}