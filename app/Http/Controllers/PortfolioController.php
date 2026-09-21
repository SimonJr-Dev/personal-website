<?php

namespace App\Http\Controllers;

use App\Support\SiteContent;

class PortfolioController extends Controller
{
    public function show()
    {
        return view('home', [
            'site' => SiteContent::all(),
        ]);
    }
}
