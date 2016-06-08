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
		$badge_Id			= $this->input->post('badge_Id');
		$styles			    = $this->input->post('styles');
		$names			    = $this->input->post('names');
		$titles			    = $this->input->post('titles');
		$licenses		    = $this->input->post('licenses');
		$fasteners		    = $this->input->post('fasteners');
		$spk_spanish	    = $this->input->post('spk_spanish');
        $hearing_impaired   = $this->input->post('hearing_impaired');
        $dasl   			= $this->input->post('dasl');
		
		$total = 0;
		$items = array();				 
		foreach($styles as $key=>$style) {
			$temp_item = array();
			$temp_item['style']			= $style;
			$temp_item['badge_Id']		= $badge_Id[$key];
			$temp_item['name']			= $names[$key];
			$temp_item['fastener']		= $fasteners[$key];
			if($titles) {
				$temp_item['title']		= $titles[$key];
			}
			if($licenses) {
				$temp_item['license']	= $licenses[$key];
			}
			if(!empty($spk_spanish)) {
				$temp_item['spk_spanish']	= ($spk_spanish[$key]!='null')?$spk_spanish[$key]:'';
			}
            if(!empty($hearing_impaired)) {
                $temp_item['hearing_impaired']	= ($hearing_impaired[$key]!='null')?$hearing_impaired[$key]:'';
            }
            if(!empty($dasl)) {
                $temp_item['dasl']	= ($dasl[$key]!='null')?$dasl[$key]:'';
            }             
			$items[] = $badges[] 	= $temp_item;
			$total	+= 1;
		}

		$cart['badges']	= $badges;
		$this->session->set_userdata('cart',$cart);		
		//print_r($this->session->userdata['cart_total']);
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
	
	function addYearsToCart(){ 
		$charm = ($this->input->post('postdata'));
		$charm_array = explode(',', $charm);		 
		////serviceyear
		if(isset($this->session->userdata['cart'])) {
			$cart 	= $this->session->userdata['cart'];
		} else {
			$cart = array();
		} 
		$charm_item = array();
		foreach ($charm_array as $key => $value) {
			$charm_qty  = explode(':', $value);
			$charm_name_arr = explode("_", $charm_qty[0]);
			$charm_name = ($charm_name_arr[1]==1)?$charm_name_arr[1].' Year':$charm_name_arr[1].' Years';
			$charm_item[] = array(
					'type'	=> $charm_name,
					'qty'	=> $charm_qty[1],
					'name'	=> $charm_name_arr[1].'Y 5-Pack',
					'div_Id'=> $charm_name_arr[1]				
				);
		}
		//print_r($charm_item);
		$cart['serviceyear']	= $charm_item;
		$this->session->set_userdata('cart',$cart);	
		$data['serviceyear']	= $charm_item;
		$this->load->view('order/list_serviceyear',$data);
		return;
	}


	function addAccessoriesToCart() {
		$extender_qty = (int)$this->input->post('extender_qty');
		$bar_qty	= (int)$this->input->post('bar_qty');
		
		if($extender_qty + $bar_qty > 0) {
			if(isset($this->session->userdata['cart'])) {
				$cart 	= $this->session->userdata['cart'];
			} else {
				$cart = array();
			}
			
			$extender_item = array(
				'type'	=> 'Adhesive Charm Extender',
				'qty'	=> $extender_qty,
				'name'	=> '5-Pack Adhesive Charm Extender'				
			);
			
			$bar_item = array(
				'type'	=> 'Salon Magnetic Charm Bar',
				'qty'	=> $bar_qty,
				'name'	=> '5-Pack Salon Magnetic Charm Bar'
			);
			
			$accessories = array($extender_item,$bar_item);
			$cart['accessories'] = $accessories;
			
			$this->session->set_userdata('cart',$cart);			
			$data['accessories'] = $accessories;
			$this->load->view('order/list_accessories',$data);
			return;
		}
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
		$Id = $this->input->post('Id');		
		switch($type) {
			case '1':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style']	 = "Leader";
				$data['title']	 = "Leader";
				$data['license'] = 1;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '2':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style']	 = "Supervisor";
				$data['title']	 = "Supervisor";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '3':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style']	 = "Expert";
				$data['title']	 = "Expert";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '4':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style'] 	 = "general";
				$data['title']	 = "no title included";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '5':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style']	 = "optical";

                $store= $this->session->userdata["store"]->store_state;
                $state= array("AK", "AZ", "AR", "CA", "CT", "FL", "GA", "HI", "KY", "MA", "NV", "NJ", "NY", "NC", "OH", "RI", "TN", "VA", "WA");
                if(!in_array($store, $state)){
                    $data["title_options"]= array(
                        "Optician"=> "Optician",
                        "Optician Manager"=> "Optician Manager",
                        "Apprenticed Optician"=> "Apprenticed Optician",
                        "Dispensing Optician "=> "Dispensing Optician ",
                    );
                }
                else

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
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style']	 = "minor specialist";
				$data['title']	 = "specialist";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '9':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style']	 = "custom decorating";
				$data['title_options'] = array(
					'In-Home Decorator'	=> 'In-Home Decorator',
					'Installer'			=> 'Installer'
				);
				$this->load->view('order/form/additional_input_name_form',$data);
				return;				
			break;
			case '10':
				$data['number']		= $current_input_boxes_number + 1;
				$data['styleID']	= $Id;
				$data['style']		= "salon";
				$data['title']		= "no title included";
				$data['license']	= 1;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '11':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['styleID'] = $Id;
				$data['style']	 = "In-Home Window Treatments";
				$data['title_options'] = array(
					'Decorator Consultant'	=> 'Decorator Consultant',
					'Installer'			=> 'Installer'
				);
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
		}
	}
	
	function showNamesField() {
		$type	= $this->input->post('type');
		$id	= $this->input->post('Id');
		switch ($type) {
			case '1':
				$data	= array();
				$data['description']	= "Title: Leader";
				$data['styleID']		= $id;
				$data['style']			= "Leader";
				$data['title']			= "Leader";
				$data['type']			= 1;
				$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '2':
				$data	= array();
				$data['description']	= "Title: Supervisor";
				$data['styleID']		= $id;
				$data['style']			= "Supervisor";
				$data['title']			= "Supervisor";
				$data['type']			= 2;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '3':
				$data	= array();
				$data['description']	= "Title: Expert";
				$data['styleID']		= $id;
				$data['style']			= "Expert";
				$data['title']			= "Expert";
				$data['type']			= 3;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '4':
				$data	= array();
				$data['description']	= "No Titles";
				$data['styleID']		= $id;
				$data['style']			= "general";
				$data['title']			= "no title included";
				$data['type']			= 4;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '5':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['styleID']		= $id;
				$data['style']			= "optical";
				$data['type']			= 5;

                $store= $this->session->userdata["store"]->store_state;
                $state= array("AK", "AZ", "AR", "CA", "CT", "FL", "GA", "HI", "KY", "MA", "NV", "NJ", "NY", "NC", "OH", "RI", "TN", "VA", "WA");
                if(!in_array($store, $state)){
                    $data["title_options"]= array(
                        "Optician"=> "Optician",
                        "Optician Manager"=> "Optician Manager",
                        "Apprenticed Optician"=> "Apprenticed Optician",
                        "Dispensing Optician "=> "Dispensing Optician ",
                    );
                }
                else

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
				$data['styleID']		= $id;
				$this->load->view('order/form/input_names_form_generic',$data);
				break;
			case '7':
				$data	= array();
				$data['description']	= "Enter Name For Minor Badge";
				$data['styleID']		= $id;
				$data['style']			= "minor specialist";
				$data['title']			= "specialist";
				$data['type']			= 7;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '8':
				$data	= array();
				$data['styleID']		= $id;
				$this->load->view('order/form/input_names_form_minor',$data);
				break;
			case '9':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['styleID']		= $id;
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
				$data['styleID']		= $id;
				$data['style']			= "salon";
				//$data['title']			= "salon";
				$data['title']			= "no title included";
				$data['type']			= 10;
				$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '11':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge"; 
				$data['styleID']		= $id;
				$data['style']			= "In-Home Window Treatments";
				$data['type']			= 11;
				$data['title_options'] 	= array(
					'Decorator Consultant'	=> 'Decorator Consultant',
					'Installer'			=> 'Installer'
				);
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

		///// Manage extras Price
		$extras	= isset($cart['extras'])?$cart['extras']:null;		 
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners	  = 0;
		if($extras) {
			foreach($extras as $item) {
				if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
				else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
			}
		}
		///// Manage accessories Price	
		$accessories = isset($cart['accessories'])?$cart['accessories']:null;
		$total_extender_qty = 0;
		$total_bar_qty	  = 0;
		if($accessories) {
			foreach($accessories as $item) {
				if($item['type']=='Adhesive Charm Extender') $total_extender_qty += $item['qty'];
				else if($item['type']=='Salon Magnetic Charm Bar') $total_bar_qty += $item['qty'];
			}
		}	
		///// Manage service year Price
		$serviceyear = isset($cart['serviceyear'])?$cart['serviceyear']:null;
		$totalserice = 0; 
		if($serviceyear){
			foreach ($serviceyear as $key => $value) {  $totalserice+=(int)$value['qty']; }
		}
		///// Manage badges Price
		$totalAmount = 0;
		$badgesList = array();
		if($new_badges){			
			$badgesData = "";
			$k=0; 
			asort($new_badges);
			foreach ($new_badges as $key => $value) { 
					$this->db->where('item_id',(int)$value['badge_Id']);
					$query	= $this->db->get('items');
					$itemsprice	= $query->row(); 
					$totalAmount += $itemsprice->item_price;
					if($k==0){ $badgesData = $value['badge_Id']; }
						if(!isset($badgesList[$value['badge_Id']]['count'])){ $badgesList[$value['badge_Id']]['count'] = 0;}
						if($badgesData==$value['badge_Id']){
							$badgesList[$value['badge_Id']]['count'] +=1; 
							$badgesList[$value['badge_Id']]['price']=$itemsprice->item_price; 
							$badgesList[$value['badge_Id']]['name']=$value['style']; 
						}else{
							$badgesData = $value['badge_Id']; 	
							$badgesList[$value['badge_Id']]['count'] +=1; 
							$badgesList[$value['badge_Id']]['price']=$itemsprice->item_price; 
							$badgesList[$value['badge_Id']]['name']=$value['style']; 						
						}
						$k++;
			}					
		}
		$badges_List ="";
		foreach ($badgesList as $key => $bvalue) { 
			$badges_List .= "<div class='lineprice' id='badge_".$key."'><font id='total-badges-number'>".(ucfirst($bvalue['name']))." Badges </font> = <span class='badge_qty'>".$bvalue['count']."</span> x $".number_format($bvalue['price'],2)."</div>";
 		} 
		$total_order_price = number_format($totalAmount + $total_extender_qty*ACCESSORIES_EXT_PRICE + $total_bar_qty*ACCESSORIES_BAR_PRICE  + $totalserice*EACH_CHARM_PRICE + $total_magnetic_fasteners*EXTRA_MAGNETS_PRICE + $total_pin_fasteners*EXTRA_PINS_PRICE + HANDLING_CHARGE_PER_ORDER,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		/*if($last > 0){
			$last = trim($last,'0');
		}*/
		$total_price = $first.'.'.$last;
		
		$data = array(
			'total_badges'		=> $cart_total-1,
			'total_order_price' => $total_price,
			'total_badge_sum' => $totalAmount,
			'new_badges_List' => $badges_List,
			'cart_data' => empty($this->session->userdata['cart'])?true:false,
		);		 

		echo json_encode($data);		
	}
	
	function deleteServiceyear() {
		$type 	= $this->input->post('type');
		$cart	= $this->session->userdata['cart'];
		$serviceyear	= $cart['serviceyear'];
		foreach($serviceyear as $key=>$item) {
			if($item['type']==$type) {
				unset($serviceyear[$key]);
			}
		} 

		$cart 	= $this->session->userdata['cart'];
		$total_badges	= @$this->session->userdata['cart_total'];
		///// Manage extras Price
		$extras = isset($cart['extras'])?$cart['extras']:null;
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners	  = 0;
		if($extras){
			foreach($extras as $item) {
				if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
				else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
			}	
		}
		///// Manage accessories Price	
		$accessories = isset($cart['accessories'])?$cart['accessories']:null;
		$total_extender_qty = 0;
		$total_bar_qty	  = 0;
		if($accessories){
			foreach($accessories as $item) {
				if($item['type']=='Adhesive Charm Extender') $total_extender_qty += $item['qty'];
				else if($item['type']=='Salon Magnetic Charm Bar') $total_bar_qty += $item['qty'];
			}			
		}
		///// Manage service year Price
		$totalserice = 0; 
		if($serviceyear){
			foreach ($serviceyear as $key => $value) {  $totalserice+=(int)$value['qty']; }
		}	
		///// Manage badges Price					 
		$badges	= isset($cart['badges'])?$cart['badges']:null;
		$totalAmount = 0;
		if($badges){
			foreach ($badges as $key => $value) { 
							$this->db->where('item_id',(int)$value['badge_Id']);
							$query	= $this->db->get('items');
							$itemsprice	= $query->row(); 
							$totalAmount += $itemsprice->item_price;
			}					
		}	
		// calculate the order price
		$total_order_price = number_format($totalAmount + $total_extender_qty*ACCESSORIES_EXT_PRICE + $total_bar_qty*ACCESSORIES_BAR_PRICE  + $totalserice*EACH_CHARM_PRICE + $total_magnetic_fasteners*EXTRA_MAGNETS_PRICE + $total_pin_fasteners*EXTRA_PINS_PRICE + HANDLING_CHARGE_PER_ORDER,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		/*if($last > 0){
			$last = trim($last,'0');
		}*/
		$total_price = $first.'.'.$last;

		if(count($serviceyear)>0) {
			$cart['serviceyear'] = $serviceyear;
			$total_serviceyear	= count($serviceyear);
		} else {
			unset($cart['serviceyear']);
			$total_serviceyear	= 0;
		}
		$this->session->set_userdata('cart',$cart);
		$data = array(
			'removed_item'		=> $type,
			'total_serviceyear'	=> $total_serviceyear,
			'total_order_price' => $total_price, 
			'cart_data' => empty($this->session->userdata['cart'])?true:false,
		);
		echo json_encode($data);
	}

	
	function deleteAccessories() {
		$type 	= $this->input->post('type');
		$cart	= $this->session->userdata['cart'];
		$accessories	= $cart['accessories'];
		foreach($accessories as $key=>$item) {
			if($item['type']==$type) {
				unset($accessories[$key]);
			}
		}		
		$cart 	= $this->session->userdata['cart'];
		$total_badges	= @$this->session->userdata['cart_total'];
		///// Manage accessories Price	
		$total_extender_qty = 0;
		$total_bar_qty	  = 0;
		if($accessories){
			foreach($accessories as $item) {
				if($item['type']=='Adhesive Charm Extender') $total_extender_qty += $item['qty'];
				else if($item['type']=='Salon Magnetic Charm Bar') $total_bar_qty += $item['qty'];
			}
		}
		///// Manage extras Price
		$extras = isset($cart['extras'])?$cart['extras']:null;
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners	  = 0;
		if($extras){
			foreach($extras as $item) {
				if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
				else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
			}	
		}		
		///// Manage service year Price	
		$totalserice = 0;
		$serviceyear = isset($cart['serviceyear'])?$cart['serviceyear']:null;
		if($serviceyear){
			foreach ($serviceyear as $key => $value) {  $totalserice+=(int)$value['qty']; }
		}	
		///// Manage badges Price					 
		$badges	= isset($cart['badges'])?$cart['badges']:null;
		$totalAmount = 0;
		if($badges){
			foreach ($badges as $key => $value) { 
							$this->db->where('item_id',(int)$value['badge_Id']);
							$query	= $this->db->get('items');
							$itemsprice	= $query->row(); 
							$totalAmount += $itemsprice->item_price;
			}					
		}	
		// calculate the order price
		$total_order_price = number_format($totalAmount + $total_extender_qty*ACCESSORIES_EXT_PRICE + $total_bar_qty*ACCESSORIES_BAR_PRICE  + $totalserice*EACH_CHARM_PRICE + $total_magnetic_fasteners*EXTRA_MAGNETS_PRICE + $total_pin_fasteners*EXTRA_PINS_PRICE + HANDLING_CHARGE_PER_ORDER,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		/*if($last > 0){
			$last = trim($last,'0');
		}*/
		$total_price = $first.'.'.$last;
		
		if(count($accessories)>0) {
			$cart['accessories'] = $accessories;
			$total_accessories	= count($accessories);
		} else {
			unset($cart['accessories']);
			$total_accessories	= 0;
		}
		$this->session->set_userdata('cart',$cart);
		$data = array(
			'removed_item'		=> $type,
			'total_accessories'	=> $total_accessories,
			'total_order_price' => $total_price,
			'cart_data' => empty($this->session->userdata['cart'])?true:false,
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
		$cart 	= $this->session->userdata['cart'];
		$total_badges	= @$this->session->userdata['cart_total'];
		///// Manage extras Price	
		$total_magnetic_fasteners = 0;
		$total_pin_fasteners	  = 0;
		foreach($extras as $item) {
			if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
			else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
		}
		///// Manage accessories Price	
		$accessories = isset($cart['accessories'])?$cart['accessories']:null;
		$total_extender_qty = 0;
		$total_bar_qty	  = 0;
		if($accessories){
			foreach($accessories as $item) {
				if($item['type']=='Adhesive Charm Extender') $total_extender_qty += $item['qty'];
				else if($item['type']=='Salon Magnetic Charm Bar') $total_bar_qty += $item['qty'];
			}		
		}
		///// Manage service year Price	
		$totalserice = 0;
		$serviceyear = isset($cart['serviceyear'])?$cart['serviceyear']:null;
		if($serviceyear){
			foreach ($serviceyear as $key => $value) {  $totalserice+=(int)$value['qty']; }
		}	
		///// Manage badges Price					 
		$badges	= isset($cart['badges'])?$cart['badges']:null;
		$totalAmount = 0;
		if($badges){
			foreach ($badges as $key => $value) { 
							$this->db->where('item_id',(int)$value['badge_Id']);
							$query	= $this->db->get('items');
							$itemsprice	= $query->row(); 
							$totalAmount += $itemsprice->item_price;
			}					
		}	
		// calculate the order price
		$total_order_price = number_format($totalAmount + $total_extender_qty*ACCESSORIES_EXT_PRICE + $total_bar_qty*ACCESSORIES_BAR_PRICE  + $totalserice*EACH_CHARM_PRICE + $total_magnetic_fasteners*EXTRA_MAGNETS_PRICE + $total_pin_fasteners*EXTRA_PINS_PRICE + HANDLING_CHARGE_PER_ORDER,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		/*if($last > 0){
			$last = trim($last,'0');
		}*/
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
			'total_order_price' => $total_price,
			'cart_data' => empty($this->session->userdata['cart'])?true:false,
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