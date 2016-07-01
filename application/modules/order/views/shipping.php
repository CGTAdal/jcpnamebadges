<script src="<?php echo base_url();?>application/views/front_end/js/inputmask.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>application/views/front_end/js/jquery.inputmask.js" type="text/javascript"></script>
<div class="main clb">
	<div class="main-left fll">
		<div class="clb shipping">
			<h3 class="title">Shipping Address:</h3>
			<div class="pl-20 fontGL mb-30">
				<div>
				<?php if($store->store_number==SELECTED_STORE_NO) { ?>
					<span id="stname_value"><?php echo $new_storename;?></span> <span class="split"> </span>
					<a href="javascript:void(0);" id="change_stname_link">
						<font color="#468be9" size="-1">(Edit : Store Name)</font>
					</a>
					<div id="change_stname_box" class="displN">
					<?php echo form_input('store_name',$new_storename,'size="17" placeholder="Store Name" style="font-size:12px;margin:3px"');?>
					<input type="button" value="Change" style="font-size:12px" id="change_stname"/>
					<input type="button" value="Close" style="font-size:12px" id="close_stname_box"/>
				</div>
				<?php }else{ 
					echo "JCP Store ".$store->store_number;
					}
				?></div>

				<?php if($store->store_number==SELECTED_STORE_NO) { ?>
				<div>
					ATTN:  
					<span id="attn_value">
						<?php 
							$attnBlockCss = '';
							if(strtolower($new_attn) !== 'store leader'){
								$attnBlockCss = 'displN';
								echo $new_attn;
							}else{
								$new_attn = '';
							}
						?>
					</span>
					<span class="split"> </span>
					<?php 
						if($new_attn != ''){
					?>
					<a href="javascript:void(0);" id="change_attn_link">
						<font color="#468be9" size="-1">(Edit ATTN: Name)</font>
					</a>
					<?php 
						}else{
					?>
					<a href="javascript:void(0);" id="change_attn_link">
						<font color="#468be9" size="-1">(Add ATTN: Name)</font>
					</a>
					<?php
						}
					?>
				</div>
				<div id="change_attn_box" class="<?php echo $attnBlockCss; ?>">
					<?php 
						echo form_input('store_attn',$new_attn,'size="17" id="store_attn" placeholder="ATTN:Name" style="font-size:12px;margin:3px"');
					?>
					<input id="new_store_attn" type="hidden" value="<?php echo $new_attn; ?>" />
					<input type="button" value="Change" style="font-size:12px" id="change_attn"/>
					<?php /*?>
					<input type="button" value="Close" style="font-size:12px" id="close_attn_box"/>
					<?php */?>
				</div>	
				<?php }else{ ?>			
					<div>
						ATTN:  <span id="attn_value"><?php echo $new_attn;?></span>
						<span class="split"> </span>
						<a href="javascript:void(0);" id="change_attn_link">
							<font color="#468be9" size="-1">(Edit ATTN: Name)</font>
						</a>
					</div>
					<div id="change_attn_box" class="displN">
						<?php echo form_input('store_attn',$new_attn,'size="17" id="store_attn" placeholder="ATTN:Name" style="font-size:12px;margin:3px"');?>
						<input type="button" value="Change" style="font-size:12px" id="change_attn"/>
						<input type="button" value="Close" style="font-size:12px" id="close_attn_box"/>
					</div>
				<?php }?>
				<div><span id="add_value"><?php echo $new_add;?></span>
					<?php if($store->store_number==SELECTED_STORE_NO) { ?>
						<span class="split"> </span>
						<a href="javascript:void(0);" id="change_add_addlink">
							<font color="#468be9" size="-1">(Edit : Address)</font>
						</a>
					<?php } ?>	
				</div>
				<div><span id="addcity_value"><?php echo $new_city.', '.$new_state.' '.$new_zip;?></span></div>
				<?php if($store->store_number==SELECTED_STORE_NO) { ?>
				<div id="change_add_address" class="displN">
					<?php echo form_input('store_add',$new_add,'size="17" placeholder="Address" style="font-size:12px;margin:3px"');?>
					<?php echo form_input('store_city',$new_city,'size="17" placeholder="City" style="font-size:12px;margin:3px"');?>
					<?php echo form_input('store_state',$new_state,'size="17" placeholder="State" style="font-size:12px;margin:3px"');?>
					<?php echo form_input('store_zip',$new_zip,'size="17" placeholder="Zip" style="font-size:12px;margin:3px"');?>
					</br>					
					<input type="button" value="Change" style="font-size:12px" id="change_add"/>
					<input type="button" value="Close" style="font-size:12px" id="close_add_box"/>
				</div>
				<?php } ?>
				<?php if($store->store_number==SELECTED_STORE_NO) { ?>
					<div>Accounting String:  <span class="split"> </span>
						<a href="javascript:void(0);" id="change_aor_link">
							<font color="#468be9" size="-1">(Edit: Accounting String)</font>
						</a>
						<span id="aor_value"><?php echo $new_aor;?></span></div>
						<div id="change_add_aor" class="displN">
							<?php echo form_input('store_aor',$new_aor,'size="57" id="store_aor" placeholder="Accounting String" style="font-size:12px;margin:3px"');?>
							<input id="new_store_aor" type="hidden" value="<?php echo $new_aor; ?>" />
							<input type="button" value="Change" style="font-size:12px" id="change_aor"/>
							<?php /*?>
							<input type="button" value="Close" style="font-size:12px" id="close_aor_box"/>
							<?php */?>
						</div>	
				<?php } ?>
			</div>
			<h3 class="title">Order Total: (<span id="totalorderno"><?php echo ($total_badges);?></span> Badges)</h3>
			
			<div class="pl-20 fontGL mb-30">
				<?php 
				$totalAmount = 0;
				if($total_badges>0) {
					$badgesList = array();
					$badgesData = "";
					$k=0; 
					asort($badges);
					foreach ($badges as $key => $value) {
						$this->db->where('item_id',(int)$value['badge_Id']);
						$query	= $this->db->get('items');
						$itemsprice	= $query->row();

						$totalAmount += !empty($itemsprice->item_price)?$itemsprice->item_price:0; 
							if($k==0){ $badgesData = $value['badge_Id']; }
							if(!isset($badgesList[$value['badge_Id']]['count'])){ $badgesList[$value['badge_Id']]['count'] = 0;}
							if($badgesData==$value['badge_Id']){
								$badgesList[$value['badge_Id']]['count'] +=1; 
								$badgesList[$value['badge_Id']]['price']=!empty($itemsprice->item_price)?$itemsprice->item_price:0;  
								$badgesList[$value['badge_Id']]['name']=$value['style']; 
							}else{
								$badgesData = $value['badge_Id']; 	
								$badgesList[$value['badge_Id']]['count'] +=1; 
								$badgesList[$value['badge_Id']]['price']=!empty($itemsprice->item_price)?$itemsprice->item_price:0;  
								$badgesList[$value['badge_Id']]['name']=$value['style']; 						
							}
							$k++;	
						} ?>
						<div class="mainbadgesDiv">
						<?php foreach ($badgesList as $key => $bvalue) { ?>
							<div class="lineprice" id="<?php echo 'badge_'.$key; ?>"><font id="total-badges-number"><?php echo (ucfirst($bvalue['name']));?> Badges </font> = <?php echo '<span class="badge_qty">'.$bvalue['count'].'</span> x $'.number_format($bvalue['price'],2); ?></div>
				 		<?php } ?>
				 		</div>
				<div class="linetop badgesumamt">Total Sum  = <font id="total_badgesum"> $<?php echo number_format($totalAmount,2); ?> </font></div>
				<div class="toplinedivservice">&nbsp;</div>
				<?php }?>
				<!-- Extra -->
				<?php if($total_mf > 0) {?>
					<div  class="lineprice" id="total-magnetics">Total 5-Pack Magnets = <?php echo $total_mf.' x $'.EXTRA_MAGNETS_PRICE;?></div>
				<?php }?>
				<?php if($total_pf > 0) {?>
					<div  class="lineprice" id="total-pins">Total 5-Pack Pins = <?php echo $total_pf.' x $'.EXTRA_PINS_PRICE;?></div>
				<?php }?>
				<!-- Accessories -->
				<?php if($total_ext_qty > 0) {?>
					<div  class="lineprice" id="total-extenders">Total 5-Pack Adhesive Charm Extender = <?php echo $total_ext_qty.' x $'.ACCESSORIES_EXT_PRICE;?></div>
				<?php }?>
				<?php if($total_bar_qty > 0) {?>
					<div  class="lineprice" id="total-bars">Total 5-Pack Salon Magnetic Charm Bar = <?php echo $total_bar_qty.' x $'.ACCESSORIES_BAR_PRICE;?></div>
				<?php }?>
				<?php 
					$totalserice = 0;
					$fr=1;
					if($serviceyear>0) { 						
						foreach ($serviceyear as $key => $value) {  $totalserice+=(int)$value['qty']; ?>
							<?php //if($fr==1){ echo "<div class='toplinedivservice'>&nbsp;</div>"; } ?>
							<div class="lineprice" id="<?php echo $value['div_Id']."cService"; ?>">Total <?php echo $value['name']; ?> = <?php echo $value['qty'].' x $'.EACH_CHARM_PRICE;?></div>
				<?php $fr++; } } ?>
				<div  class="lineprice" >Handling charge per order = <?php echo "$".HANDLING_CHARGE_PER_ORDER; ?></div>
				<?php  
					$tmp 	= explode('.',number_format($totalAmount + $total_ext_qty*ACCESSORIES_EXT_PRICE + $total_bar_qty*ACCESSORIES_BAR_PRICE  + $totalserice*EACH_CHARM_PRICE + $total_mf*EXTRA_MAGNETS_PRICE + $total_pf*EXTRA_PINS_PRICE + HANDLING_CHARGE_PER_ORDER,2));
					$first 	= $tmp[0];
					$last	= $tmp[1];
					/*if($last > 0){
						$last = trim($last,'0');
					}*/
					$total_price = $first.'.'.$last;					
				?>
				<div class="linetop">Total Amount =  <font color="red" id="total-order-price"><?php echo "$".$total_price;?></font></div>
			</div>
			<div class="txtC fontGL mb-20">Please Check Your Order One Last Time!</div>
			<div class="txtC mb-20">I authorize this order (please enter your <font color="red">FULL</font> name):</div>
			<div class="txtC mb-20"><input class ="order_customer" type="text" style="font-size:16px"/></div>
			<div class="txtC">
				<input type="button" id="place_order" value="Place Order" />
			</div>
			<form action="<?php echo base_url();?>order/add" method="post" id="form_order_customer">
			</form>
		</div>
	</div>
	<!--END main left-->
	<?php
		$order_box = Modules::run('order/detailOrderBox');
		echo $order_box;
	?>
	
	<!--END main right-->
	<input type="hidden" id="store_id" value="<?php echo $store->store_id;?>" />
</div>
<!--END main-->
<script>
	$(document).ready(function(){		

		<?php if($store->store_number==SELECTED_STORE_NO) { ?>
			$('#store_attn').change(function(){
				$('#new_store_attn').val('');
			});

			$('#store_aor').change(function(){
				$('#new_store_aor').val('');
			});

			/*$('#store_attn').blur(function(){
				  if($(this).val().length < 5){
				  	 alert("AATN name atleast 5 character long.");
				  	 return false;
				  }
			});*/

			/*$('#store_attn').keypress(function(e){
		          if(this.value.length > 4 &&  e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 39){
		              return false;
		          }
		    });

		    $('#store_attn').keyup(function(e){
		      if(this.value.length > 4 &&  e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 39){
		          return false;
		      }
		    });*/
		<?php }?>

		$("#store_aor").inputmask("999.999.999999.99999.99999.999.9999.9999999999");  //static mask		
		$('#change_attn_link').click(function(){
			$('#change_attn_box').toggle();
			$("#store_attn").focus();
			$("#store_attn").select();
		});
		$('#change_attn').click(function(e){
			var new_attn = $('input[name="store_attn"]');
			var new_attn_val = new_attn.val();
			if(new_attn.val()=="" || $.trim(new_attn_val) == "") {
				alert('Please enter new ATTN');
				new_attn.focus();
				return false;
			}else if(new_attn_val.length < 5){
				alert("AATN name atleast 5 character long.");
				return false;
			}else{
				var store_id = $('#store_id').val();
				$.post('<?php echo base_url();?>store/storeajax/changeATTN',
					{new_attn: new_attn.val(), store_id: store_id},
					function(data){

						$('#attn_value').html(data);
						$('#new_store_attn').val(new_attn.val());
						$('#change_attn_box').hide();
						$('#change_attn_link font').html("(Edit ATTN: Name)");

					}
				);
			}

		});
		$('#close_attn_box').click(function(){
			$('#change_attn_box').hide();
		})		
		$('#place_order').click(function(){	
			var order_customer = $('.order_customer').val();
			
			<?php if($store->store_number==SELECTED_STORE_NO) { ?>
				var store_aor = $('#store_aor').val();
				var new_store_aor = $('#new_store_aor').val();

				var store_attn = $('#store_attn').val();
				var new_store_attn = $('#new_store_attn').val();

				if(store_attn=='' || $.trim(store_attn) == '' || store_attn=='Store Leader'){
						if($.trim(store_attn.val()) == '')
							$('#store_attn').val('');

						alert('You must enter ATTN Name','');
						return false;				
				}

				if(new_store_attn=='' || $.trim(new_store_attn) == '' || new_store_attn=='Store Leader'){
					alert('You need to update ATTN by clicking on "Change" button.');
					return false;				
				}

				if(store_aor=='' || store_aor=='000.000.000000.00000.00000.000.0000.0000000000'){
						alert('You must enter Accounting String');
						return false;				
				}

				if(new_store_aor=='' || new_store_aor=='000.000.000000.00000.00000.000.0000.0000000000'){	
					alert('You need to update Accounting String by clicking on "Change" button.');
					return false;				
				}

			<?php } ?>

			if(order_customer == '' || $.trim(order_customer) == ''){
				alert('You must enter your name into the authorization box to continue','');				
				$(".order_customer").focus();
			}else{
				var input_order_customer = "<input type='hidden' name='order_customer' value='"+order_customer+"' />";				
				$('#form_order_customer').append(input_order_customer);
				$('#form_order_customer').submit();
			}	
		});
		/* Change address for SELECTED_STORE_NO */
		$('#change_add_addlink').click(function(){
			$('#change_add_address').toggle();
		});
		$('#close_add_box').click(function(){
			$('#change_add_address').hide();
		})			
		$('#change_add').click(function(){
			var new_add = $('input[name="store_add"]');			
			var new_city = $('input[name="store_city"]');			
			var new_state = $('input[name="store_state"]');			
			var new_zip = $('input[name="store_zip"]');			
			if(new_add.val()=="") {
				alert('Please enter new Address');
				new_add.focus();
				return false;
			}
			if(new_city.val()=="") {
				alert('Please enter new City');
				new_city.focus();
				return false;
			}
			if(new_state.val()=="") {
				alert('Please enter new State');
				new_state.focus();
				return false;
			}
			if(new_zip.val()=="") {
				alert('Please enter new ZipCode');
				new_zip.focus();
				return false;
			}
			var store_id = $('#store_id').val();
			$.ajax({
			  type: "POST",
			  url: '<?php echo base_url();?>store/storeajax/changeADD',
			  data: {new_add: new_add.val(),new_city: new_city.val(),new_state: new_state.val(),new_zip: new_zip.val(), store_id: store_id},
			  dataType: "json",
			  success: function (data) { 
			  		$('#add_value').html(data.add_value);
					$('#addcity_value').html(data.addcity_value);
					$('#change_add_address').hide();	
			  }			  
			}); 			
		});
		/* Change aor for SELECTED_STORE Name */
		$('#change_stname_link').click(function(){
			$('#change_stname_box').toggle();
		});
		$('#close_stname_box').click(function(){
			$('#change_stname_box').hide();
		})
		$('#change_stname').click(function(){
			var new_storename = $('input[name="store_name"]');
			if(new_storename.val()=="") {
				alert('Please enter new Store Name');
				new_storename.focus();
				return false;
			}
			var store_id = $('#store_id').val();
			$.post(
				'<?php echo base_url();?>store/storeajax/changeSTNAME',
				{new_storename: new_storename.val(), store_id: store_id},
				function(data){
					$('#stname_value').html(data);
					$('#change_stname_box').hide();
				}
			);			
		});
		/* Change aor for SELECTED_STORE_NO */
		$('#change_aor_link').click(function(){
			$('#change_add_aor').toggle();
			$("#store_aor").focus();
			$("#store_aor").select();
		});
		$('#close_aor_box').click(function(){
			$('#change_add_aor').hide();
		})
		$('#change_aor').click(function(){
			var new_aor = $('input[name="store_aor"]');
			if(new_aor.val()=="") {
				alert('Please enter new Accounting String');
				new_attn.focus();
				return false;
			}
			var store_id = $('#store_id').val();
			$.post(
				'<?php echo base_url();?>store/storeajax/changeAOR',
				{new_aor: new_aor.val(), store_id: store_id},
				function(data){
					$('#aor_value').html(data);
					$('#new_store_aor').val(new_aor.val());
					$('#change_add_aor').hide();
				}
			);			
		});		

	// Remove cart Item in function Shipping
	$('.remove_cart_item_shipping').live('click', function (){
		var size = $('#shipping_list li').size();
		var parent = $(this).parent();
		var item_id = $('#shipping_list li').index(parent);	
		var Delconfirm =  confirm("Are you sure, You want to remove this Badge!!");
		if(Delconfirm==true){
			$.post(
				'<?php echo base_url();?>order/ajax/deleteBadge',
				{item_id: item_id},					
				function(data){
					var size = $('#shipping_list li').size();
					if(data.cart_data==true){
						window.location = '<?php echo base_url();?>order/select';
						return false;
					}else{ 				
						if(size-1 > 0){
							$('#totalorderno').html(data.total_badges);
							$('.mainbadgesDiv').html(data.new_badges_List);
							//$('#badge_'+item_id).remove();
							$('#total-order-price').html("$"+data.total_order_price);
							$('#total_badgesum').html("$"+data.total_badge_sum);
						}else{
							$('.mainbadgesDiv').html(data.new_badges_List);
							//$('#total-badges-number').parent().remove();
							$('#total-order-price').html("$"+data.total_order_price);
							$('#badge-title').remove();
							$('#shipping_list').remove();
							$('.badgesumamt').remove();	
						}
					}
					parent.remove();
				},
				'json'
			);	
		}								
	});

	$('.remove_cart_serviceyear').live('click',function(){
		var type = $(this).attr('value');
		var divId = $(this).attr('divId');
		var Delconfirm =  confirm("Are you sure, You want to remove this Year of Service!!");
		if(Delconfirm==true){
			$.post(
				"<?php echo base_url();?>order/ajax/deleteServiceyear",
				{type: type},
				function(data){
					if(data.cart_data==true){
						window.location = '<?php echo base_url();?>order/select';
						return false;
					}else{ 
						if(data.total_serviceyear=='0') {
							$('#serviceyear-title').remove();
							$('#serviceyear_list').remove();
						}
						$('#total-order-price').html("$"+data.total_order_price);
					}
				},
				'json'
			); 
			$(this).parent().remove();
			$('#'+divId+"cService").remove(); 
			return;		
		}	
	});

	$('.remove_cart_accessories').live('click',function(){
		var type = $(this).attr('value');
		var Delconfirm =  confirm("Are you sure, You want to remove this Accessories!!");
		if(Delconfirm==true){		
			$.post(
				"<?php echo base_url();?>order/ajax/deleteAccessories",
				{type: type},
				function(data){
					if(data.cart_data==true){
						window.location = '<?php echo base_url();?>order/select';
						return false;
					}else{ 
						if(data.total_accessories=='0') {
							$('#accessories-title').remove();
							$('#accessories_list').remove();
						}
						$('#total-order-price').html("$"+data.total_order_price);
					}
				},
				'json'
			); 
			$(this).parent().remove();
			if(type=='Adhesive Charm Extender') $('#total-extenders').remove();
			else if(type=='Salon Magnetic Charm Bar') $('#total-bars').remove();
			return;	
		}		
	});

	$('.remove_cart_extras').live('click',function(){
		var type = $(this).attr('value');
		var Delconfirm =  confirm("Are you sure, You want to remove this Extra!!");
		if(Delconfirm==true){	
			$.post(
				"<?php echo base_url();?>order/ajax/deleteExtras",
				{type: type},
				function(data){
					if(data.cart_data==true){
						window.location = '<?php echo base_url();?>order/select';
						return false;
					}else{ 
						if(data.total_extras=='0') {
							$('#extras-title').remove();
							$('#extras_list').remove();
						}
						$('#total-order-price').html("$"+data.total_order_price);
					}
				},
				'json'
			);		
			$(this).parent().remove();
			if(type=='magnetic fastener') $('#total-magnetics').remove();
			else if(type=='pin fastener') $('#total-pins').remove();
			return;	
		}		
	});		
	
	});

</script>