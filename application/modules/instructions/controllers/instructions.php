<?php
class Instructions extends MX_Controller {
	
	function __construct() {
		parent::__construct();	
	}
	function index(){
		$data['content'] = 'index';
		$this->load->view('front_end/index',$data);
	}
}	
?>