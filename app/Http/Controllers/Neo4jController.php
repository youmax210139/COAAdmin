<?php

namespace App\Http\Controllers;

use App;

class Neo4jController extends Controller
{
    public function view($image)
    {
        $images = ['441748', '441751', '441752'];

        foreach ($images as $i => $v) {
            if ($image == $v) {
                $next = ($i == 3) ? null : $images[$i + 1];
                $previous = ($i == 0) ? null : $images[$i - 1];
            }
        }
        return view('neo4j', compact('image', 'next', 'previous'));
    }
}
