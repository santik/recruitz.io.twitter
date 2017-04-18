<?php

namespace Santik\RecruitzIoTwitter\Domain;

class TweetReachDeciderTest extends \PHPUnit_Framework_TestCase
{
    public function testIsOutdated_ReachIsOlderThan2hours_ShouldReturnTrue()
    {
        $decider = new TweetReachDecider();

        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);
        $reachNumber = 100;
        $dateTime = new \DateTime("-3 hours");

        $reach = new TweetReach($tweetId, $reachNumber, $dateTime);

        $this->assertTrue($decider->isOutdated($reach));
    }

    public function testIsOutdated_ReachIsNotOlderThan2hours_ShouldReturnFalse()
    {
        $decider = new TweetReachDecider();

        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);
        $reachNumber = 100;
        $dateTime = new \DateTime();

        $reach = new TweetReach($tweetId, $reachNumber, $dateTime);

        $this->assertFalse($decider->isOutdated($reach));
    }
}
