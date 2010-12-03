<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api {
    
    private $CI;
    private $service;
    
    function Api()
    {
    	$this->CI =& get_instance();
    }
    
    public function __call($service, $args)
    {
	    $this->CI->load->library('drivers/' . $service);
	    var_dump($this->CI->$service);
	    die();
    	
    	return $this;
    }
    
    public function read($credentials)
    {
    	$this->service->
    }
    
    public function write($credentials)
    {
    	
    }
}