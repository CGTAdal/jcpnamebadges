<?php
class Common extends MX_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function showMenu(){
		$store	= $this->session->userdata['store'];
		$data['store']	= $store;
		$this->load->view('common/menu',$data);
	}	
	function showPopup() {
		$this->load->view('common/popup');
	}
}