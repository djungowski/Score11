<?php
namespace Score11\Models\Movie;

class Image
{
	const DEFAULTLOGO = 'img/logo-movie.png'; 
	
	public function getLink($movie)
	{
		if ($movie['hasimage'] == 'n') {
			return self::DEFAULTLOGO;
		}
		return $movie['image'];
	}
}