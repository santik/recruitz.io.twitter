<?php

namespace Santik\RecruitzIoTwitter\Domain;


class TweetReachTest extends \PHPUnit_Framework_TestCase
{
    public function testAsArray_ShouldReturnObjectAsArray()
    {
        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);
        $reachNumber = 100;
        $dateTime = new \DateTime();

        $reach = new TweetReach($tweetId, $reachNumber, $dateTime);

        $expectedArray = [
            'tweetId' => '819993752370548736',
            'count' => 100,
            'datetime' => $dateTime->format('Y-m-d H:i:s'),

        ];

        $this->assertEquals($expectedArray, $reach->asArray());
    }
}
