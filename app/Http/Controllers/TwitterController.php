<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;

class TwitterController extends Controller
{
    /**
     * @var TwitterService
     */
    private $twitterService;

    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function index(Request $request)
    {
        return view('twitter.index');
    }

    public function getReach(Request $request)
    {
        $url = $request->get('url');

        $reach = $this->twitterService->getReach();

        return view('twitter.index', ['url' => $url]);
    }
}
