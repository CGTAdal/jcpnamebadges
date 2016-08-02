<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include(APPPATH.'libraries/PHPExcel/PHPExcel.php');
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
		$this->excelExport($data['orders']);
		exit;
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

	function excelExport($orders)
	{
		// echo '<pre>';print_r($orders);
		$objPHPExcel = new PHPExcel();		

		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Order Date')
            ->setCellValue('B1', 'Order #')
            ->setCellValue('C1', 'Unit #')
            ->setCellValue('D1', 'Ship Date')
            ->setCellValue('E1', 'AOR')
            ->setCellValue('F1', 'JCPenney Name Badge')
            ->setCellValue('G1', 'Generic (No Name)')
            ->setCellValue('H1', 'Optical')
            ->setCellValue('I1', 'Salon')
            ->setCellValue('J1', 'In-Home Window Treatments')
            ->setCellValue('K1', '5-Pack Magnets')
            ->setCellValue('L1', '5-Pack Pins') 
            ->setCellValue('M1', '5-Pack Adhesive Charm Extender')
            ->setCellValue('N1', '5-Pack Salon Magnetic Charm Bar');

		$row_number  = 'O';            
		for($i=0;$i<=65;){
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.'1',(($i==0) ? 1 : $i).' Y 5-Pack');				
			$i= $i+5; 
			$row_number++;
		}   

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.'1', 'Badge Cost'); 
        $row_number++;
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.'1', 'Handling');
        $row_number++;
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.'1', 'Total');		
        $row_number++;	

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.'1', 'Net Cost'); 
        $row_number++;
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.'1', 'Tracking Number');		
        $row_number++;

		$styleArray = array(
	    'font'  => array(
	        'size'  => 10,
	        'name'  => 'Liberation Serif',
	    ),
			'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

		$objPHPExcel->getActiveSheet()->getStyle('1:1')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('1:1')->applyFromArray($styleArray);		                                                      

		$objPHPExcel->getActiveSheet()->setTitle('JCP-Output');	          

		if(count($orders)>0) {
		$i=0;
		$row_count=2;
			foreach($orders as $order) {
				$badgeshipping	= @unserialize($order->order_shipping); 

				$badges	= @unserialize($order->order_items); 
				$badgesdatalist = (isset($badges['badges']))?$badges['badges']:Null;
				$badgesData = "";
				$k=0;
				$badgesList = array();
				if($badgesdatalist){
					asort($badgesdatalist);
					foreach($badgesdatalist as $key => $value ){ 
						if($k==0){ $badgesData = @$value['badge_Id']; }							
						if(!isset($badgesList[@$value['badge_Id']]['count'])){ $badgesList[@$value['badge_Id']]['count'] = 0;}
						if($badgesData==@$value['badge_Id']){
							$badgesList[@$value['badge_Id']]['bid'] = @$value['badge_Id'];	
							$badgesList[@$value['badge_Id']]['count'] +=1; 
							$badgesList[@$value['badge_Id']]['name']=$value['style']; 
						}else{
							$badgesData = @$value['badge_Id']; 
							$badgesList[@$value['badge_Id']]['bid'] = @$value['badge_Id'];	
							$badgesList[@$value['badge_Id']]['count'] +=1; 
							$badgesList[@$value['badge_Id']]['name']=$value['style']; 						
						}
						$k++;
					}
				}		
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row_count, date('m/d/Y',$order->order_date))
					->setCellValue('B'.$row_count, str_pad($order->order_id,6,'0',STR_PAD_LEFT))
					->setCellValue('C'.$row_count, $order->store_number)
					->setCellValue('D'.$row_count, ($order->order_shipdate==0) ? 'pending' : date('m/d/Y',$order->order_shipdate))
					->setCellValue('E'.$row_count, isset($badgeshipping['aor'])?$badgeshipping['aor']:$order->store_aor)
					->setCellValue('F'.$row_count, isset($badgesList['4']) ? $badgesList['4']['count'] : "0" )
					->setCellValue('G'.$row_count, isset($badgesList['6']) ? $badgesList['6']['count'] : "0" )
					->setCellValue('H'.$row_count, isset($badgesList['5']) ? $badgesList['5']['count'] : "0" )
					->setCellValue('I'.$row_count, isset($badgesList['10']) ? $badgesList['10']['count'] : "0" )
					->setCellValue('J'.$row_count, isset($badgesList['11']) ? $badgesList['11']['count'] : "0" )
					->setCellValue('K'.$row_count, $order->order_mf_qty)
					->setCellValue('L'.$row_count, $order->order_pf_qty)
					->setCellValue('M'.$row_count, $order->order_extender_qty)
					->setCellValue('N'.$row_count, $order->order_bar_qty);
					
				$badges	= @unserialize($order->order_items); 
				$serviceyear = (isset($badges['serviceyear']))?$badges['serviceyear']:Null;
				
				$k =0; 
				$row_number  = 'O'; 			
				for($i=0;$i<=65;)
				{
					if(!empty($serviceyear) && @$serviceyear[$k]['div_Id']==($i==0)?1:$i)
					{
				 		$data_str =  isset($serviceyear[$k]['qty'])?$serviceyear[$k]['qty']:0;							 
					}else
					{
						$data_str = "0";
					} 
					
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.$row_count,$data_str);					
					
					$i= $i+5;
					
					$row_number++;
					$k++;
				}

				$totalAmount = 0;
				$totalserice = 0;								
				if(isset($badges['badges'])){ 
					foreach ($badges['badges'] as $key => $value) {  
						$totalAmount += isset($value['badge_price'])?$value['badge_price']:DEFAULT_BADGES_PRICE;
					}
				}
				if($totalAmount==0){ $totalAmount = $order->order_total*DEFAULT_BADGES_PRICE; }
				if(!empty($serviceyear)){
					foreach ($serviceyear as $key => $value) {  
						$totalserice+=(int)$value['qty']; 
					}
				} 
				
				$data_str = number_format( $totalAmount + $totalserice*EACH_CHARM_PRICE + $order->order_extender_qty*ACCESSORIES_EXT_PRICE + $order->order_bar_qty*ACCESSORIES_BAR_PRICE + $order->order_mf_qty*EXTRA_MAGNETS_PRICE + $order->order_pf_qty*EXTRA_PINS_PRICE, 2);					
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.$row_count,$data_str);
				$row_number++;

				$data_str = HANDLING_CHARGE_PER_ORDER;
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.$row_count,$data_str);
				$row_number++;
				
				$data_str = number_format($totalAmount + $totalserice*EACH_CHARM_PRICE + $order->order_extender_qty*ACCESSORIES_EXT_PRICE + $order->order_bar_qty*ACCESSORIES_BAR_PRICE + $order->order_mf_qty*EXTRA_MAGNETS_PRICE + $order->order_pf_qty*EXTRA_PINS_PRICE +HANDLING_CHARGE_PER_ORDER,2);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.$row_count,$data_str);
				$row_number++;
				
				$data_str = number_format(number_format($order->order_total*BADGES_NET_PRICE + $totalserice*CHARMS_NET_PRICE + $order->order_extender_qty*ACCESSORIES_EXT_NET_PRICE + $order->order_bar_qty*ACCESSORIES_BAR_NET_PRICE + $order->order_mf_qty*EXTRA_MAGNETS_NET_PRICE + $order->order_pf_qty*EXTRA_PINS_NET_PRICE, 2)+3.00,2);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.$row_count,$data_str);
				$row_number++;
				
				$data_str = (isset($order->tracking_number) && $order->tracking_number !='') ? '<a target="_blank" href="https://www.google.com/#q='.$order->tracking_number.'">Track Order</a>' : '';
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($row_number.$row_count,$data_str);												

				$objPHPExcel->getActiveSheet()->getStyle("$row_count:$row_count")->applyFromArray($styleArray);	

				$row_count++;
				$i++;

			}
		}
		else
		{
			$objPHPExcel->getActiveSheet()->getStyle('2:2')->applyFromArray($styleArray);				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'No Order')	;		
		}
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="JCP-Output.xlsx"');
		header('Cache-Control: max-age=0');

		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;               
	}

}