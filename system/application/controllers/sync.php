<?php

class Sync extends Controller {
	
	function index()
	{		
		$user = $this->mongo->db->users->findOne(array('username' => 'cfidecaro'));
		
		foreach($user['rules'] as $rule) // Iterate through rules - we only need to check services that are sources in a rule
		{
			$source = $rule['source'];
			
			if(array_key_exists($source, $user['services'])) // If we have credentials for the service
			{
				$credentials = $user['services'][$source];
				$items = $this->api->$source('read', $credentials); // Read source
			}
			
			else
			{
				echo 'Missing credentials for ' . $source . '<br />';
			}
			
			if(isset($items)) // If something was returned
			{
				$new = false;
				
				foreach($items as $item) // Iterate through what was returned
				{
					// If it's new (created since last sync), and the correct type for the rule
					if($item['timestamp'] >= $user['last_sync'] && $item['type'] == $rule['type'])
					{
						foreach($rule['destinations'] as $destination) // Iterate through destinations
						{
							$credentials = $user['services'][$destination];
							$write = $this->api->$destination('write', $credentials, $item);
							
							if($write)
							{
								echo 'Sent from ' . $source . ' to ' . $destination . '<br />';
							}
						}
						
						$new = true;
					}
				}
				
				if(!$new)
				{
					echo 'No new items on ' . $rule['source'] . '<br />';
				}
				
				unset($items);
			}
		}
		
		$this->mongo->db->users->update(array('username' => 'cfidecaro'), array('$set' => array('last_sync' => time())));
	}
	
	function test($service, $method, $item = null)
	{
		$user = $this->mongo->db->users->findOne(array('username' => 'cfidecaro'));
		$credentials = $user['services'][$service];
		$returned = $this->api->$service($method, $credentials, $item);
		echo '<pre>';
		var_dump($returned);
		echo '</pre>';
	}
}