<?php

namespace Santik\RecruitzIoTwitter\Domain;

class TweetReach
{
    private $tweetId;

    private $reachNumber;

    private $dateTime;

    public function __construct(TweetId $tweetId, int $reachNumber, \DateTime $dateTime)
    {
        $this->tweetId = $tweetId;
        $this->reachNumber = $reachNumber;
        $this->dateTime = $dateTime;
    }

    public function reach(): int
    {
        return $this->reachNumber;
    }

    public function tweetId(): TweetId
    {
        return $this->tweetId;
    }

    public function dateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function asArray()
    {
        return [
            'tweetId' => (string)$this->tweetId(),
            'count' => $this->reach(),
            'datetime' => $this->dateTime()->format("Y-m-d H:i:s")
        ];
    }
}