<?php
	//Connect to Api
	ini_set('display_errors', true);
    require_once('TwitterAPIExchange.php');
	
	//Set up authentication
	$settings = array(
		'oauth_access_token' => "151968297-nfOJ6g5qSssgHIW55jON5zQsnLvDTk0U3U3ujTZ9",
		'oauth_access_token_secret' => "wfxRl4yaQ8HeR5udYq513R5S2QZxhfoWTWzVRDzrEfIrX",
		'consumer_key' => "TsrX7P0XCsJnwQQUQ5D0Q7RVF",
		'consumer_secret' => "St9JIOlfk2GqQ2ILiQo6BwcpTuQq45g3ZJ89XXVje9YhCNq2QF"
		);
	
	//Set up request
	$hashtag="test";
	$url = 'https://api.twitter.com/1.1/search/tweets.json' ;
    $requestMethod = "GET";
    $getfield = '?q=#'.$hashtag.'&tweet_mode=extended';
	
	//Get Info From Twitter
	$twitter = new TwitterAPIExchange($settings);
	$string = json_decode($twitter->setGetfield($getfield)
		->buildOauth($url, $requestMethod)
		->performRequest(),$assoc = TRUE);
		
	//Display
	foreach($string['statuses'] as $items) 
	{
		$datecreate = $items['created_at'];
		$id = $items['id'];
		$twit = $items['full_text'];

		echo"<br/>";
		//echo "ID: $id<br />";
		echo "Created: $datecreate<br />";
		echo "Tweet: $twit<br />";  

		}
	
?>