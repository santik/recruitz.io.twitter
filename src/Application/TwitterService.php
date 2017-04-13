<?php

namespace Santik\RecruitzIoTwitter\Application;

use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;
use Santik\RecruitzIoTwitter\Domain\TweetReachDecider;
use Santik\RecruitzIoTwitter\Domain\TwitterDataResolver;
use Santik\RecruitzIoTwitter\Domain\TwitterReachDatabaseAdapter;

class TwitterService
{
    private $twitterDataResolver;

    private $twitterReachDatabaseAdapter;

    private $tweetReachDecider;

    public function __construct(
        TwitterDataResolver $twitterDataResolver,
        TwitterReachDatabaseAdapter $twitterReachDatabaseAdapter,
        TweetReachDecider $tweetReachDecider
    )
    {
        $this->twitterDataResolver = $twitterDataResolver;
        $this->twitterReachDatabaseAdapter = $twitterReachDatabaseAdapter;
        $this->tweetReachDecider = $tweetReachDecider;
    }

    public function getReach(TweetId $tweetId): TweetReach
    {
        $reach = $this->getDatabaseReach($tweetId);

        if (!$this->isTweetReachOutdated($reach)) {
            return $reach;
        }

        $reach = $this->getExternalReach($tweetId);

        $this->saveDatabaseReach($reach);

        return $reach;
    }

    private function getExternalReach(TweetId $tweetId): TweetReach
    {
        return $this->twitterDataResolver->getTweetReach($tweetId);
    }

    private function getDatabaseReach(TweetId $tweetId):TweetReach
    {
        return $this->twitterReachDatabaseAdapter->getReach($tweetId);
    }

    private function isTweetReachOutdated(TweetReach $tweetReach):bool
    {
        return $this->tweetReachDecider->isOutdated($tweetReach);
    }

    private function saveDatabaseReach(TweetReach $tweetReach)
    {
        $this->twitterReachDatabaseAdapter->saveReach($tweetReach);
    }
}