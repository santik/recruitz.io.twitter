<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Illuminate\Routing\Controller as BaseController;

class TwitterController extends BaseController
{
    public function index(Request $request)
    {
        return view('twitter.index');
    }

    public function getReach()
    {

    }
}
