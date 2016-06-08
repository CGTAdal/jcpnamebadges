<?php
class Ajax extends MX_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('order_model');
	}
	
	function addBadgesToCart() {
		if(isset($this->session->userdata['cart'])) {
			$cart 	= $this->session->userdata['cart'];
			$badges	= (isset($cart['badges']))?$cart['badges']:array();
		} else {
			$cart 	= array();
			$badges	= array();
		}
		
		$styles			    = $this->input->post('styles');
		$names			    = $this->input->post('names');
		$titles			    = $this->input->post('titles');
		$licenses		    = $this->input->post('licenses');
		$fasteners		    = $this->input->post('fasteners');
		$spk_spanish	    = $this->input->post('spk_spanish');
        $hearing_impaired   = $this->input->post('hearing_impaired');
		
		$total = 0;
		$items = array();
		foreach($styles as $key=>$style) {
			$temp_item = array();
			$temp_item['style']			= $style;
			$temp_item['name']			= $names[$key];
			$temp_item['fastener']		= $fasteners[$key];
			if($titles) {
				$temp_item['title']		= $titles[$key];
			}
			if($licenses) {
				$temp_item['license']	= $licenses[$key];
			}
			if($spk_spanish) {
				$temp_item['spk_spanish']	= $spk_spanish[$key];
			}
            if($hearing_impaired) {
                $temp_item['hearing_impaired']	= $hearing_impaired[$key];
            }
			$items[] = $badges[] 	= $temp_item;
			$total	+= 1;
		}
		
		$cart['badges']	= $badges;
		$this->session->set_userdata('cart',$cart);
				
		if(!isset($this->session->userdata['cart_total'])) {
			$cart_total = $total;
		} else {
			$cart_total = $this->session->userdata['cart_total'];
			$cart_total += $total;
		}
		$this->session->set_userdata('cart_total',$cart_total);
		
		$data['badges']	= $items;
		$this->load->view('order/list_badges',$data);
		return;
	}
	
	function addExtrasToCart() {
		$magnet_qty = (int)$this->input->post('magnet_qty');
		$pin_qty	= (int)$this->input->post('pin_qty');
		
		if($magnet_qty + $pin_qty > 0) {
			if(isset($this->session->userdata['cart'])) {
				$cart 	= $this->session->userdata['cart'];
			} else {
				$cart = array();
			}
			
			$magnetic_item = array(
				'type'	=> 'magnetic fastener',
				'qty'	=> $magnet_qty,
				'name'	=> '5-Pack Magnets'				
			);
			
			$pin_item = array(
				'type'	=> 'pin fastener',
				'qty'	=> $pin_qty,
				'name'	=> '5-Pack Pins'
			);
			
			$extras = array($magnetic_item,$pin_item);
			$cart['extras']	= $extras;
			
			$this->session->set_userdata('cart',$cart);
			
			$data['extras']	= $extras;
			$this->load->view('order/list_extras',$data);
			return;
		}
	}
	
	function addInputBox() {				
		$current_input_boxes_number = $this->input->post('current_input_boxes_number');
		$type = $this->input->post('type');		
		switch($type) {
			case '1':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['style']	 = "Leader";
				$data['title']	 = "no title included";
				$data['license'] = 1;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '2':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "Lead Expert";
				$data['title']	= "Lead Expert";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '3':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "Expert";
				$data['title']	= "Expert";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '4':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "general";
				$data['title']	= "no titles";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '5':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "optical";
				$data['title_options'] = array(
					'Licensed Optician'				=> 'Licensed Optician',
					'Licensed Optician Manager'		=> 'Licensed Optician Manager',
					'Apprenticed Optician'			=> 'Apprenticed Optician',
					'Licensed Dispensing Optician' 	=> 'Licensed Dispensing Optician'
				);
				$this->load->view('order/form/additional_input_name_form_optical',$data);
				return;				
			break;
			case '7':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "minor specialist";
				$data['title']	= "specialist";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '9':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "custom decorating";
				$data['title_options'] = array(
					'In-Home Decorator'	=> 'In-Home Decorator',
					'Installer'			=> 'Installer'
				);
				$this->load->view('order/form/additional_input_name_form',$data);
				return;				
			break;
			case '10':
				$data['number']		= $current_input_boxes_number + 1;
				$data['style']		= "salon";
				$data['title']		= "no title included";
				$data['license']	= 1;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
		}
	}
	
	function showNamesField() {
		$type	= $this->input->post('type');		
		switch ($type) {
			case '1':
				$data	= array();
				$data['description']	= "Title: Leader";
				$data['style']			= "Leader";
				$data['title']			= "Leader";
				$data['type']			= 1;
				$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '2':
				$data	= array();
				$data['description']	= "Title: Lead Expert";
				$data['style']			= "Lead Expert";
				$data['title']			= "Lead Expert";
				$data['type']			= 2;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '3':
				$data	= array();
				$data['description']	= "Title: Expert";
				$data['style']			= "Expert";
				$data['title']			= "Expert";
				$data['type']			= 3;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '4':
				$data	= array();
				$data['description']	= "No Titles";
				$data['style']			= "general";
				$data['title']			= "no titles";
				$data['type']			= 4;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '5':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['style']			= "optical";
				$data['type']			= 5;
				$data['title_options'] 	= array(
					'Licensed Optician'				=> 'Licensed Optician',
					'Licensed Optician Manager'		=> 'Licensed Optician Manager',
					'Apprenticed Optician'			=> 'Apprenticed Optician',
					'Licensed Dispensing Optician' 	=> 'Licensed Dispensing Optician'
				);
				
				$this->load->view('order/form/input_names_form_optical',$data);
				break;
			case '6':
				$data = array();
				$this->load->view('order/form/input_names_form_generic',$data);
				break;
			case '7':
				$data	= array();
				$data['description']	= "Enter Name For Minor Badge";
				$data['style']			= "minor specialist";
				$data['title']			= "specialist";
				$data['type']			= 7;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '8':
				$data	= array();
				$this->load->view('order/form/input_names_form_minor',$data);
				break;
			case '9':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['style']			= "custom decorating";
				$data['type']			= 9;
				$data['title_options'] 	= array(
					'In-Home Decorator'	=> 'In-Home Decorator',
					'Installer'			=> 'Installer'
				);
				
				$this->load->view('order/form/input_names_form',$data);
				break;
				break;
			case '10':
				$data	= array();
				$data['description']	= "No Titles On Salon Badges";
				$data['style']			= "salon";
				//$data['title']			= "salon";
				$data['title']		= "no title included";
				$data['type']			= 10;
				$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
		}
	}
	
	function deleteBadge() {		
		$id 	= (int)$this->input->post('item_id');				
		$cart 	= $this->session->userdata['cart'];
		$badges	= $cart['badges'];
		unset($badges[$id]);
		$new_badges	= array();
		foreach($badges as $badge) {
			$new_badges[] = $badge;
		}
		if(count($new_badges)>0) {
			$cart['badges']	= $new_badges;
		} else {
			unset($cart['badges']);
		}
		$this->session->set_userdata('cart',$cart);
		$cart_total	= $this->session->userdata['cart_total'];
		$this->session->set_userdata('cart_total',$cart_total-1);
		
		$extras	= isset($cart['extras'])?$cart['extras']:null;
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners	  = 0;
		if($extras) {
			foreach($extras as $item) {
				if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
				else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
			}
		}
		
		$total_order_price = number_format(($cart_total-1)*2.75 + $total_magnetic_fasteners*1.5 + $total_pin_fasteners + HANDLING_CHARGE_PER_ORDER,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		if($last > 0){
			$last = trim($last,'0');
		}
		$total_price = $first.'.'.$last;
		
		$data = array(
			'total_badges'		=> $cart_total-1,
			'total_order_price' => $total_price
		);
		
		echo json_encode($data);
		
	}
	
	function deleteExtras() {
		$type 	= $this->input->post('type');
		$cart	= $this->session->userdata['cart'];
		$extras	= $cart['extras'];
		foreach($extras as $key=>$item) {
			if($item['type']==$type) {
				unset($extras[$key]);
			}
		}
		
		$total_badges	= $this->session->userdata['cart_total'];
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners	  = 0;
		foreach($extras as $item) {
			if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
			else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
		}
		
		$total_badges = $this->session->userdata['cart_total'];
		// calculate the order price
		$total_order_price = number_format($total_badges*2.75 + $total_magnetic_fasteners*1.5 + $total_pin_fasteners + HANDLING_CHARGE_PER_ORDER,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		if($last > 0){
			$last = trim($last,'0');
		}
		$total_price = $first.'.'.$last;
		
		if(count($extras)>0) {
			$cart['extras'] = $extras;
			$total_extras	= count($extras);
		} else {
			unset($cart['extras']);
			$total_extras	= 0;
		}
		$this->session->set_userdata('cart',$cart);
		$data = array(
			'removed_item'		=> $type,
			'total_extras'		=> $total_extras,
			'total_order_price' => $total_price
		);
		echo json_encode($data);
	}
	
	function deleteCart(){
		$this->session->unset_userdata('cart');
		$this->session->unset_userdata('cart_total');
	}
	
	function abcxyz() {
		$this->load->view('order/list_extras');
	}
}