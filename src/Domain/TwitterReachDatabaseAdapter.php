<?php

namespace Santik\RecruitzIoTwitter\Domain;

interface TwitterReachDatabaseAdapter
{
    public function getReach(TweetId $tweetId):TweetReach;

    public function saveReach(TweetReach $reach);
}