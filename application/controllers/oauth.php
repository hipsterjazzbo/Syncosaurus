<?php

class Oauth extends CI_Controller {

	function index()
    {        
    	
    }
    
    function twitter()
    {
    	$consumer_key = '7NlREhBq7tMl4kMevl5w';
		$consumer_key_secret = 'NBzI0KCWhkeKWMYTvnM8YLkBvABnhu9lI3qSLSlwG8';		
		$tokens['access_token'] = NULL;
		$tokens['access_token_secret'] = NULL;

		// GET THE ACCESS TOKENS		
		$user = $this->mongo->db->users->findOne(array('username' => 'cfidecaro'));
		$oauth_tokens = $user['services']['twitter']['oauth_tokens'];
		
		if ( $oauth_tokens !== FALSE ) $tokens = $oauth_tokens;

		$this->load->library('twitter');

		$auth = $this->twitter->oauth($consumer_key, $consumer_key_secret, $tokens['access_token'], $tokens['access_token_secret']);

		if ( isset($auth['access_token']) && isset($auth['access_token_secret']) )
		{
			// SAVE THE ACCESS TOKENS		
			$this->mongo->db->users->update(array('username' => 'cfidecaro'), array('$set' => array('services.twitter.oauth_tokens' => $auth)));

			if ( isset($_GET['oauth_token']) )
			{
				$uri = $_SERVER['REQUEST_URI'];
				$parts = explode('?', $uri);

				// Now we redirect the user since we've saved their stuff!

				header('Location: '.$parts[0]);
				return;
			}
		}
		
		echo 'Authed on twitter';
    }
}

