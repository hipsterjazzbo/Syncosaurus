<?php

/**
 * CodeIgniter Instapaper API Library
 *
 * Author: Caleb Fidecaro
 *
 **/
 
 class Instapaper {
 	
 	public function auth($username, $password = null)
 	{
 		$request_parameters = array(
			'username' => $username,
			'password' => $password
		);
		
		$c = curl_init('https://www.instapaper.com/api/authenticate');
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $request_parameters);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($c, CURLOPT_PROXY, "http://alb-cache.massey.ac.nz:8080");
		curl_setopt($c, CURLOPT_PROXYPORT, 8080);
		curl_setopt($c, CURLOPT_PROXYUSERPWD, "04330269:5140");
		curl_exec($c);
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($c);
		
		// Check for success
		if($status == 200) {
		    echo "User logged in.";
		} else if($status == 403) {
		    echo 'Bad username or password';
		} else {
		    echo "Error: $result\nStatus: $status\n";
		}
 	}
 	
 	public function add($username, $password, $url, $title = null, $selection = null, $auto_title = 1, $redirect = null)
 	{
 		$request_parameters = array(
			'username'   => $username,
			'password'   => $password,
			'url'        => $url,
			'title'      => $title,
			'selection'  => $selection,
			'auto-title' => $auto_title,
			'redirect'   => $redirect
		);
		
		$c = curl_init('https://www.instapaper.com/api/add');
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $request_parameters);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($c, CURLOPT_PROXY, "http://alb-cache.massey.ac.nz:8080");
		curl_setopt($c, CURLOPT_PROXYPORT, 8080);
		curl_setopt($c, CURLOPT_PROXYUSERPWD, "04330269:5140");
		curl_exec($c);
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($c);
		
		// Check for success
		if($status == 201) {
		    echo "URL successfully added";
		} else if($status == 400) {
			echo "Bed request, probably missing required parameter<br>";
			echo $url;
		} else if($status == 403) {
		    echo 'Bad username or password';
		} else {
		    echo "Status: $status\n";
		}
 	}
 }