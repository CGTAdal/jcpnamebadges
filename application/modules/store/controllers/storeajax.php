<?php
class Storeajax extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		if(!isset($this->session->userdata['store'])) {
			return;
		}
		$this->load->model('store_model');
	}
	
	function changeATTN() {
		#change db
		$new_attn = $this->input->post('new_attn',true);
		$store_id = $this->input->post('store_id',true);	
		//$data	  = array('store_attn'=>$new_attn);
		//$this->store_model->saveItem('stores',array('field'=>'store_id','id'=>$store_id),$data);

		#change session
		$store = $this->session->userdata['store'];
		$store->store_attn = $new_attn;
		$this->session->set_userdata('store',$store);		
		$this->session->set_userdata('new_attn',$new_attn);		
		 			
		echo $new_attn;
	}

	function changeSTNAME() {
		#change db
		$new_storename = $this->input->post('new_storename',true);
		$store_id = $this->input->post('store_id',true);	
		 
		#change session
		$store = $this->session->userdata['store'];
		$store->store_name = $new_storename;
		$this->session->set_userdata('store',$store);		
		$this->session->set_userdata('new_storename',$new_storename);		
		 			
		echo $new_storename;
	}

	function changeADD() {
		#change db
		$new_add = $this->input->post('new_add',true);
		$new_city = $this->input->post('new_city',true);
		$new_state = $this->input->post('new_state',true);
		$new_zip = $this->input->post('new_zip',true);
		$store_id = $this->input->post('store_id',true);	
		//$data	  = array('store_attn'=>$new_attn);

		#change session
		$store = $this->session->userdata['store'];
		$store->store_address = $new_add;
		$store->store_city = $new_city;
		$store->store_state = $new_state;
		$store->store_zip = $new_zip;
		$this->session->set_userdata('store',$store);		
		$this->session->set_userdata('new_add',$new_add);		
		$this->session->set_userdata('new_city',$new_city);		
		$this->session->set_userdata('new_state',$new_state);		
		$this->session->set_userdata('new_zip',$new_zip);		
		
		$new_address = array("add_value"=>$new_add,"addcity_value"=>$new_city.', '.$new_state.' '.$new_zip); 	

		echo json_encode($new_address);
	}

	function changeAOR() {
		#change db
		$new_aor = $this->input->post('new_aor',true);
		$store_id = $this->input->post('store_id',true);	
		//$data	  = array('store_attn'=>$new_aor);

		#change session
		$store = $this->session->userdata['store'];
		$store->store_aor = $new_aor;
		$this->session->set_userdata('store',$store);		
		$this->session->set_userdata('new_aor',$new_aor);		
		 			
		echo $new_aor;
	} 
	
}