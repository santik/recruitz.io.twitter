<?php

namespace Santik\RecruitzIoTwitter\Infrastructure;

use Abraham\TwitterOAuth\TwitterOAuth;
use Prophecy\Argument;
use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;
use Santik\RecruitzIoTwitter\Domain\TwitterDataResolver;

class ApiTwitterDataResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct_ShouldReturnTwitterDataResolver()
    {
        $twitterOAuth = $this->prophesize(TwitterOAuth::class);
        $resolver = new ApiTwitterDataResolver($twitterOAuth->reveal());

        $this->assertInstanceOf(TwitterDataResolver::class, $resolver);
    }

    public function testGetTweetReach_ShouldReturnExpectedReach()
    {
        $twitterOAuth = $this->prophesize(TwitterOAuth::class);

        $item = new \stdClass();
        $user = new \stdClass();
        $user->followers_count = 1;
        $item->user = $user;
        $apiData = [
            $item,
            $item,
            $item
        ];

        $twitterOAuth->get(Argument::any())->willReturn($apiData);

        $resolver = new ApiTwitterDataResolver($twitterOAuth->reveal());

        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);

        $expectedReach = new TweetReach($tweetId, 3, new \DateTime());

        $reach = $resolver->getTweetReach($tweetId);

        //hacky but datetime doesn't have interface . Can be used something like clock lib
        $this->assertEquals($expectedReach->reach(), $reach->reach());
    }
}
