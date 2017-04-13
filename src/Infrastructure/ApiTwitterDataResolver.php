<?php

namespace Santik\RecruitzIoTwitter\Infrastructure;

use Abraham\TwitterOAuth\TwitterOAuth;
use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;

class ApiTwitterDataResolver implements  TwitterDataResolver
{

    private $twitterOAuth;

    public function __construct(TwitterOAuth $twitterOAuth)
    {
        $this->twitterOAuth = $twitterOAuth;
    }

    public function getTweetReach(TweetId $tweetId):TweetReach
    {
        $data = $this->twitterOAuth->get('statuses/retweets/' . $tweetId);
        $count = 0;

        foreach ($data as $retweet) {
            $count += $retweet->user->followers_count;
        }

        return new TweetReach($tweetId, $count, new \DateTime());
    }
}