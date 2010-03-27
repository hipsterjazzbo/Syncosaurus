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
    				case 'conversation':
    				case 'quote':
    					return 'post';
    					break;
    				
    				case 'photo':
    					return 'image';
    					break;
    					
    				case 'link':
    					return 'link';
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
	    			
	    			$result = new SimpleXMLElement($result);
	    			
	    			foreach($result->posts->post as $post)
	    			{
	    				$posts[$i]['type']      = $this->getType('tumblr', $post);
	    				$posts[$i]['timestamp'] = (string) $post['unix-timestamp'];
	    				$posts[$i]['source']    = (string) $post['url'];
	    				
	    				foreach($post->children() as $key => $value)
	    				{
	    					switch($key)
	    					{
	    						case 'photo-caption':
	    						case 'link-text':
	    						case 'audio-caption':
	    						case 'regular-title':
	    						case 'video-caption':
	    							$posts[$i]['title'] = (string) $value;
	    							break;
	    						
	    						case 'link-description':
	    						case 'conversation-text':
	    						case 'regular-body':
	    							$posts[$i]['body'] = (string) $value;
	    							break;
	    						
	    						case 'quote-text':
	    							$posts[$i]['body'] = '"' . (string) $value . '"';
	    							break;
	    							
	    						case 'quote-source':
	    							$posts[$i]['body'] .= ' &mdash; ' . (string) $value;
	    							break;
	    							
	    						case 'link-url':
	    							$posts[$i]['source'] = (string) $value;
	    							break;
	    							
	    						case 'video-player':
	    							$posts[$i]['embed'] = (string) $value;
	    							break;
	    					}
	    				}
	    				
	    				$i++;
	    			}
	    			
					return $posts;
	    			break;
	    		
	    		case 'write':
	    			
	    			switch($post['type'])
	    			{
	    				case 'status':
	    					$type = 'regular';
	    					$content['body'] = $post['body'];
	    					break;
	    					
	    				case 'post':
	    					$type = 'regular';
	    					if($post['title'] != null)
	    					{
	    						$content['title'] = $post['title'];
	    					}
	    					$content['body'] = $post['body'];
	    					break;
	    					
	    				case 'link':
	    					$type = 'link';
	    					$content['name'] = $post['title'];
	    					$content['url'] = $post['source'];
	    					$content['description'] = $post['body'];
	    					break;
	    					
	    				case 'image':
	    					$type = 'photo';
	    					$content['source'] = $post['source']; // NOT RIGHT
	    					$content['caption'] = $post['title'];
	    					break;
	    					
	    				case 'video':
	    					$type = 'video';
	    					$content['caption'] = $post['body'];
	    					$content['embed'] = $post['embed'];
	    					break;
	    					
	    				case 'audio':
	    					$type = 'audio';
	    					break;
	    			}
	    			
	    			$return = $this->CI->tumblr->write('devthing.tumblr.com', $credentials['email'], $credentials['password'], $type, $content);
	    			
	    			$status = $return['status'];
	    			$result = $return['result'];
	    			$params = $return['params'];
	    			
	    			// Check for success
	    			if ($status == 201) {
	    			    echo $status;
	    			    return true;
	    			} else if ($status == 403) {
	    			    echo 'Bad email or password';
	    			} else {
	    			    echo "Error: $result\n<br>Status: $status\n" . '<pre>';
	    			    var_dump($params);
	    			    echo '</pre>';
	    			}
	    			
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
    	$url = $item['source'];
    	
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