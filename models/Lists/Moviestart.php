<?php
namespace Score11\Models\Lists;

use Score11\Api;
use Score11\Models;

class Moviestart extends Models\OnTv
{
    // Genau gleiche Transformation wie bei den TV Tipps, von daher keine weitere Implementierung notwendig    
    
    public function getShowTitle($movie) {
        return sprintf('%s<br />%s', $movie['timestamp-time'], $movie['movietitle']);
    }

}
