<?php

use PHPUnit\Framework\TestCase;

class RandPhpTextTest extends TestCase
{
    public function testLoadTweets()
    {
        $tweets = include_once __DIR__ . '/../tweets.php';
        $this->assertIsArray($tweets);

        foreach ($tweets as $tweet) {
            $this->assertArrayHasKey('text', $tweet);
            $this->assertArrayHasKey('probability', $tweet);
            $this->assertIsInt($tweet['probability']);
            $this->assertTrue($tweet['probability'] >= 0);
        }
    }
}
