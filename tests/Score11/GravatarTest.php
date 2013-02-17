<?php
namespace Score11\Models;

require_once MODELSPATH . '/Gravatar.php';

class GravatarTest extends \PHPUnit_Framework_TestCase
{
	public function testGetLinkSmall()
	{
		$gravatar = new Gravatar();
		$expected = 'http://www.gravatar.com/avatar/7ba38f45686cc88431c1016449328ed2?r=x&s=30.jpg';
		$actual = $gravatar->getLink('7ba38f45686cc88431c1016449328ed2', Gravatar::SMALL);
		self::assertSame($expected, $actual);
	}
	
	public function testGetLinkLarge()
	{
		$gravatar = new Gravatar();
		$expected = 'http://www.gravatar.com/avatar/7ba38f45686cc88431c1016449328ed2?r=x&s=120.jpg';
		$actual = $gravatar->getLink('7ba38f45686cc88431c1016449328ed2', Gravatar::LARGE);
		self::assertSame($expected, $actual);
	}
}