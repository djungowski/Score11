<?php
namespace Score11\Models\Movie;

class Image
{
	public function getLink($movie)
	{
		if ($movie['hasimage'] == 'n') {
			return 'img/logo-movie.png';
		}
		return $movie['image'];
	}
}