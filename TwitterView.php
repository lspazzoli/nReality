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
	$hashtag=$_COOKIE['hash'];
	$num=$_COOKIE['num'];
	$url = 'https://api.twitter.com/1.1/search/tweets.json' ;
    $requestMethod = "GET";
    $getfield = '?q=#'.$hashtag.'&tweet_mode=extended&count='.$num;
	
	//Get Info From Twitter
	$twitter = new TwitterAPIExchange($settings);
	$string = json_decode($twitter->setGetfield($getfield)
		->buildOauth($url, $requestMethod)
		->performRequest(),$assoc = TRUE);
	$html="";	
	//Display
	foreach($string['statuses'] as $items) 
	{
		$datecreate = $items['created_at'];
		$id = $items['id'];
		$tweet = $items['full_text']; 
		$html .= '<a id="'.$id.'" href=""  class="list-group-item" data-toggle="modal" data-target="#myModal">
                    <h4 class="list-group-item-heading">'.$datecreate.'</h4>
                    <p class="list-group-item-text">'.$tweet.'</p>
                </a>';

	}
	//If No tweets found 
	if($html=="")
	{
		$html = '<a id="newSearch" onClick="searchHash()" class="list-group-item" >
                    <h4 class="list-group-item-heading">No Tweets Found</h4>
                    <p class="list-group-item-text">Click here to Search For One</p>
                </a>';
	}
		
	die($html);
	
?>