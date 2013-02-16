<?php
namespace Score11\Models;
use Score11\Api;

require_once LIBPATH . '/Score11/Api/Transformator.php';

class Movie extends Api\Transformator
{	
	public function transform($params = array())
	{
		$movie = $this->getApi()->get($params);
		$movie = $this->createShowTitles($movie);
		$movie['image'] = $this->getImageLink($movie);
		$movie['ori-title'] = $this->getOriTitle($movie);
		return $movie;
	}
	
	private function createShowTitles($movie)
	{
		foreach($movie['titles'] as $key => $title) {
			$movie['titles'][$key]['show-title'] =
				sprintf('%s (%s %d)', $title['title'], strtoupper($title['version']), $title['year']);
		}
		
		return $movie;
	}
	
	private function getOriTitle($movie)
	{
		foreach($movie['titles'] as $title) {
			if ($title['ID'] == $movie['ori']) {
				return $title;
			}
		}
		return $movie['titles'][0];
	}
}