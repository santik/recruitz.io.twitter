<?php

namespace Santik\RecruitzIoTwitter\Domain;

interface TwitterDataResolver
{
    public function getTweetReach(TweetId $tweetId):TweetReach;
}