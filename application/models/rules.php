<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
    
	function get_rules() {
		$where = array('user_id' => $this->session->userdata('user_id'));
		$results = $this->mongo->db->rules->find($where);
		
		foreach($results as $rule) {
			$rules[] = (object) $rule;
		}
		
		return $rules;
	}
}