<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

function getRandomLine($texts)
{
    $probabilityArray = [];

    foreach ($texts as $key => $tweet) {
        $lengthFilledProbability = array_fill(0, $tweet['probability'], $key);
        $probabilityArray = array_merge($probabilityArray, $lengthFilledProbability);
    }

    $length = count($probabilityArray);
    $randomKey = random_int(0, $length-1);
    $tweetKey = $probabilityArray[$randomKey];

    return $texts[$tweetKey]['text'];
}

$CONSUMER_KEY = getenv('CONSUMER_KEY');
$CONSUMER_SECRET = getenv('CONSUMER_SECRET');
$ACCESS_TOKEN = getenv('ACCESS_TOKEN');
$ACCESS_TOKEN_SECRET = getenv('ACCESS_TOKEN_SECRET');

$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);
$tweets = include_once __DIR__ . '/tweets.php';

return function ($event) use ($connection, $tweets)
{
    $result = [];
    $randomLine = getRandomLine($tweets);
    $result[] = $randomLine;

    $statues = $connection->post("statuses/update", ["status" => $randomLine]);

    $result[] = $statues;
    return json_encode($result, JSON_PRETTY_PRINT);
};
