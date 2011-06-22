<?php

class Account extends CI_Controller {

	function index()
    {        
    	if($this->session->userdata('logged_in')) {
			$this->load->view('account/index.php');
		}
		
		else {
			$this->load->view('account/login');
		}
    }
    
    function create() {
		
		if(isset($_POST['create_user'])) {
			if($_POST['password'] !== $_POST['password_confirm']) {
				$this->_error('Passwords did not match');
			}
			
			if($this->mongo->db->users->findOne(array('email' => $_POST['email']))) {
				$this->_error('Email already in use');
			}

			$this->load->library('password');

			$user = array(
				'email' => $_POST['email'],
				'password' => $this->password->hash($_POST['password'])
			);

			$result = $this->mongo->db->users->insert($user);
			
			if($result) {
				header('Location: /account');
			}
		}
		
		else {
			$this->load->view('account/create');
		}
	}
	
	function login() {
		if(isset($_POST['login'])) {
			
			$user = $this->mongo->db->users->findOne(array('email' => $_POST['email']));
			
			if(!$user) {
				$this->_error('That email address is not registered');
			}
			
			$this->load->library('password');
			
			if($this->password->check_password($user['password'], $_POST['password'])) {
				$user_session = array(
					'logged_in' => true,
					'_id'       => $user['user_id']
				);
				
				$this->session->set_userdata($user_session);
				
				header('Location: /account');
			}
			
			else {
				$this->_error('Incorrect Password');
			}
		}
		
		else {
			$this->load->view('account/login');
		}
	}
	
	function logout() {
		$this->session->sess_destroy();
		
		header('Location: /account/login');
	}
	
	function _error($error) {
		$view = substr($_SERVER['REQUEST_URI'], 1);
		$data['error'] = $error;
		unset($_POST);
		
		$this->load->view($view, $data);
		return;
	}
}

