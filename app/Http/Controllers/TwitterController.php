<?php

namespace App\Http\Controllers;

use Santik\RecruitzIoTwitter\Application\TwitterService;
use Santik\RecruitzIoTwitter\Domain\TweetId;
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

    public function index()
    {
        return $this->renderView();
    }

    public function getReach(Request $request)
    {
        $url = $this->getTweetUrlFromRequest($request);

        $reach = $this->twitterService->getReach(
            TweetId::extractFromTweetUrl($url)
        );

        return $this->renderView($url, $reach);
    }

    private function getTweetUrlFromRequest(Request $request)
    {
        return $request->get('url');
    }

    private function renderView($url = null, $reach = null)
    {
        return view('twitter.index', ['url' => $url, 'reach' => $reach]);
    }
}
