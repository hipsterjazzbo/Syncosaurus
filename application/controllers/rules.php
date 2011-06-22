<?php

class Rules extends CI_Controller {

	function index()
    {        
        $rules = $this->mongo->db->rules->find();
        
        foreach($rules as $rule) 
        {
        	$ruleText = 'When I post a ' . strtolower($rule['type']) . ' on ' . ucfirst($rule['source']) . ', also send it to ';
        	
        	// Formats the array of destinations like "Dest1, Dest2, Dest3 and Dest4." for display on page
        	$size = count($rule['destinations']);
        	
        	if($size == 1)
        	{
        		$ruleText .= ucfirst($rule['destinations'][0]) . '.';
        	}
        	else if($size == 2)
        	{
        		$ruleText .= ucfirst($rule['destinations'][0]) . ' and ' . ucfirst($rule['destinations'][1]) . '.';
        	}
        	else if($size > 2)
        	{			
        		for($i = 0; $i < $size; $i++)
        		{
        			if($i <= $size - 3)
        			{
        				$ruleText .= ucfirst($rule['destinations'][$i]) . ', ';
        			}
        			else if($i == $size - 2)
        			{
        				$ruleText .= ucfirst($rule['destinations'][$i]) . ' and ';
        			}
        			else if($i == $size - 1)
        			{
        				$ruleText .= ucfirst($rule['destinations'][$i]) . '.';
        			}
        		}
        	}
        	
        	$data['rules'][] = $ruleText;
        }

		$this->load->view('manage_rules', $data);
    }

    function create()
    {
        $rule = array('source' => 'tumblr', 'type' => 'video', 'destinations' => array('facebook', 'twitter', 'youtube', 'flickr'));
        $this->mongo->db->rules->insert($rule);
        var_dump($rule);
    }
	
	function addheaps()
	{
		$i = 0;
		
		while($i < 10000)
		{
			$this->db->query("INSERT INTO twitter SET username = 'cfidecaro', password = 'tr1nity1'");
			
			$i++;
		}
		
		echo 'Done.';
	}
	
	function process($source, $type, $content)
	{
		$rules = $this->mongo->db->rules->find(array('source' => $source, 'type' => $type), array('destinations'));
		
		foreach($rules as $rule)
		{
			foreach($rule['destinations'] as $destination)
			{
				$query = $this->mongo->db->queries->findOne(array('service' => $destination, 'type' => $type), array('query'));
				
				/* HEY! Build an interface to add queries, with a placeholder for content. 
				   That way, adding new services is as easy as working out the send and 
				   recieve queries for each type, and entering them into the database. */
				
				$query = preg_replace('/[[[content]]]/', $content, $query);
			}
		}
	}
}

