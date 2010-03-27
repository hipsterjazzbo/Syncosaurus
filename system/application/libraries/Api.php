<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api {
    
    private $CI;
    
    function Api()
    {
    	$this->CI =& get_instance();
    }
    
    function getType($service, $item)
    {
    	switch($service)
    	{
    		case 'twitter':
    			return 'status';
    			break;
    			
    		case 'tumblr':
    			switch($item['type'])
    			{
    				case 'regular':
    					return 'post';
    					break;
    				
    				case 'photo':
    					return 'image';
    					break;
    					
    				case 'quote':
    					return 'post';
    					break;
    					
    				case 'link':
    					return 'link';
    					break;
    					
    				case 'conversation':
    					return 'post';
    					break;
    					
    				case 'video':
    					return 'video';
    					break;
    					
    				case 'audio':
    					return 'audio';
    					break;
    			}
    			break;
    			
    		case 'posterous':
    			// Probably a switch on type - must find out what API read returns
    			break;
    			
    		case 'facebook':
    			// Same as above
    			break;
    			
    		case 'flickr':
    			return 'image';
    			break;
    			
    		case 'youtube':
    			return 'video';
    			break;
    	}
    }
    
    
    
    function twitter($method, $credentials, $tweet = null)
    {
    	//$this->CI->load->library('tumblr');
    	$posts = array();
    	
    	switch($method)
    	{
    		case 'read':
    			//$result = $this->CI->tumblr->read('devthing', $credentials['email'], $credentials['password']);
    			return $posts;
    			break;
    		
    		case 'write':
    			//$CI->tumblr->write();
    			return true;
    			break;
    	}
    }
    
    function tumblr($method, $credentials, $post = null)
	    {    	
	    	$this->CI->load->library('tumblr');
	    	$posts = array();
	    	
	    	switch($method)
	    	{
	    		case 'read':
	    			$result = $this->CI->tumblr->read('devthing', $credentials['email'], $credentials['password']);
	    			$i = 0;
	    			
	    			foreach($result->posts->post as $post)
	    			{
	    				$posts[$i]['type']      = (string) $post['type'];
	    				$posts[$i]['timestamp'] = (string) $post['unix-timestamp'];
	    				$posts[$i]['url']       = (string) $post['url'];
	    				
	    				foreach($post->children() as $key => $value)
	    				{
	    					$posts[$i][$key] = (string) $value;
	    				}
	    				
	    				$i++;
	    			}
	    			
					return $posts;
	    			break;
	    		
	    		case 'write':
	    			//$CI->tumblr->write();
	    			return true;
	    			break;
	    	}
	    }
    
    function posterous($method, $credentials, $post = null)
    {
    	//$this->CI->load->library('tumblr');
    	$posts = array();
    	
    	switch($method)
    	{
    		case 'read':
    			//$result = $this->CI->tumblr->read('devthing', $credentials['email'], $credentials['password']);
				return $posts;
    			break;
    		
    		case 'write':
    			//$CI->tumblr->write();
    			return true;
    			break;
    	}
    }
    
    function facebook($method, $credentials, $item = null)
    {
    	//$this->CI->load->library('tumblr');
    	$posts = array();
    	
    	switch($method)
    	{
    		case 'read':
    			//$result = $this->CI->tumblr->read('devthing', $credentials['email'], $credentials['password']);
    			return $posts;
    			break;
    		
    		case 'write':
    			//$CI->tumblr->write();
    			return true;
    			break;
    	}
    }
    
    function friendfeed($method, $credentials, $post = null)
    {
    	//$this->CI->load->library('tumblr');
    	$posts = array();
    	
    	switch($method)
    	{
    		case 'read':
    			//$result = $this->CI->tumblr->read('devthing', $credentials['email'], $credentials['password']);
    			return $posts;
    			break;
    		
    		case 'write':
    			//$CI->tumblr->write();
    			return true;
    			break;
    	}
    }
    
    function flickr($method, $credentials, $image = null)
    {
    	//$this->CI->load->library('tumblr');
    	$posts = array();
    	
    	switch($method)
    	{
    		case 'read':
    			//$result = $this->CI->tumblr->read('devthing', $credentials['email'], $credentials['password']);
    			return $posts;
    			break;
    		
    		case 'write':
    			//$CI->tumblr->write();
    			return true;
    			break;
    	}
    }
    
    function instapaper($method, $credentials, $item = null)
    {
    	$this->CI->load->library('instapaper');
    	$url = $item['url'];
    	
    	switch($method)
    	{
    		case 'auth':
    			$status = $this->CI->instapaper->auth($credentials['username'], $credentials['password']);
    			return $status;
    			break;
    		
    		case 'write':
    			$status = $this->CI->instapaper->add($credentials['username'], $credentials['password'], $url);
    			return true;
    			break;
    	}
    }
    
    function youtube($method, $credentials, $video = null)
    {
    	//$this->CI->load->library('tumblr');
    	$posts = array();
    	
    	switch($method)
    	{
    		case 'read':
    			//$result = $this->CI->tumblr->read('devthing', $credentials['email'], $credentials['password']);
    			return $posts;
    			break;
    		
    		case 'write':
    			//$CI->tumblr->write();
    			return true;
    			break;
    	}
    }
    
    function twitter_thing()
    {
		// Fill in your twitter oauth client keys here	
		$consumer_key = '7NlREhBq7tMl4kMevl5w';
		$consumer_key_secret = 'NBzI0KCWhkeKWMYTvnM8YLkBvABnhu9lI3qSLSlwG8';
		
		$tokens['access_token'] = NULL;
		$tokens['access_token_secret'] = NULL;

		// GET THE ACCESS TOKENS		
		$oauth_tokens = $this->mongo->db->users->findOne(array('username' => 'cfidecaro'), array('access_token', 'access_token_secret'));
		var_dump($oauth_tokens);
		exit();

		if($oauth_tokens !== FALSE)
		{
			$tokens = $oauth_tokens;
		}

		$this->load->library('twitter');

		$auth = $this->twitter->oauth($consumer_key, $consumer_key_secret, $tokens['access_token'], $tokens['access_token_secret']);

			if(isset($auth['access_token']) && isset($auth['access_token_secret']))
		{
			// SAVE THE ACCESS TOKENS		
			$this->mongo->db->users->update(array('username' => 'cfidecaro'), $auth);

			if(isset($_GET['oauth_token']))
			{
				$uri = $_SERVER['REQUEST_URI'];
				$parts = explode('?', $uri);

				// Now we redirect the user since we've saved their stuff!
				header('Location: '.$parts[0]);
				return;
			}
		}

		// This is where  you can call a method.

		$this->twitter->call('statuses/update', array('status' => 'I\'m hungry.')); 
    }
}