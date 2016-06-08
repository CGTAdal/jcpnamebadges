<div style="min-height: 300px;" class="portlet x12">
	<div class="portlet-header"><h4>Edit Store</h4></div>			
		<div class="portlet-content" >		
			<form class="form label-inline" id="form_store_edit" method="post" action="<?php echo base_url();?>admin/store/edit">
				<div class="field">
					<label for="fname" >Express Account # </label> 
					<input type="text" class="medium" size="50" name="fname" id="store_express" value="<?php echo (isset($store->store_express))?$store->store_express:"";?>">
				</div>	
				<div class="field">
					<label for="fname" >Ground Account # </label> 
					<input type="text" class="medium" size="50" name="fname" id="store_ground" value="<?php echo (isset($store->store_ground))?$store->store_ground:"";?>">
				</div>	
				<div class="field">
					<label for="fname" >JCPenney Location </label> 
					<input type="text" class="medium" size="50" name="fname" id="store_location" value="<?php echo (isset($store->store_location))?$store->store_location:"";?>">
				</div>
				<div class="field">
					<label for="fname" >Location name</label> 
					<input type="text" class="medium" size="50" name="fname" id="store_location_name" value="<?php echo (isset($store->store_location_name))?$store->store_location_name:"";?>">
				</div>				
				<div class="field">
					<label for="fname">Address 1</label> 
					<input type="text" class="medium" size="50" name="fname" id="store_address" value="<?php echo (isset($store->store_address))?$store->store_address:"";?>">
				</div>
				<div class="field">
					<label for="fname">Address 2</label> 
					<input type="text" class="medium" size="50" name="fname" id="store_address_2" value="<?php echo (isset($store->store_address_2))?$store->store_address_2:"";?>">
				</div>
				<div class="field">
					<label for="lname">City </label> 
					<input type="text" class="medium" size="50" name="lname" id="store_city" value="<?php echo (isset($store->store_city))?$store->store_city:"";?>">
				</div>					
				<div class="field">
					<label for="address1">State </label> 
					<input type="text" class="large" size="50" id="store_state" value="<?php echo (isset($store->store_state))?$store->store_state:"";?>">
				</div>
				<div class="field">
					<label for="address2">Zip </label> 
					<input type="text" class="large" size="50" id="store_zip" value="<?php echo (isset($store->store_zip))?$store->store_zip:"";?>">
				</div>				
				<div class="field">
					<label for="address2">Contact </label> 
					<input type="text" class="large" size="50" id="store_contact" value="<?php echo (isset($store->store_contact))?$store->store_contact:"";?>">
				</div>				
				<div class="field">
					<label for="address2">Phone </label> 
					<?php						 
						$data = array(
								'name'	=> "store_phone",
								'id'	=> "store_phone",
								'value'	=> (isset($store->store_phone))?$store->store_phone:"",
								'class' => 'medium',
								'size'	=> '50'
							);
						echo form_input($data);						
						echo ($error_phone!="")?"<p>".$error_phone."</p>":"";
					?>
				</div>				
				<div class="field">
					<label for="address2">Email </label> 
					<?php						 
						$data = array(
								'name'	=> "store_email",
								'id'	=> "store_email",
								'value'	=>  (isset($store->store_email))?$store->store_email:"",
								'class' => 'medium',
								'size'	=> '50'
							);
						echo form_input($data);						
						echo ($error_email!="")?"<p>".$error_email."</p>":"";
					?>
				</div>				
				<div class="field">
					<label for="address2">SVG </label> 
					<input type="text" class="large" size="50" id="store_svg" value="<?php echo (isset($store->store_svg))?$store->store_svg:"";?>">
				</div>		
				<div class="field">
					<label for="address2">AOR </label> 
					<input type="text" class="large" size="50" id="store_aor" value="<?php echo (isset($store->store_aor))?$store->store_aor:"";?>">
				</div>	
				<div class="field">
					<label for="address2">Minor</label>					
						<input type="radio" value="1" name="minor" <?php echo (isset($store->store_minor)&&$store->store_minor==1)?'checked="checked"':'';?>>Yes
						<input type="radio" value="0" name="minor" <?php echo (isset($store->store_minor)&&$store->store_minor==0||!isset($store->store_minor))?'checked="checked"':'';?>>No										
				</div>	
				<br>
				<div class="field"><?php echo ($error_full!="")?"<p>".$error_full."</p>":"";?></div>
				<input type="hidden" name="store_id" id="store_id" value="<?php echo (isset($store->store_id))?$store->store_id:"";?>">				
				<div class="buttonrow" align="center">
					<button class="btn btn-apply" value="applly">Apply</button>
					<button class="btn btn-orange" value="Save">Save</button>
					<input type="button" class="btn btn-grey" id="Cancel" value="Cancel">					
				</div>
		</form>
		<br><br>		
	</div>
</div>
<script>
$(document).ready(function(){
	$('.btn-grey').live('click',function(){				
		 parent.history.back();
	     return false;
	})
	$('.btn').click(function(){
		var button_type 	= $(this).attr('value');
		var store_express = $('#store_express').val();
		var store_ground = $('#store_ground').val();
		var store_location = $('#store_location').val();
		var store_number = $('#store_number').val();
		var store_location_name = $('#store_location_name').val();
		var store_address = $('#store_address').val();
		var store_address_2 = $('#store_address_2').val();
		var store_city = $('#store_city').val();
		var store_state = $('#store_state').val();
		var store_zip = $('#store_zip').val();
		var store_contact = $('#store_contact').val();
		var store_phone = $('#store_phone').val();	
		var store_email = $('#store_email').val();
		var store_svg = $('#store_svg').val();
		var store_aor = $('#store_aor').val();
		var store_minor 	= $("input[name=minor]:checked").val();		
		var input_button_type = "<input type='hidden' name='button_edit' value='"+button_type+"' />";
		var input_store_express = "<input type='hidden' name='store_express' value='"+store_express+"' />";
		var input_store_ground = "<input type='hidden' name='store_ground' value='"+store_ground+"' />";
		var input_store_location = "<input type='hidden' name='store_location' value='"+store_location+"' />";
		var input_store_number = "<input type='hidden' name='store_number' value='"+store_number+"' />";
		var input_store_location_name = "<input type='hidden' name='store_location_name' value='"+store_location_name+"' />";
		var input_store_address_2 = "<input type='hidden' name='store_address_2' value='"+store_address_2+"' />";
		var input_store_address = "<input type='hidden' name='store_address' value='"+store_address+"' />";
		var input_store_city = "<input type='hidden' name='store_city' value='"+store_city+"' />";
		var input_store_state = "<input type='hidden' name='store_state' value='"+store_state+"' />";
		var input_store_zip = "<input type='hidden' name='store_zip' value='"+store_zip+"' />";
		var input_store_contact = "<input type='hidden' name='store_contact' value='"+store_contact+"' />";
		var input_store_phone = "<input type='hidden' name='store_phone' value='"+store_phone+"' />";
		var input_store_email = "<input type='hidden' name='store_email' value='"+store_email+"' />";
		var input_store_svg = "<input type='hidden' name='store_svg' value='"+store_svg+"' />";
		var input_store_aor = "<input type='hidden' name='store_aor' value='"+store_aor+"' />";
		var input_store_minor = "<input type='hidden' name='store_minor' value='"+store_minor+"' />";	
		$('#form_store_edit').append(input_store_minor);	
		$('#form_store_edit').append(input_button_type);		
		$('#form_store_edit').append(input_store_express);
		$('#form_store_edit').append(input_store_ground);
		$('#form_store_edit').append(input_store_location);
		$('#form_store_edit').append(input_store_number);
		$('#form_store_edit').append(input_store_location_name);
		$('#form_store_edit').append(input_store_address_2);
		$('#form_store_edit').append(input_store_address);
		$('#form_store_edit').append(input_store_city);
		$('#form_store_edit').append(input_store_state);
		$('#form_store_edit').append(input_store_zip);
		$('#form_store_edit').append(input_store_contact);
		$('#form_store_edit').append(input_store_phone);
		$('#form_store_edit').append(input_store_email);
		$('#form_store_edit').append(input_store_svg);
		$('#form_store_edit').append(input_store_aor);		
		$('#form_store_edit').submit();		
	});	
});

</script>