<?php

namespace Santik\RecruitzIoTwitter\Infrastructure;

use Flintstone\Flintstone;
use Santik\RecruitzIoTwitter\Domain\TweetId;
use Santik\RecruitzIoTwitter\Domain\TweetReach;
use Santik\RecruitzIoTwitter\Domain\TwitterReachDatabaseAdapter;

class FileTwitterReachDatabaseAdapter implements TwitterReachDatabaseAdapter
{

    private $flintstone;

    public function __construct(Flintstone $flintstone)
    {
        $this->flintstone = $flintstone;
    }

    public function getReach(TweetId $tweetId):TweetReach
    {
        $data = $this->flintstone->get((string)$tweetId);
        if (!$data) {
            //hack can be improved
            //throw exception or something like this
            return new TweetReach($tweetId, 0, new \DateTime("-100 years"));
        }
        return new TweetReach($tweetId, $data['count'], new \DateTime($data['datetime']));
    }

    public function saveReach(TweetReach $reach)
    {
        $this->flintstone->set((string)$reach->tweetId(), $reach->asArray());
    }
}