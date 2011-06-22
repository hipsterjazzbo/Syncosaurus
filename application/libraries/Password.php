<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password {

	// blowfish
	private $algo = '$2a';

	// cost parameter
	private $cost = '$10';

	// mainly for internal use
	public function unique_salt() {
		return substr(sha1(mt_rand()),0,22);
	}

	// this will be used to generate a hash
	public function hash($password) {

		return crypt($password,
					$this->algo .
					$this->cost .
					'$' . $this->unique_salt());
	}

	// this will be used to compare a password against a hash
	public function check_password($hash, $password) {

		$full_salt = substr($hash, 0, 29);

		$new_hash = crypt($password, $full_salt);

		return ($hash == $new_hash);
	}
}

