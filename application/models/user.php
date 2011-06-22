<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function get_last_sync() {
        $where  = array('_id' => $this->session->userdata('user_id'));
        $fields = array('last_sync');
        
        $result = $this->mongo->db->users->findOne($where, $fields);
        
        return $result['last_sync'];
    }
    
    function update_last_sync() {
        $where  = array('_id' => $this->session->userdata('user_id'));
        $update = array(
			'$set' => array(
				'last_sync' => time()
			)
		);
        
        $this->mongo->db->users->update($where, $update);
    }
}