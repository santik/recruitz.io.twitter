<?php

namespace Santik\RecruitzIoTwitter\Domain;

class TweetIdTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromUrl_shouldReturnTweetId()
    {
        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);

        $this->assertInstanceOf(TweetId::class, $tweetId);
    }
}
