<?php

class Facebook extends Api {
	
	private $facebook;
	
	function __construct() {
		parent::__construct();
		
		require 'facebook/facebook.php';

		$this->facebook = new Facebook(array(
		  'appId'  => '368457244245',
		  'secret' => '1cbfe5aefa98de84245e0aebbbcb75cb',
		));
	}
	
	public function write(syncItem $item) {
		switch($item->type) {
			case 'status':
				$post = array(
					'message' => $item->message
				);
				break;
			
			case 'link':
				$post = array(
					'message' => $item->message,
					'name'    => $item->title,
					'link'    => $item->link
				);
			
			case 'picture':
				$post = array(
					'message' => $item->message,
					'picture' => $item->image_url,
					'name'    => $item->title,
					'link'    => $item->link
				);
				break;
			
			case 'video':
				$post = array(
					'message' => $item->message,
					'source'  => $item->video_source,
					'picture' => $item->image_url,
					'name'    => $item->title,
					'link'    => $item->link
				);
				break;
			
			case 'audio':
				// Might have to use old REST API
				break;
			
			default:
				
				break;
		}

		$result = $facebook->api('/me/feed', 'POST', $post);
	}
	
	public function read($since, $type) {
		
	}
}

?>
