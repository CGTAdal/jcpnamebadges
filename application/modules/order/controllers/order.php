<?php
class Order extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		if(!isset($this->session->userdata['store'])) {
			redirect('');
		}
		$this->load->model('order_model');
	}
	
	function add() {
		$order_customer = (string)$this->input->post('order_customer');		
		if(!isset($this->session->userdata['cart'])) {
			redirect('order/select');
		}
		$badgesData = isset($this->session->userdata['cart']['badges'])?$this->session->userdata['cart']['badges']:'';
		if(!empty($badgesData)){
			foreach ($badgesData as $key => $value) { 
					$this->db->where('item_id',(int)$value['badge_Id']);
					$query	= $this->db->get('items');
					$itemsprice	= $query->row(); 
					//$totalAmount += $itemsprice->item_price;
					$this->session->userdata['cart']['badges'][$key]['badge_price'] =  !empty($itemsprice->item_price)?$itemsprice->item_price:0;
			}
		}
		$this->session->userdata['cart']['handling_charge'] =  HANDLING_CHARGE_PER_ORDER;
		$cart	= $this->session->userdata['cart'];
		$total	= isset($this->session->userdata['cart_total'])?$this->session->userdata['cart_total']:0;
		$serviceyear	= isset($cart['serviceyear'])?$cart['serviceyear']:null;

		$store	= $this->session->userdata['store'];
		#set shipping address 
		$shipping	= array();
		$shipping['attn']	 = (isset($store->store_attn))?($store->store_attn):'Store Leader';
		$shipping['address'] = $store->store_address;
		$shipping['city']	 = $store->store_city;
		$shipping['state']	 = $store->store_state;
		$shipping['zip']	 = $store->store_zip;
		$shipping['aor']	 = $store->store_aor;
		if($store->store_number==9900){	
			$sname = isset($store->store_name)?$store->store_name:"JCPenney Headquarters";
		}else{
			$sname = "JCP Store ".$store->store_number;
		}
		$shipping['store_name']	 = $sname;
		#set input data
		$data	= array();		
		$data['store_id']		= $store->store_id;
		$data['order_customer']	= $order_customer;
		$data['order_total']	= $total;
		$data['order_items']	= serialize($cart);	 
		$data['order_date']		= time();
		$data['order_shipping']	= serialize($shipping);

		$extras = isset($cart['extras'])?$cart['extras']:null;
		$accessories = isset($cart['accessories'])?$cart['accessories']:null;
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners = 0;
		$total_extender_qty = 0;
		$total_bar_qty = 0;
		if($extras) {
			foreach($extras as $item) {
				if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
				else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
			}
		}
		if($accessories) {
			foreach($accessories as $item) {
				if($item['type']=='Adhesive Charm Extender') $total_extender_qty += $item['qty'];
				else if($item['type']=='Salon Magnetic Charm Bar') $total_bar_qty += $item['qty'];
			}
		}
		$data['order_mf_qty']	= $total_magnetic_fasteners;
		$data['order_pf_qty']	= $total_pin_fasteners;
		$data['order_extender_qty']	= $total_extender_qty;
		$data['order_bar_qty']	= $total_bar_qty; 
				
		# save order into database
		$oderId = $this->order_model->saveItem('orders',array('id'=>0),$data);
		
		# unset session
		$this->session->unset_userdata('cart');
		$this->session->unset_userdata('cart_total');
		$this->session->unset_userdata('new_attn');
		$this->session->unset_userdata('new_storename');
		$this->session->unset_userdata('new_add');
		$this->session->unset_userdata('new_city');
		$this->session->unset_userdata('new_state');
		$this->session->unset_userdata('new_zip');
		$this->session->unset_userdata('new_aor');
		
		#load view
		$data['orderId']		= $oderId;
		$data['total_badges']	= $total;
		$data['badges']			= $cart;
		$data['serviceyear']	= $serviceyear;	
		$data['total_ext_qty']	= $total_extender_qty;
		$data['total_bar_qty']	= $total_bar_qty;
		$data['total_mf']		= $total_magnetic_fasteners;
		$data['total_pf']		= $total_pin_fasteners;
		$data['content']		= 'thanks';
		$this->load->view('front_end/index',$data);
	}
	
	function detail($orderId) {
		# get order detail
		$order	= $this->order_model->getOrderDetail($orderId);
		
		# order's items
		$order_items = unserialize($order->order_items);
		# badges
		$order_badges	= isset($order_items['badges'])?$order_items['badges']:$order_items;
		# total badges
		//$total_badges	= ($order_badges)?count($order_badges):0;
		$total_badges	= $order->order_total;
		# total extras magnetic
		$total_magnetic_fasteners = $order->order_mf_qty;
		# total extras pin
		$total_pin_fasteners	  = $order->order_pf_qty;
		# total extras magnetic
		$total_extender_qty = $order->order_extender_qty;
		# total extras pin
		$total_bar_qty	  = $order->order_bar_qty;


		$tmp 	= explode('.',number_format($total_badges*2.75 + $total_magnetic_fasteners*7.5 + $total_pin_fasteners*5 + HANDLING_CHARGE_PER_ORDER,2));
		$first 	= $tmp[0];
		$last	= $tmp[1];
		if($last > 0){
			$last = trim($last,'0');
		}
		$order_price = $first.'.'.$last;
				
		$shipping	= (count($order)>0)?unserialize($order->order_shipping):'';

		#load view
		$data['order']	 		= $order;
		$data['total_badges']	= $total_badges;
		$data['total_mf']		= $total_magnetic_fasteners;
		$data['total_pf']		= $total_pin_fasteners;
		$data['total_ext_qty']	= $total_extender_qty;
		$data['total_bar_qty']	= $total_bar_qty;
		$data['order_price']	= $order_price;
		$data['shipping']		= $shipping;
		$data['content'] 		= 'detail';
		$this->load->view('front_end/index',$data);
	}
	
	function listOrders() {
		$store		= $this->session->userdata['store'];
		$attributes = array();
		$attributes['where']	= "store_id = ".(int)$store->store_id;
		$attributes['order_by']	= array('order_id','DESC');
		$orders	= $this->order_model->getItemList('orders',$attributes);
				
		$data['orders']		= $orders;
		$data['content']	= 'list';
		$this->load->view('front_end/index',$data);
	}
	
	function select() {		 
		//echo strlen(md5(trim(addslashes('jcpbadgeS123')));
		$store	= $this->session->userdata['store'];
		$items	= $this->order_model->getItemList('items',array('where'=>'item_status = 1','order_by'=>array('item_order','asc')));
		$cart	= (isset($this->session->userdata['cart']))?$this->session->userdata['cart']:array();
		$titles	= array(
			'licensed optician'				=> 'license optician',
			'licensed optician manager'		=> 'licensed optician manager',
			'apprenticed optician'			=> 'apprenticed optician',
			'licensed dispensing optician' 	=> 'licensed dispensing optician',
			'optical lead expert'			=> 'optical lead expert',
			'optical specialist'			=> 'optical specialist'
		);
		
		$new_options = array(
			'jcpenney'		=> 'jcpenney',
			'Supervisor'	=> 'Supervisor',
			'expert'		=> 'expert',
			'specialist'	=> 'specialist'
		);
		
		$data['store_number']	= $store->store_number;
		$data['store_minor']	= $store->store_minor;
		$data['store_aor']		= '007900';
		$data['items']			= $items;
		$data['cart']			= $cart;
		$data['titles']			= $titles;
		$data['new_options']	= $new_options;
		$data['content'] 		= 'default';
		$this->load->view('front_end/index',$data);
	}
	
	function detailOrderBox() {
		$order_uri = (string)$this->uri->segment(2);
		if($order_uri == 'shipping')
		{
			if(!isset($this->session->userdata['cart']))
			{
				redirect('order/select');
			}
			else
			{
				$cart	= $this->session->userdata['cart'];
				if(count($cart)<=0)
					redirect('order/select');
			}
			$cart = $this->session->userdata['cart'];
			$data['remove_cart'] = $order_uri;
			$data['cart'] = $cart; 
		}		
		if($order_uri == 'detail')
		{
			$id =(int)$this->uri->segment(3); 
			$order 			= $this->order_model->getItemDetail('orders',array('field'=>'order_id','id'=>$id));
			$items			= (count($order)>0)?unserialize($order->order_items):'';			
			$data['cart'] 	= $items;
			$data['remove_cart'] = $order_uri;
		}			
		$this->load->view('order/detailBox',$data);
	}

	function shipping() {
		if(!isset($this->session->userdata['cart'])) {
			redirect('order/select');
		}
		$store			= $this->session->userdata['store'];
		$store_detail	= $this->order_model->getItemDetail('stores',array('field'=>'store_id','id'=>$store->store_id));
		$total_badges	= isset($this->session->userdata['cart_total'])?$this->session->userdata['cart_total']:0;
		//echo "<pre>";
		//print_r($store);
		// set attn
		$new_storename = '';
		$new_aor= '';
		$new_attn = '';
		$new_add = '';
		$new_city = '';
		$new_state = '';
		$new_zip = '';	
		 
		if(!isset($this->session->userdata['new_storename'])|| $this->session->userdata['new_storename'] == ""){
			$new_storename = 'JCPenney Headquarters';
		} else{
			$new_storename = $this->session->userdata['new_storename'];			
		}	
		if(!isset($this->session->userdata['new_attn'])|| $this->session->userdata['new_attn'] == ""){
			$new_attn = 'Store Leader';
		} else{
			$new_attn = $this->session->userdata['new_attn'];			
		}
		if(!isset($this->session->userdata['new_add'])|| $this->session->userdata['new_add'] == ""){
			$new_add = $store_detail->store_address;
		} else{
			$new_add = $this->session->userdata['new_add'];			
		}
		if(!isset($this->session->userdata['new_city'])|| $this->session->userdata['new_city'] == ""){
			$new_city = $store_detail->store_city;
		} else{
			$new_city = $this->session->userdata['new_city'];			
		}
		if(!isset($this->session->userdata['new_state'])|| $this->session->userdata['new_state'] == ""){
			$new_state = $store_detail->store_state;
		} else{
			$new_state = $this->session->userdata['new_state'];			
		}
		if(!isset($this->session->userdata['new_zip'])|| $this->session->userdata['new_zip'] == ""){
			$new_zip = $store_detail->store_zip;
		} else{
			$new_zip = $this->session->userdata['new_zip'];			
		}
		if(!isset($this->session->userdata['new_aor'])|| $this->session->userdata['new_aor'] == ""){
			$new_aor = $store_detail->store_aor;
		} else{
			$new_aor = $this->session->userdata['new_aor'];			
		}
		// get cart info
		$cart 	= $this->session->userdata['cart'];
		$badges	= isset($cart['badges'])?$cart['badges']:null;
		
		$extras	= isset($cart['extras'])?$cart['extras']:null;
		$accessories	= isset($cart['accessories'])?$cart['accessories']:null;
		$serviceyear	= isset($cart['serviceyear'])?$cart['serviceyear']:null;
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners	  = 0;
		$total_extender_qty	= 0;
		$total_bar_qty	= 0;
		if($extras) {
			foreach($extras as $item) {
				if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
				else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
			}
		}
		if($accessories) {
			foreach($accessories as $item) {
				if($item['type']=='Adhesive Charm Extender') $total_extender_qty += $item['qty'];
				else if($item['type']=='Salon Magnetic Charm Bar') $total_bar_qty += $item['qty'];
			}
		}

		
		$data['new_storename']  = $new_storename;
		$data['new_attn']       = $new_attn;
		$data['new_add']      	= $new_add;
		$data['new_city']       = $new_city;
		$data['new_state']      = $new_state;
		$data['new_zip']      	= $new_zip;
		$data['new_aor']      	= $new_aor;

		$data['store']			= $store_detail;
		$data['total_badges']	= $total_badges;
		$data['badges']			= $badges;
		$data['extras']			= $extras;
		$data['serviceyear']	= $serviceyear;
		$data['total_ext_qty']	= $total_extender_qty;
		$data['total_bar_qty']	= $total_bar_qty;
		$data['total_mf']		= $total_magnetic_fasteners;
		$data['total_pf']		= $total_pin_fasteners;
		$data['content']		= 'shipping';		
		$this->load->view('front_end/index',$data);
	}
}