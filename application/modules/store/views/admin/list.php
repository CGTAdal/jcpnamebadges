<div style="min-height: 300px; padding-bottom:20px" class="portlet x12">
	<div class="portlet-header">
		<h4>Store list
			<div class="buttonrow" style="float:right; margin-right:20px;">
				<a href="<?php echo base_url();?>admin/store/add"><input type="button" value="Add a new Store"  class="btn btn-orange" ></a>
			</div>
		</h4>
	</div> <!-- .portlet-header -->
	<div class="portlet-content">	
	<div style="margin-bottom:10px">
			<div class="portlet-content form">							
				<div class="field">
					<label for="fname">Unit # </label>
					<input type="text" class="medium" size="12" name="fname" id="search_store_unit_number" value="<?php echo ($search_store_unit_number!="")?$search_store_unit_number:"";?>">
				</div>				
				<div class="buttonrow">
					<input type="button" value="filter" id="submit_store_list" class="btn btn-small" >
				</div>
			</div>			
		</div>		
		<table cellpadding="0" cellspacing="0" align="center">
			<thead>
				<tr>					
					<th >Express Account #</th>
					<th >Ground Account #</th>
					<th >JCPenney Location</th>
					<th >Unit #</th>
					<th >Location name</th>
					<th >Address 1</th>
					<th >Address 2</th>
					<th >City</th>
					<th >State</th>
					<th >Zip</th>
					<th >Contact</th>
					<th >Phone</th>
					<th >Email</th>
					<th >SVG</th>
					<th >AOR</th>
					<th >MINOR</th>
					<th style="text-align:right" >Action</th>
				</tr>
			</thead>	
			<?php if(count($stores)>0){?>	
				<?php foreach($stores as $store){?>	
					<tr>
						<td ><?php echo $store->store_express;?></td>
						<td ><?php echo $store->store_ground;?></td>
						<td ><?php echo $store->store_location;?></td>
						<td >
							<a href="<?php echo base_url();?>admin/store/detail/<?php echo $store->store_id;?>"><?php echo $store->store_number;?></a>
						</td>
						<td><?php echo $store->store_location_name;?></td>
						<td style="width:76px"><?php echo $store->store_address;?></td>
						<td style="width:76px"><?php echo $store->store_address_2;?></td>
						<td ><?php echo $store->store_city;?></td>
						<td ><?php echo $store->store_state;?></td>
						<td ><?php echo $store->store_zip;?></td>
						<td ><?php echo $store->store_contact;?></td>
						<td ><?php echo $store->store_phone;?></td>
						<td ><?php echo $store->store_email;?></td>
						<td ><?php echo $store->store_svg;?></td>
						<td ><?php echo $store->store_aor;?></td>
						<td ><?php echo ($store->store_minor==1)?'Yes':'No';?></td>
						<td align="right" style="width:60px">
							<a href="<?php echo base_url();?>admin/store/edit/<?php echo $store->store_id;?>">edit</a>
							<a href="" onclick="del_store(<?php echo $store->store_id?>)">delete</a>
						</td>
					</tr>	
				<?php }?>
			<?php }else{?>			
				<tr class="fontGL row0">
					<td colspan="3">No Store</td>
				</tr>
				<?php }?>
		</table>
		<div style="float:right;">
			Number item on perpage
			<select class="select_perpage_list_store">
				<option value="12" <?php echo ($select_perpage==12)?'selected':'';?>>12</option>
				<option value="18" <?php echo ($select_perpage==18)?'selected':'';?>>18</option>
				<option value="24" <?php echo ($select_perpage==24)?'selected':'';?>>24</option>
				<option value="30" <?php echo ($select_perpage==30)?'selected':'';?>>30</option>
				<option value="36" <?php echo ($select_perpage==36)?'selected':'';?>>36</option>
				<option value="42" <?php echo ($select_perpage==42)?'selected':'';?>>42</option>
				<option value="48" <?php echo ($select_perpage==48)?'selected':'';?>>48</option>
				<option value="all" <?php echo ($select_perpage=='all')?'selected':'';?>>All</option>
			</select>
			<?php echo $pagination;?>
		</div>		
	</div> <!-- .portlet-content -->
	<form action="<?php echo base_url();?>admin/store/liststores" method="post" id="list_stores_form">
	</form>
</div>
<!--END main-->
<script>
$(document).ready(function(){
	$('#submit_store_list').click(function(){
		var search_store_unit_number = $('#search_store_unit_number').val();		
		var input_search_store_number = "<input type='hidden' name='search_store_unit_number' value='"+search_store_unit_number+"'/>";
		$('#list_stores_form').append(input_search_store_number);
		$('#list_stores_form').submit();		
	});
	$('.select_perpage_list_store').bind('change', function(event){
	 	var perpage = $(this + "option:selected").val();
		var select_perpage	= "<input type='hidden' name='perpage' value='"+perpage+"' />";				
		$('#list_stores_form').append(select_perpage);
		$('#list_stores_form').submit();
	});
});
function del_store(id){
	var store_del = confirm("Are you ready delete?");	
	if(store_del==true){
		window.location="<?php echo base_url();?>admin/store/del/"+id;
	}else{
		return false;
	}		
}
</script>