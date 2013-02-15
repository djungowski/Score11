<?php
namespace Score11\Models\Rating;

use Score11\Api;
use Score11\Models;

class Latest extends Models\OnTv
{
    public function getShowTitle($movie) {
//         return sprintf('%s', $movie['movietitle']);
		return '';
    }
}
