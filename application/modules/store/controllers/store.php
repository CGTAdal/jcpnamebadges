<?php
class Store extends MX_Controller {
	
	var $error_messages = "";
	
	function __construct() {
		parent::__construct();
		$this->load->model('store_model');
	}	
	function login() {
		if(isset($this->session->userdata['store'])){
			redirect('order/select');
		}else{
			if($this->input->post('submit')) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('store_number', 'Store number', 'required');			
				if($this->form_validation->run()) {
					$number	= (string)$this->input->post('store_number');
					$store 	= $this->store_model->getStoreDetail(array('store_number'=>$number));
					if(count($store)>0) {
							$this->session->set_userdata('store', $store);
							redirect('order/select');
					}
					if(preg_match("/^[0-9]{4}$/",$number)){		
						if($this->check_login($number)){
							redirect('order/select');
						}							
						if(count($store)>0) {
							$this->session->set_userdata('store', $store);
							redirect('order/select');
						}else {
							$this->error_messages = "Unit Number Does Not Exist.";
						}	
					}else{
						$this->error_messages = "Please Enter The Full 4 Digit Unit Number.";
					}	
				}
				
			}
			$data['content'] 		= 'login';
			$data['error_messages']	= $this->error_messages;
			$this->load->view('front_end/index',$data);
		}
	}	
	function check_login($number){		
		$stores = $this->store_model->getStoreList();		
		foreach($stores as $store):
			$store_number = explode('-', $store->store_number);
			if($number == $store_number[0]){
				$this->session->set_userdata('store', $store);				
				return true;
			}
		endforeach; 
		return false;
	}
	function logout() {
		$this->session->unset_userdata('new_attn');
		$this->session->unset_userdata('store');
		$this->session->unset_userdata('cart');
		$this->session->unset_userdata('cart_total');
		redirect('store/login');
	}
}