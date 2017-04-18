<?php

namespace Santik\RecruitzIoTwitter\Infrastructure;

use Flintstone\Flintstone;
use Prophecy\Argument;
use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;

class FileTwitterReachDatabaseAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetReach_NoDatabaseData_ShouldReturnFakeReach()
    {
        $flinstone = $this->prophesize(Flintstone::class);
        $fileAdapter = new FileTwitterReachDatabaseAdapter($flinstone->reveal());

        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);

        $outdatedReach = new TweetReach($tweetId, 0, new \DateTime("-100 years"));

        $reach = $fileAdapter->getReach($tweetId);

        $this->assertEquals($outdatedReach, $reach);
    }

    public function testGetReach_DatabaseDataExists_ShouldReturnReach()
    {
        $url = 'https://twitter.com/DalaiLamaQutes/status/819993752370548736';
        $tweetId = TweetId::extractFromTweetUrl($url);

        $count = 2;

        $flinstone = $this->prophesize(Flintstone::class);
        $data = [
            'count' => $count,
            'datetime' => 'now'
        ];
        $flinstone->get(Argument::any())->willReturn($data);
        $fileAdapter = new FileTwitterReachDatabaseAdapter($flinstone->reveal());


        $expectedReach = new TweetReach($tweetId, $count, new \DateTime());

        $reach = $fileAdapter->getReach($tweetId);

        $this->assertEquals($expectedReach->reach(), $reach->reach());
        $this->assertEquals($expectedReach->tweetId(), $reach->tweetId());
    }
}
