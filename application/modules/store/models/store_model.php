<?php
class Store_Model extends General_Model {
	
	function getStoreList($filter=array()) {	
		if(isset($filter['perpage'])&&$filter['perpage']!='all') {
			$perpage	= $filter['perpage'];
			$offset 	= (isset($filter['offset']))?$filter['offset']:0;
			$this->db->limit($perpage,$offset);
		}
		if(isset($filter['search_store_unit_number'])&&$filter['search_store_unit_number']!=''){
			$this->db->like('store_number',$filter['search_store_unit_number']);
		}
		$this->db->order_by('store_id','asc');
		$query	 = $this->db->get('stores');
		$results = $query->result();
		return $results;
	}
	function getStoreTotal($filter=array()){			
		if(isset($filter['search_store_unit_number'])&&$filter['search_store_unit_number']!=''){
			$this->db->like('store_number',$filter['search_store_unit_number']);
		}		
		$query	= $this->db->get('stores');
		$total	= $query->num_rows();
		return $total;
	}
	function getStoreDetail($filter=array()) {
		if(isset($filter['store_number'])&&$filter['store_number']!="") {
			$this->db->where('store_number',$filter['store_number']);
		}
		if(isset($filter['store_id'])&&$filter['store_id']!="") {
			$this->db->where('store_id',$filter['store_id']);
		}
		$query	= $this->db->get('stores');
		$result	= $query->row();
		return $result;	
	}
	
	function edit($data,$id){
		$this->db->where('store_id',$id);
		$rs = $this->db->update('stores',$data);
		if($rs){
            return true;
         } else {
            return false;
         }
	}
   	function del($key_value=0){          
   		$this->db->where('store_id',$key_value);
        $this->db->limit(1,0);
        $this->db->delete('stores');           
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
   	}
		
}