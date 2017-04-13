<?php

namespace Santik\RecruitzIoTwitter\Domain;

class TweetReachDecider
{
    //Could be better
    public function isOutdated(TweetReach $tweetReach): bool
    {
        $now = new \DateTime();
        $diff = $now->diff($tweetReach->dateTime());
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);
        return $hours > 2;
    }
}