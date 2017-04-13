<?php

namespace Santik\RecruitzIoTwitter\Domain;

class TweetId
{
    private $tweetId;

    private function __construct(string $tweetId)
    {

        $this->tweetId = $tweetId;
    }

    public static function extractFromTweetUrl(string $url) : self
    {
        $urlParts = explode('/', $url);
        return new self(end($urlParts));
    }

    public function __toString() :string
    {
        return $this->tweetId;
    }
}
