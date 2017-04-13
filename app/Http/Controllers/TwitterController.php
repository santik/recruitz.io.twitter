<?php

namespace App\Http\Controllers;

use Santik\RecruitzIoTwitter\TwitterService;
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
        return $this->renderView();
    }

    public function getReach(Request $request)
    {
        $url = $request->get('url');

        $reach = $this->twitterService->getReach();

        return $this->renderView($url, $reach);
    }

    private function renderView($url = null, $reach = null)
    {
        return view('twitter.index', ['url' => $url, 'reach' => $reach]);
    }
}
