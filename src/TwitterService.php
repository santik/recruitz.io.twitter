<?php

namespace Santik\RecruitzIoTwitter;

use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;
use Santik\RecruitzIoTwitter\Domain\TweetReachDecider;
use Santik\RecruitzIoTwitter\Infrastructure\TwitterDataResolver;
use Santik\RecruitzIoTwitter\Infrastructure\TwitterReachDatabaseAdapter;

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
        $databaseReach = $this->getDatabaseReach($tweetId);

        if (!$this->isTweetReachOutdated($databaseReach)) {
            return $databaseReach;
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

    private function isTweetReachOutdated(TweetReach $reach):bool
    {
        return $this->tweetReachDecider->isOutdated($reach);
    }

    private function saveDatabaseReach(TweetReach $reach)
    {
        $this->twitterReachDatabaseAdapter->saveReach($reach);
    }
}