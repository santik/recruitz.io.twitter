<?php

namespace Santik\RecruitzIoTwitter\Infrastructure;

use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;

interface TwitterDataResolver
{
    public function getTweetReach(TweetId $tweetId):TweetReach;
}