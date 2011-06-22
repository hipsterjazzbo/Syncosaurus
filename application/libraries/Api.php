<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Better way below
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
    	//$this->service->
    }
    
    public function write($credentials)
    {
    	
    }
} */

abstract class Api {
	
	abstract public function write(syncItem $item);
	abstract public function read($since, $type = 'all');
	
	private $ch;
	private $url;
	private $response;
	private $info;
	private $http_code;

	function __construct() {
		$this->ch = curl_init();
		$this->setOption(CURLOPT_RETURNTRANSFER, true);
		$this->setOption(CURLOPT_BINARYTRANSFER, true);
		$this->setOption(CURLOPT_FOLLOWLOCATION, true);
	}

	function __destruct() {
		curl_close($this->ch); 
	}

	private function retry_exec() {
		$i = 0;
		
		while($i++ < CURL_EXEC_RETRY_MAX) {
			$this->response = curl_exec($this->ch);
			if($this->response) break;
			if($i < CURL_EXEC_RETRY_MAX) sleep($i);
		}
	}

	protected function set_option($option, $value) {
		curl_setopt($this->ch, $option, $value);
	}

	protected function exec($url = '') {
		if($url != '') $this->setOption(CURLOPT_URL, $url);
		$this->retryExec();
		$this->info = curl_getinfo($this->ch);
		$this->http_code = $this->info['http_code'];
	}

	protected function get_http_code() {
		return $this->http_code;
	}
	
	protected function get_exec_response() 
	{
		return $this->response;
	}
	
	protected function get_exec_info() {
		return $this->info;
	}
	
	protected function get_error() {
		return curl_error($this->ch);
	}
	
	protected function get($url) {
		$this->set_option(CURLOPT_HTTPGET, TRUE);
		$this->exec($url);
	}
	
	protected function post($url) {
		$this->set_option(CURLOPT_POST, TRUE);
		$this->exec($url);
	}
	
	protected function put($url) {
		$this->set_option(CURLOPT_PUT, TRUE);
		$this->exec($url);
	}
	
	protected function delete($url) {
		$this->set_option(CURLOPT_CUSTOMREQUEST, 'DELETE');
		$this->exec($url);
	}
}