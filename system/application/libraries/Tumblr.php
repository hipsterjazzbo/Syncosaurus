<?php

/**
 * CodeIgniter Tumblr API Library
 *
 * Author: Caleb Fidecaro
 *
 **/
 
class Tumblr {

	public function auth($email, $password)
	{
		$request_parameters = array(
			'email' => $email,
			'password' => $password
		);
		
		$c = curl_init('http://www.tumblr.com/api/authenticate');
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $request_parameters);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($c, CURLOPT_PROXY, "http://alb-cache.massey.ac.nz:8080");
		curl_setopt($c, CURLOPT_PROXYPORT, 8080);
		curl_setopt($c, CURLOPT_PROXYUSERPWD, "04330269:5140");
		$result = curl_exec($c);
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($c);
		
		$result = new SimpleXMLElement($result);
		
		// Check for success
		if ($status == 200) {
		    echo "User logged in.\n<br><br><pre>";
		    var_dump($result);
		    echo '</pre>';
		} else if ($status == 403) {
		    echo 'Bad email or password';
		} else {
		    echo "Error: $result\nStatus: $status\n";
		}
		
	}
	
	public function read($name, $email, $password)
	{
		$request_parameters = array(
			'email' => $email,
			'password' => $password
		);
		
		$c = curl_init('http://' . $name . '.tumblr.com/api/read');
		curl_setopt($c, CURLOPT_HTTPGET, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $request_parameters);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);		
//		curl_setopt($c, CURLOPT_PROXY, "http://alb-cache.massey.ac.nz:8080");
//		curl_setopt($c, CURLOPT_PROXYPORT, 8080);
//		curl_setopt($c, CURLOPT_PROXYUSERPWD, "04330269:5140"); 
		$result = curl_exec($c);
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($c);
		
		// Check for success
		if ($status == 200) {
		    return $result;
		} else if ($status == 403) {
		    echo 'Bad email or password';
		} else {
		    echo "Error: $result\n<br>Status: $status\n";
		}		
	}
	
	public function write($group, $email, $password, $type, $content)
	{
		$request_parameters = array(
			'email' => $email,
			'password' => $password,
			'type' => $type,
			'send-to-twitter' => 'no',
			'group' => $group,
			'generator' =>'Syncosaur.us',
			'date' => time()
		);
		
		$request_parameters = array_merge($request_parameters, $content);
		
		$c = curl_init('http://www.tumblr.com/api/write');
		curl_setopt($c, CURLOPT_HTTPGET, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $request_parameters);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);		
//		curl_setopt($c, CURLOPT_PROXY, "http://alb-cache.massey.ac.nz:8080");
//		curl_setopt($c, CURLOPT_PROXYPORT, 8080);
//		curl_setopt($c, CURLOPT_PROXYUSERPWD, "04330269:5140"); 
		$result = curl_exec($c);
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($c);
		
		$return['result'] = $result;
		$return['status'] = $status;
		$return['params'] = $request_parameters;
		
		return $return;
	}
}

?>