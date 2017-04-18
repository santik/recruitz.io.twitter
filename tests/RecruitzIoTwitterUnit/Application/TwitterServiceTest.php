<?php

namespace Santik\RecruitzIoTwitter\Application;

use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;
use Santik\RecruitzIoTwitter\Domain\TweetReachDecider;
use Santik\RecruitzIoTwitter\Domain\TwitterDataResolver;
use Santik\RecruitzIoTwitter\Domain\TwitterReachDatabaseAdapter;

class TwitterServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testGetReach_FoundDatabaseNotOutdatedReach_shouldReturnThisReach()
    {
        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);
        $expectedReach = new TweetReach($tweetId, 100, new \DateTime());

        $resolver = $this->prophesize(TwitterDataResolver::class);

        $database = $this->prophesize(TwitterReachDatabaseAdapter::class);
        $database->getReach($tweetId)->willReturn($expectedReach);

        $decider = new TweetReachDecider();

        $service = new TwitterService($resolver->reveal(), $database->reveal(), $decider);


        $reach = $service->getReach($tweetId);

        $this->assertEquals($expectedReach, $reach);
    }

    public function testGetReach_NoDatabaseReach_shouldReturnReachFromOutsideAndSaved()
    {
        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);
        $expectedReach = new TweetReach($tweetId, 100, new \DateTime());

        $outdatedReach = new TweetReach($tweetId, 0, new \DateTime("-100 years"));


        $resolver = $this->prophesize(TwitterDataResolver::class);
        $resolver->getTweetReach($tweetId)->willReturn($expectedReach);

        $database = $this->prophesize(TwitterReachDatabaseAdapter::class);
        $database->getReach($tweetId)->willReturn($outdatedReach);
        $database->saveReach($expectedReach)->shouldBeCalled();

        $decider = new TweetReachDecider();

        $service = new TwitterService($resolver->reveal(), $database->reveal(), $decider);


        $reach = $service->getReach($tweetId);

        $this->assertEquals($expectedReach, $reach);

    }

    public function testGetReach_NotOutdatedDatabaseReach_shouldReturnReachFromOutside()
    {
        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);
        $expectedReach = new TweetReach($tweetId, 100, new \DateTime());

        $resolver = $this->prophesize(TwitterDataResolver::class);
        $resolver->getTweetReach($tweetId)->shouldNotBeCalled();

        $database = $this->prophesize(TwitterReachDatabaseAdapter::class);
        $database->getReach($tweetId)->willReturn($expectedReach);
        $database->saveReach($expectedReach)->shouldNotBeCalled();

        $decider = new TweetReachDecider();

        $service = new TwitterService($resolver->reveal(), $database->reveal(), $decider);


        $reach = $service->getReach($tweetId);

        $this->assertEquals($expectedReach, $reach);

    }
}
