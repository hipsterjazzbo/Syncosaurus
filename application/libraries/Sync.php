<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sync {
    
    public function do_sync() {
		$this->load->model('user');
		$this->load->model('rules');
			
		$last_sync = $this->user->get_last_sync();
		$rules = $this->rules->get_rules();
			
		foreach($rules as $rule) {
			$this->do_rule($rule);
		}
			
		$this->user->update_last_sync();
    }
	
	private function do_rule($rule) {
		$this->load->library('services/' . $rule->source);
		$items = $this->{$rule->source}->read($last_sync, $rule->type);
			
		foreach($items as $item) {
			if(!$this->type_matches($item, $rule)) continue;			
			$this->distribute_item($rule, $item);
		}
	}
	
	private function distribute_item($rule, $item) {
		foreach($rule->destinations as $destination) {
			$this->load->library('services/' . $destination);
			$this->{$destination}->write($item);
		}
	}
    
    private function type_matches($item, $rule) {
        if(!isset($rule->type)) return TRUE;
        if($item->type != $rule->type) return FALSE;
        else return TRUE;
    }
}