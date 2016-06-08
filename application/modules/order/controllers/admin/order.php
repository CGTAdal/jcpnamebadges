<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order extends MX_Controller {
	
	var $order_table = 'orders';
	
	function __construct() 
	{
		parent::__construct();
		if(!isset($this->session->userdata['admin'])) 
		{
			redirect('admin/login');
		}
		$this->load->model('order_model');
	}
	
	function exportToExcel() {
		# filter by from date
		$from_date 				= isset($this->session->userdata['filter_order_from_date'])?$this->session->userdata['filter_order_from_date']:'';
		# filter by to date
		$to_date 				= isset($this->session->userdata['filter_order_to_date'])?$this->session->userdata['filter_order_to_date']:'';
		# filter by shipped from date
		$s_from_date 			= isset($this->session->userdata['filter_order_shipped_from_date'])?$this->session->userdata['filter_order_shipped_from_date']:'';
		# filter by shipped to date
		$s_to_date 				= isset($this->session->userdata['filter_order_shipped_to_date'])?$this->session->userdata['filter_order_shipped_to_date']:'';
		# limit
		$perpage				= isset($this->session->userdata['order_on_per_page'])?$this->session->userdata['order_on_per_page']:'';
		# offset
		$offset					= isset($this->session->userdata['order_list_offset'])?$this->session->userdata['order_list_offset']:'';
		# filter by order_id
		$search_order_id 		= isset($this->session->userdata['search_order_id'])?$this->session->userdata['search_order_id']:'';
		# filter by store number
		$search_store_number	= isset($this->session->userdata['search_store_number'])?$this->session->userdata['search_store_number']:'';
		# filter by order total
		$search_order_total		= isset($this->session->userdata['search_order_total'])?$this->session->userdata['search_order_total']:'';
		
		// order by
		if($this->session->userdata['sort_by_order_id']!="") {
			$order_by = array(
				'field'		=> 'order_id',
				'sort_type'	=> $this->session->userdata['sort_by_order_id']
			);
		} else if($this->session->userdata['sort_by_store_number']!="") {
			$order_by = array(
				'field'		=> 'stores.store_number',
				'sort_type'	=> $this->session->userdata['sort_by_store_number']
			);
		} else if($this->session->userdata['sort_by_cost']!="") {
			$order_by = array(
				'field'		=> 'order_total * 2.75 + order_mf_qty * 7.5 + order_pf_qty * 5',
				'sort_type'	=> $this->session->userdata['sort_by_cost']
			);
		}
		# set filter
		$filter = array(
			'from_date'		=> $from_date,
			'to_date'		=> $to_date,
			's_from_date'	=> $s_from_date,
			's_to_date'		=> $s_to_date,
			'offset'    	=> $offset,
			'perpage'  	 	=> $perpage,
			'order_by'		=> $order_by,
			'order_id'		=> $search_order_id,
			'store_number'	=> $search_store_number,
			'order_total'	=> $search_order_total,
		);
		
		$orders = $this->order_model->getOrderList($filter);
		$data['orders']	= $orders;
		$view 	= $this->load->view('order/admin/list_excel',$data);
		
		$file	 = "JCP-Output.xls";
		$content = "";
		header("Content-type: application/excel");
		header("Content-Disposition: attachment; filename=$file");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $view;
	}
	
	function listOrders() {
		if($this->input->post('sort_type')) {
			// set order_by
			$sort_type = $this->input->post('sort_type');
			switch($sort_type) {
				case 'order_id':
					if(isset($this->session->userdata['sort_by_order_id'])) {
						$current_type = $this->session->userdata['sort_by_order_id'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_by_order_id','asc');
						} else {
							$this->session->set_userdata('sort_by_order_id','desc');
						}
					} else {
						$this->session->set_userdata('sort_by_order_id','desc');
					}
					$this->session->set_userdata('sort_by_store_number','');
					$this->session->set_userdata('sort_by_cost','');
					$order_by = array(
						'field'		=> 'order_id',
						'sort_type'	=> $this->session->userdata['sort_by_order_id']
					);
				break;
				case 'store_number':
					if(isset($this->session->userdata['sort_by_store_number'])) {
						$current_type = $this->session->userdata['sort_by_store_number'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_by_store_number','asc');
						} else {
							$this->session->set_userdata('sort_by_store_number','desc');
						}
					} else {
						$this->session->set_userdata('sort_by_store_number','desc');
					}
					$this->session->set_userdata('sort_by_order_id','');
					$this->session->set_userdata('sort_by_cost','');
					$order_by = array(
						'field'		=> 'stores.store_number',
						'sort_type'	=> $this->session->userdata['sort_by_store_number']
					);
				break;
				case 'cost':
					if(isset($this->session->userdata['sort_by_cost'])) {
						$current_type = $this->session->userdata['sort_by_cost'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_by_cost','asc');
						} else {
							$this->session->set_userdata('sort_by_cost','desc');
						}
					} else {
						$this->session->set_userdata('sort_by_cost','desc');
					}
					$this->session->set_userdata('sort_by_order_id','');
					$this->session->set_userdata('sort_by_store_number','');
					$order_by = array(
						'field'		=> 'order_total * 2.75 + order_mf_qty * 7.5 + order_pf_qty * 5',
						'sort_type'	=> $this->session->userdata['sort_by_cost']
					);
				break;
			}
		} else {
			setSessionVariable(false, 'sort_by_order_id', 'desc');
			setSessionVariable(false, 'sort_by_store_number', '');
			setSessionVariable(false, 'sort_by_cost', '');
			$order_by = array(
				'field'		=> 'order_id',
				'sort_type'	=> 'desc'
			);
		}
		
		// per page
		$perpage	= setSessionVariable($this->input->post('perpage'), 'order_on_per_page', 12);
		// offset
		$offset		= ($this->uri->segment(4)=='')?0:$this->uri->segment(4);
		setSessionVariable($offset, "order_list_offset", 0);
		// filter by dates
		$from_date 	= $this->input->post('from_date');
		$to_date 	= $this->input->post('to_date');
		if($from_date != '') {
			$this->session->unset_userdata('filter_order_from_date');
			$from_date = strtotime($from_date);			
		}
		if($to_date != ''){
			$this->session->unset_userdata('filter_order_to_date');
			$to_date = strtotime($to_date);			
		}		
		$from_date	= setSessionVariable($from_date, 'filter_order_from_date', '');
		$to_date	= setSessionVariable($to_date, 'filter_order_to_date', '');
		
		$s_from_date 	= $this->input->post('s_from_date');
		$s_to_date 		= $this->input->post('s_to_date');
		if($s_from_date != '') {
			$s_from_date = strtotime($s_from_date);			
		}
		if($s_to_date != ''){
			$s_to_date = strtotime($s_to_date);			
		}
		$s_from_date	= setSessionVariable($s_from_date, 'filter_order_shipped_from_date', '');
		$s_to_date		= setSessionVariable($s_to_date, 'filter_order_shipped_to_date', '');
		
		// filter by order_id 
		$search_order_id = setSessionVariable($this->input->post('search_order_id'), 'search_order_id', '');
		// filter by store number		
		$search_store_number = setSessionVariable($this->input->post('search_store_number'), 'search_store_number', '');
		// filter by order total
		$search_order_total = setSessionVariable($this->input->post('search_order_total'), 'search_order_total', '');
				
		$filter = array(
			'from_date'		=> $from_date,
			'to_date'		=> $to_date,
			's_from_date' 	=> $s_from_date,
			's_to_date'		=> $s_to_date,
			'offset'    	=> $offset,
			'perpage'   	=> $perpage,
			'order_by'		=> $order_by,
			'order_id'		=> $search_order_id,
			'store_number'	=> $search_store_number,
			'order_total'	=> $search_order_total,		
		);
		#Create pagintaion
		$order_total = $this->order_model->getOrderTotal($filter);
		$this->load->library('pagination');
		$config['total_rows'] 		= $order_total;
		$config['per_page'] 		= $perpage;
		$config['first_link']		= 'First';
		$config['last_link']		= 'Last';
		$config['next_link']		= '';
		$config['prev_link']		= '';
		$config['num_tag_open']		= '<span style="padding:0 5px 0 5px">';
		$config['num_tag_close']	= '</span>';
		$config['num_links']		= 2;
		$config['cur_tag_open']		= '<span style="padding:0 5px 0 5px;color:#ffffff;background-color:#333333;">';
		$config['cur_tag_close']	= '</span>';
		$config['base_url']			= base_url().'admin/order/listOrders/';
		$config['uri_segment']		= 4;
		$this->pagination->initialize($config); 
		$pagination	= $this->pagination->create_links();		
		
		# get order list
		$orders = $this->order_model->getOrderList($filter);
//		display($filter);
//		display($orders);
		
		$data['orders']				= $orders;
		$data['from_date']			= $from_date;
		$data['to_date']			= $to_date;
		$data['s_from_date']		= $s_from_date;
		$data['s_to_date']			= $s_to_date;
		$data['search_order_id']	= $this->session->userdata['search_order_id'];
		$data['search_store_number']= $this->session->userdata['search_store_number'];
		$data['search_order_total']	= $this->session->userdata['search_order_total'];
		$data['sort_order_id']		= $this->session->userdata['sort_by_order_id'];
		$data['sort_unit']			= $this->session->userdata['sort_by_store_number'];
		$data['sort_cost']			= $this->session->userdata['sort_by_cost'];
		$data['pagination'] 		= $pagination;
		$data['select_perpage'] 	= $this->session->userdata['order_on_per_page']; 
		$data['role'] 				= $this->session->userdata['role'];
		$data['content']			= 'admin/list';
		$this->load->view('back_end/index',$data);
	}
	
	function detail($id)
	{
		$order 		= $this->order_model->getOrderDetail($id);
		$item		= (count($order)>0)?unserialize($order->order_items):'';		
		$shipping	= (count($order)>0)?unserialize($order->order_shipping):'';

		$badges		= (isset($item['badges']))?$item['badges']:((!isset($item['extras']))?$item:null);
		$serviceyear = (isset($item['serviceyear']))?$item['serviceyear']:null;
		
		$data['order'] 		= $order;
		$data['badges']		= $badges;
		$data['shipping'] 	= $shipping;
		$data['serviceyear']= $serviceyear;	
		$data['content']	= 'admin/detail';
		$this->load->view('back_end/index',$data);
	}
	
	function delete($order_id) {
		# get order detail
		$order	= $this->order_model->getItemDetail('orders',array('field'=>'order_id', 'id'=>$order_id));
		
		if($order->order_shipdate==0) { # if order haven't been shipped
			if($this->order_model->deleteItem('orders',array('field'=>'order_id', 'id'=>$order_id))) {
				redirect('admin/order/listorders');
			} else return false;
		} else {
			redirect('admin/order/listorders');
		}  
	}
}