<?php

namespace Santik\RecruitzIoTwitter\Infrastructure;

use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;

interface TwitterReachDatabaseAdapter
{
    public function getReach(TweetId $tweetId):TweetReach;

    public function saveReach(TweetReach $reach);
}