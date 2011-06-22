<?php

class Sync extends CI_Controller {
	
	function index() {
		$this->load->library('sync');
		$this->sync->do_sync();
	}
	
	function test($service, $method, $item = null) {
		$user = $this->mongo->db->users->findOne(array('username' => 'cfidecaro'));
		$credentials = $user['services'][$service];
		$returned = $this->api->$service($method, $credentials, $item);
		echo '<pre>';
		var_dump($returned);
		echo '</pre>';
	}
}