<?php 
	//display($this->session->userdata['cart']);
?>
<style>
</style>

<script>
    function isNumber(evt) {
        return true;
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>

<div class = "note">	
	<span class ="note_1">NOTE:</span> 
	<strong><span class ="note_2">Please batch your orders to avoid additional handling charges.</span></strong>
</div>
<div class="main clb">
	<div class="<?php echo (count($cart)>0)?"main-left":"main-left-no-border";?> fll" id="main-left">
		<div class="badgeStyle overH mb-15">
			<h3 class="title">Select Badge Style </h3>
			<ul class="ul-main fontGL" id="badgeStyle">
				<?php foreach($items as $item) {?>
					<?php if($item->item_minor_required && !$store_minor) continue;?>	
					<li id="item_<?php echo $item->item_id;?>_<?php echo $item->item_type?>" class="items">
						<a href="javascript:void(0)">
							<span class="badgestyle-icon ">
								<img src="<?php echo base_url().$item->item_img;?>" />
							</span>
							<span id="name_item_<?php echo $item->item_id;?>"><?php echo $item->item_name;?></span>
						</a>
					</li>
				<?php }?>
				<?php if($store_minor) {?>
					<li>
						<div style="font-size:13px;color:#888;margin-top:3px;margin-bottom:5px">
							Certain states require minors under the age of 18 years of age to wear a blue badge
						</div>
					</li>
				<?php }?>
			</ul>
			<input type="hidden" id="selected_item_id" value="<?php echo $items[0]->item_id;?>"/>
			<input type="hidden" id="selected_item_type" value="<?php echo $items[0]->item_type;?>" />
		</div>
		<div class="qty-top1">
        	<a href="javascript: void(0);" class="qty-click" id="select-charms-link">Click Here To Order Years of Service Charms</a> <img src="<?php echo base_url()?>application/views/front_end/images/charm.jpg" />
        </div>
		<div class="qty-top1">
        	<a href="javascript: void(0);" class="qty-click" id="select-extras-link">Click Here To Order Additional Fasteners</a> <img src="<?php echo base_url()?>application/views/front_end/images/qty-magnet.jpg" width="60" /> <img src="<?php echo base_url()?>application/views/front_end/images/qty-pin.jpg" width="60" />
        </div>
		<div class="qty-top">
        	<a href="javascript: void(0);" class="qty-click" id="select-accessories-link">Click Here To Order Accessories</a> <img src="<?php echo base_url()?>application/views/front_end/images/accessories.jpg" />   </div>        
        <!-- charms-boxes -->
        <div class="qty-add clb" id="charms-boxes" style="display:none">
        	<h3 class="title">Enter Charm Quantities:</h3>
            <?php for($i=0;$i<=65;){ ?>
            <div class="qty-item clb">
            	<img src="<?php echo base_url()?>application/views/front_end/images/<?php echo "Charm_";echo($i==0)?1:$i; ?>.png" />
            	<label>
            		<input type="text" id="charm-qty-<?php echo ($i==0)?1:$i; ?>" value=""/> Enter Quantity <?php echo ($i==0)?'1 Year':$i.' Years'; ?>  <div style="padding-left:120px">Pack of 5 ($6.50)</div>
            	</label>
            </div>
			<?php $i= $i+5; } ?>
            <div class="clb">&nbsp;</div>
            <div class="txtC mb-15"><input type="button" id="add_Charm" value="Add Charms to Order"></div>
        </div>
 		<!-- extras-boxes -->
        <div class="qty-add clb" id="extras-boxes" style="display:none">
        	<h3 class="title">Enter Fastener Quantities:</h3>
            <div class="qty-item clb">
            	<img src="<?php echo base_url()?>application/views/front_end/images/qty-magnet.jpg" />
            	<label>
            		<input type="text" id="extras-magnet-qty" value=""/> Enter Quantity Magnet <div style="padding-left:120px">Pack of 5 ($7.50)</div>
            	</label>
            </div>
            <div class="qty-item clb">
            	<img src="<?php echo base_url()?>application/views/front_end/images/qty-pin.jpg" />
            	<label>
            		<input type="text" id="extras-pin-qty" value=""/> Enter Quantity Pin <div style="padding-left:120px">Pack of 5 ($5.00)</div>
            	</label>
            </div>
            <div class="clb">&nbsp;</div>
            <div class="txtC mb-15"><input type="button" id="add_fasteners" value="Add Fasteners to Order"></div>
        </div>
        <!-- accessories-boxes -->
        <div class="qty-add clb" id="accessories-boxes" style="display:none">
        	<h3 class="title">Enter Accessories Quantities:</h3>
            <div class="qty-item clb">
            	<img src="<?php echo base_url()?>application/views/front_end/images/charmextender.png" />
            	<label>
            		<input type="text" id="accessories-extender-qty" value=""/> Adhesive Charm Extender <div style="padding-left:120px">Pack of 5 ($7.50)</div>
            	</label>
            </div>
            <div class="qty-item clb">
            	<img src="<?php echo base_url()?>application/views/front_end/images/magneticcharmbar.png" />
            	<label>
            		<input type="text" id="accessories-bar-qty" value=""/> Salon Magnetic Charm Bar <div style="padding-left:120px">Pack of 5 ($9.75)</div>
            	</label>
            </div>
            <div class="clb">&nbsp;</div>
            <div class="txtC mb-15"><input type="button" id="add_accessories" value="Add Accessories to Order"></div>
        </div>

		<div id="enter-names-field">
		</div>
	</div>
	<!--END main left-->
	<div class="main-right flr" style="display:<?php echo (count($cart)>0)?"block":"none";?>">		
		<div class="yourOrder" id = "your_order">		
			<h3 class="title">Your Order: </h3>			
			<div class="txtC" id="continue_shipping" style="display:<?php echo (count($cart)<=0)?'none':'block';?>">
				<input type="button" name="" value="Continue to Shipping" />
			</div><br>
			<h3 class="title no-border" id="badge-title" style="display:<?php echo (isset($cart['badges']))?"block":"none"?>">Badges:</h3>
			<ul class="ul-main mb-30" id="badge_list">
				<?php if(isset($cart['badges'])) {?>
					<?php foreach($cart['badges'] as $badge) {?>
						<li>
							<p><strong>Style:</strong><span><?php echo $badge['style'];?></span></p>
							<?php if(isset($badge['name'])) {?>
								<p><strong >Name:</strong><span><?php echo $badge['name'];?></span></p>
							<?php }?>
							<?php if(isset($badge['license'])) {?>
								<p><strong>License #:</strong><span><?php echo $badge['license'];?></span></p>
							<?php }?>
							<?php if(isset($badge['title'])) {?>
								<p><strong>Title:</strong><span><?php echo $badge['title'];?></span></p>
							<?php }?>
							<p><strong>Fastener:</strong><span><?php echo $badge['fastener'];?></span></p>
							<?php if(isset($badge['spk_spanish']) && $badge['spk_spanish']!='') {?>
								<p><strong>Hablo Espanol:</strong><span><?php echo $badge['spk_spanish'];?></span></p>							
							<?php }?>
                            <?php if(isset($badge['hearing_impaired']) && $badge['hearing_impaired']!='') {?>
                                <p><strong>Hearing Impaired:</strong><span><?php echo $badge['hearing_impaired'];?></span></p>
                            <?php }?>
                            <?php if(isset($badge['dasl']) && $badge['dasl']!='') {?>
                                <p><strong>Deaf-ASL:</strong><span><?php echo $badge['dasl'];?></span></p>
                            <?php }?>
							<a href="javascript:void(0);" class="remove_cart_badge">Remove</a>
						</li>
					<?php }?>
				<?php }?>
			</ul>
			<!-- Extras -->
			<h3 class="title no-border" id="extras-title" style="display:<?php echo isset($cart['extras'])?"block":"none";?>">Extras:</h3>		
			<ul class="ul-main mb-30" id="extras_list">
				<?php if(isset($cart['extras'])) { ?>
					<?php foreach($cart['extras'] as $item) {?>
						<?php if($item['qty']>0) {?>
							<li>
								<p><strong>Item:</strong><span><?php echo $item['name']?></span></p>
								<p><strong>Quantity:</strong><span><?php echo $item['qty']?></span></p>
								<a href="javascript:void(0);" class="remove_cart_extras" value="<?php echo $item['type'];?>">Remove</a>
							</li>
						<?php }?>
					<?php }?>
				<?php }?>	
			</ul>
			<!-- Accessories -->
			<h3 class="title no-border" id="accessories-title" style="display:<?php echo isset($cart['accessories'])?"block":"none";?>">Accessories:</h3>		
			<ul class="ul-main mb-30" id="accessories_list">
				<?php if(isset($cart['accessories'])) { ?>
					<?php foreach($cart['accessories'] as $item) {?>
						<?php if($item['qty']>0) {?>
							<li>
								<p><strong>Item:</strong><span><?php echo $item['name']?></span></p>
								<p><strong>Quantity:</strong><span><?php echo $item['qty']?></span></p>
								<a href="javascript:void(0);" class="remove_cart_accessories" value="<?php echo $item['type'];?>">Remove</a>
							</li>
						<?php }?>
					<?php }?>
				<?php }?>	
			</ul>			
			<!-- Years of Service -->
			<h3 class="title no-border" id="serviceyear-title" style="display:<?php echo isset($cart['serviceyear'])?"block":"none";?>">Years of Service:</h3>		
			<ul class="ul-main mb-30" id="serviceyear_list">
				<?php if(isset($cart['serviceyear'])) { ?>
					<?php foreach($cart['serviceyear'] as $item) {?>
						<?php if($item['qty']>0) {?>
							<li>
								<p><strong>Item:</strong><span><?php echo $item['name']?></span></p>
								<p><strong>Quantity:</strong><span><?php echo $item['qty']?></span></p>
								<a href="javascript:void(0);" class="remove_cart_serviceyear" divId="<?php echo $item['div_Id']; ?>" value="<?php echo $item['type'];?>">Remove</a>
							</li>
						<?php }?>
					<?php }?>
				<?php }?>	
			</ul>

			<div class ="txt_remove" >
				<a id="empty-cart" href="javascript:void(0);">Click Here To Clear Entire Order</a>
			</div>
			<div class="txtC" id="continue_shipping_two" style="display:<?php echo (count($cart)<=0)?'none':'block';?>"><input type="button" name="" value="Continue to Shipping" /></div>
		</div>
	</div>
	<!--END main right-->
</div>
<script>
	$(document).ready(function(){
		// add more name
		$('.add-another').live('click',function(){			
			var current_input_boxes_number = $('#current_input_boxes_number').val();			
			var type = $(this).attr('value');
			var Id = $(this).attr('badgeID');			
			$.post(
				'<?php echo base_url();?>order/ajax/addInputBox',
				{current_input_boxes_number: current_input_boxes_number, type: type, Id:Id},
				function(data) {
					$("#input_boxes").append(data);
					$("#current_input_boxes_number").val(parseInt(current_input_boxes_number) + 1);
				}
			);
		});
		
		// convert first name to lower case
		$('.first_name').live('blur',function(){
            var text = $(this).val();
            text = text.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
			$(this).val(text);
		});

		// change field input-names
		$(".items").click(function(){
			$('.items').removeClass('badgeStyleActive');
			$(this).addClass('badgeStyleActive');
			$('#extras-boxes').hide();
			$('#accessories-boxes').hide();
			$('#charms-boxes').hide();			
			var item	= $(this).attr('id');
			item 		= item.split('_');
			var id		= item[1];
			var type 	= item[2];
			$.post(
				"<?php echo base_url();?>order/ajax/showNamesField",
				{type: type,Id: id},
				function(data) {
					$("#enter-names-field").html(data);
				}		
			);
			return;
		})

		// add badges to confirm box
		$('#add_names').live('click',function(){	
			var i = 0;
			var j = 0;
			var k = 0;
			$('.input_box').each(function(){
				var box_id		= $(this).attr('value');								
				var style		= $('#style_'+box_id).val();
				var badges_id	= $('#styleID_'+box_id).val();
				///alert(badges_id);
				var name		= $('input[name=first_name_'+box_id+']').val();
				var license		= $('input[name=license_'+box_id+']').val();

				if(name != '' && box_id >= j){
					i=0;
					j=0;
					var title		= $('#title_'+box_id).val();
					var fastener 	= $("input[name=fastener_"+box_id+"]:checked").val();
					var spk_spanish	= $("input[name=speaks_spanish_"+box_id+"]:checked").val();
                    var h_i      	= $("input[name=hearing_impaired_"+box_id+"]:checked").val();
					var dasl_i		= $("input[name=deaf_ASL_"+box_id+"]:checked").val();
					var new_value	= '<div class="orderConfirm mb-30">';
					new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span><span class="badge_ID hide">'+badges_id+'</span></p>';
					new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
					new_value		+= '<p><strong>Title:</strong><span class="badge_title">'+title+'</span></p>';
					if(license!=undefined) {
						new_value		+= '<p><strong>License #:</strong><span class="badge_license">'+license+'</span></p>';
					}
					//console.log(dasl_i);
					new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
                    if(spk_spanish=='Yes') {
					    new_value		+= '<p><strong>Hablo Espanol:</strong><span class="badge_spk_spanish">'+spk_spanish+'</span></p>';
                        new_value		+= '<span class="badge_hearing_impaired"></span><span class="badge_deaf_asl"></span>';
                    } else if(h_i=='Yes') {
                        new_value		+= '<p><strong>Hearing Impaired:</strong><span class="badge_hearing_impaired">'+h_i+'</span></p>';
                        new_value		+= '<span class="badge_spk_spanish"></span><span class="badge_deaf_asl"></span>';
                    }else if(dasl_i=='Yes') {
                        new_value		+= '<p><strong>Deaf-ASL:</strong><span class="badge_deaf_asl">'+dasl_i+'</span></p>';
                        new_value		+= '<span class="badge_spk_spanish"></span><span class="badge_hearing_impaired"></span>';
                    }
                    new_value       += '</div>';
					$('#popup_values').append(new_value);

					if(style=='optical' && license!="") {
						k++;
					}			
				}
				
				if(name == ''){
					i++;
					j=box_id;
					alert('Please enter first name only for badge: '+box_id);						
					$('input[name=first_name_'+box_id+']').focus();					
					return false;
				}
			});
			
			if(i==0){		
				$(".overlay").height($(document).height());
				$('#popup').show();
				$("#confirm_cancel").click(function(){
					$('.orderConfirm').remove();
					$('#popup').hide();
				});
			}
						
		});
		
		$('#add_generic_names').live('click',function(){
			var count_magnetic 	= 0;
			var count_pin		= 0;
			$('.generic_magnetic_quantity').each(function(){
				var style	 = "generic (no name)";
				var badges_id = $('#styleID_1').val();
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Magnetic";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span><span class="badge_ID hide">'+badges_id+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_magnetic += quantity;
				}
			});
			$('.generic_pin_quantity').each(function(){
				var style	 = "generic (no name)";
				var badges_id = $('#styleID_1').val();
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Pin";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span><span class="badge_ID hide">'+badges_id+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_pin += quantity;
				}
			});
			if(count_magnetic + count_pin > 0) {
				$(".overlay").height($(document).height());
				$('#popup').show();
				$("#confirm_cancel").click(function(){
					$('.orderConfirm').remove();
					$('#popup').hide();
				});
			} else {
				alert('Please enter numeric value');
			}
		});
		
		$('#add_minor_names').live('click',function(){
			var count_magnetic 	= 0;
			var count_pin		= 0;
			$('.minor_magnetic_quantity').each(function(){
				var style	 = "minor generic (no name)";
				var badges_id = $('#styleID_1').val();
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Magnetic";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span><span class="badge_ID hide">'+badges_id+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_magnetic += quantity;
				}
			});
			$('.minor_pin_quantity').each(function(){
				var style	 = "minor generic (no name)";
				var badges_id = $('#styleID_1').val();
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Pin";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span><span class="badge_ID hide">'+badges_id+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_pin += quantity;
				}
			});
			if(count_magnetic + count_pin > 0) {
				$(".overlay").height($(document).height());
				$('#popup').show();
				$("#confirm_cancel").click(function(){
					$('.orderConfirm').remove();
					$('#popup').hide();
				});
			} else {
				alert('Please enter numeric value');
			}
		});
		
		$("#proceed").live('click',function(){
			var order_Id 			= new Array();
			var order_style 		= new Array();
			var order_name 			= new Array();
			var order_title			= new Array();
			var order_license		= new Array();
			var order_fastener 		= new Array();
			var order_spk_spanish 	= new Array();
            var order_hi            = new Array();
            var order_dasl			= new Array();	
			$('.orderConfirm').each(function(){
				var badge_ID	= $('.badge_ID',$(this)).html();
				var style		= $('.badge_style',$(this)).html();
				var name		= $('.badge_name',$(this)).html();
				var title		= $('.badge_title',$(this)).html();
				var license		= $('.badge_license',$(this)).html();
				var fastener	= $('.badge_fastener',$(this)).html();
				var spk_spanish	= $('.badge_spk_spanish',$(this)).html();
                var hi	        = $('.badge_hearing_impaired',$(this)).html();
                var dasl		= $('.badge_deaf_asl',$(this)).html();
                
				order_style.push(style);
				order_Id.push(badge_ID);
				if(license!=null) {
					order_license.push(license);
				}
				order_name.push(name);
				if(title!=null) {
					order_title.push(title);
				}
				order_fastener.push(fastener);
				order_spk_spanish.push(spk_spanish);
				order_hi.push(hi);
                order_dasl.push(dasl);                
			});
			$.post(
				"<?php echo base_url();?>order/ajax/addBadgesToCart",
				{badge_Id:order_Id,styles:order_style, names: order_name,titles: order_title, licenses: order_license, fasteners: order_fastener, spk_spanish: order_spk_spanish, hearing_impaired: order_hi , dasl:order_dasl},
				function(data) {
					$('#badge_list').append(data);
					$('#badge-title').show();
					$('#main-left').removeClass('main-left-no-border');
					$('#main-left').addClass('main-left');

					$('#your_order').show();
					$('#continue_shipping').show();
					$('#continue_shipping_two').show();
					$('.main-right').show();
					$('.orderConfirm').remove();
					$('#popup').hide();
				}
			);
			
		});
		
		$('#continue_shipping').click(function(){
			window.location="<?php echo base_url();?>order/shipping";
		});	

		$('#continue_shipping_two').click(function(){
			window.location="<?php echo base_url();?>order/shipping";
		});
		//reomove orders
		$('.remove_cart_badge').live('click', function (){
			var parent = $(this).parent();
			var item_id = $('#badge_list li').index(parent);
			var Delconfirm =  confirm("Are you sure, You want to remove this Badge!!");
			if(Delconfirm==true){			
				$.post(
					'<?php echo base_url();?>order/ajax/deleteBadge',
					{item_id: item_id},					
					function(){
						var size = $('#badge_list li').size();
						if(size == 1){
							window.location.href = '<?php echo base_url();?>order/select';
						}
						parent.remove();
					}
				);
			}									
		});

		$('.remove_input_box').live('click',function(){
			var current_input_boxes_number = $('#current_input_boxes_number').val();
			current_input_boxes_number = current_input_boxes_number-1;
			$('#current_input_boxes_number').val(current_input_boxes_number);
			$(this).parent().parent().remove();			
			var i = 1;
			$(".input_box").each(function(){
				if(i!=1) {
					var h3 = jQuery(this).find("h3");
					h3.html('Badge '+i+' <a href="javascript: void(0)" class="remove_input_box">(remove)</a>');
				}
				i++;
			});
		});
		
		// Clears all Orders 
		$('#empty-cart').live('click',function(){
			$(".overlay").height($(document).height());
			$('#popup2').show();
		});
		
		// Confirm Clears Orders
		$('#confirm_delete_cart').live('click',function(){	
			var parent = $('.remove_cart_item').parent();		
			$.post(
				"<?php echo base_url();?>order/ajax/deleteCart",
				"",
				function(data){
					window.location.href = '<?php echo base_url();?>order/select';
				}
			);
		});
		
		$('#cancel_delete_cart').live('click',function(){
			$('#popup2').hide();
		});
		
		$('#select-charms-link').click(function(){
			$('#extras-boxes').hide();
			$('#accessories-boxes').hide();
			$('#charms-boxes').toggle();
			$('.items').removeClass('badgeStyleActive');
			$('#enter-names-field').html('');
		})

		$('#select-extras-link').click(function(){
			$('#charms-boxes').hide();
			$('#accessories-boxes').hide();
			$('#extras-boxes').toggle();
			$('.items').removeClass('badgeStyleActive');
			$('#enter-names-field').html('');
		});

		$('#select-accessories-link').click(function(){
			$('#charms-boxes').hide();
			$('#extras-boxes').hide();
			$('#accessories-boxes').toggle();
			$('.items').removeClass('badgeStyleActive');
			$('#enter-names-field').html('');
		});


		$('#add_Charm').click(function(){
			var charm_qty = '';
			var filldata = false;
			var msg = "";
			var postdata = "";
			for(var i=0; i<=65;){
				if(i==0){ var k = 1; msg ="1 Year"; }else{ var k = i; msg =i+" Years";}
				var charm_qty 	= ($('#charm-qty-'+k).val());
				if(charm_qty!=''){
					filldata=true;
					postdata += 'charmqty_'+k+':'+charm_qty+',';
				} 
				if((charm_qty!="" && isNaN(parseInt(charm_qty)))) {
					alert('Please enter numeric value for '+msg);
					return;
				} 
				if((charm_qty=="0" && isNaN(parseInt(charm_qty))) || (charm_qty=="0")) {
					alert('Charm quantity must greater than zero in '+msg);
					return;
				}
			 i = i+5;	
			}
			if(filldata == false) {
				alert('Please enter charm quantity');
				return; 
			}
			postdata = postdata.substr(0, postdata.length-1);			 			
			$.post(
				"<?php echo base_url();?>order/ajax/addYearsToCart",
				{postdata: postdata},
				function(data) {
					$('#serviceyear_list').html(data);
					$('#serviceyear-title').show();
					$('#main-left').removeClass('main-left-no-border');
					$('#main-left').addClass('main-left');

					$('#your_order').show();
					$('#continue_shipping').show();
					$('#continue_shipping_two').show();
					$('.main-right').show();
				}
			);
		});

		$('#add_accessories').click(function(){
			var accessories_extender_qty 	= ($('#accessories-extender-qty').val());
			var accessories_bar_qty 		= ($('#accessories-bar-qty').val());

			if(accessories_extender_qty == "" && accessories_bar_qty == "") {
				alert('Please enter quantity Charm Extender or quantity Magnetic Charm Bar');
				return; 
			}
			if((accessories_extender_qty!="" && isNaN(parseInt(accessories_extender_qty))) || (accessories_bar_qty!=""&&isNaN(parseInt(accessories_bar_qty)))) {
				alert('Please enter numeric value');
				return;
			} 
			if((accessories_bar_qty=="0" && isNaN(parseInt(accessories_extender_qty))) || (accessories_extender_qty=="0"&&isNaN(parseInt(accessories_bar_qty))) || (accessories_extender_qty=="0" && accessories_bar_qty=="0")) {
				alert('Accessories quantity must greater than zero');
				return;
			}
			$.post(
				"<?php echo base_url();?>order/ajax/addAccessoriesToCart",
				{extender_qty: accessories_extender_qty, bar_qty: accessories_bar_qty},
				function(data) {
					$('#accessories_list').html(data);
					$('#accessories-title').show();
					$('#main-left').removeClass('main-left-no-border');
					$('#main-left').addClass('main-left');

					$('#your_order').show();
					$('#continue_shipping').show();
					$('#continue_shipping_two').show();
					$('.main-right').show();
				}
			);
		});

		$('#add_fasteners').click(function(){
			var extras_magnet_qty 	= ($('#extras-magnet-qty').val());
			var extras_pin_qty 		= ($('#extras-pin-qty').val());

			if(extras_magnet_qty == "" && extras_pin_qty == "") {
				alert('Please enter quantity magnet or quantity pin');
				return; 
			}
			if((extras_magnet_qty!="" && isNaN(parseInt(extras_magnet_qty))) || (extras_pin_qty!=""&&isNaN(parseInt(extras_pin_qty)))) {
				alert('Please enter numeric value');
				return;
			} 
			if((extras_pin_qty=="0" && isNaN(parseInt(extras_magnet_qty))) || (extras_magnet_qty=="0"&&isNaN(parseInt(extras_pin_qty))) || (extras_magnet_qty=="0"&&extras_pin_qty=="0")) {
				alert('Fastener quantity must greater than zero');
				return;
			}
			$.post(
				"<?php echo base_url();?>order/ajax/addExtrasToCart",
				{magnet_qty: extras_magnet_qty, pin_qty: extras_pin_qty},
				function(data) {
					$('#extras_list').html(data);
					$('#extras-title').show();
					$('#main-left').removeClass('main-left-no-border');
					$('#main-left').addClass('main-left');

					$('#your_order').show();
					$('#continue_shipping').show();
					$('#continue_shipping_two').show();
					$('.main-right').show();
				}
			);
		});

		$('.remove_cart_serviceyear').live('click',function(){
			var type = $(this).attr('value');
			var Delconfirm =  confirm("Are you sure, You want to remove this Year of Service!!");
			if(Delconfirm==true){			
				$.post(
					"<?php echo base_url();?>order/ajax/deleteServiceyear",
					{type: type},
					function(data){
						// code here
						if(data.total_serviceyear=='0') {
							window.location.href = '<?php echo base_url();?>order/select';
						}
					},
					'json'
				);
				$(this).parent().remove();
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
						// code here
						if(data.total_accessories=='0') {
							window.location.href = '<?php echo base_url();?>order/select';
						}
					},
					'json'
				);
				$(this).parent().remove();
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
						// code here
						if(data.total_extras=='0') {
							window.location.href = '<?php echo base_url();?>order/select';
						}
					},
					'json'
				);
				$(this).parent().remove();
				return;	
			}		
		});
		
		$('.license-optical').live('keyup',function(){
			if($(this).val()!="") {
				$('.speaks_spanish_yes',$(this).parent().parent()).prop('checked',false); 
				$('.speaks_spanish_no',$(this).parent().parent()).prop('checked',true);
				$('.speaks_spanish_yes',$(this).parent().parent()).prop('disabled',true);
			} else {
				$('.speaks_spanish_yes',$(this).parent().parent()).prop('disabled',false);
			}
			
		});

        $('.spkspnsh_yes').live('click',function(){
            $(this).parent().parent().parent().find('.hi_yes').attr('checked',false);
            $(this).parent().parent().parent().find('.dasl_yes').attr('checked',false);
            $(this).parent().parent().parent().find('.hi_no').attr('checked',true);
            $(this).parent().parent().parent().find('.dasl_no').attr('checked',true);
        });

        $('.hi_yes').live('click',function(){
            $(this).parent().parent().parent().find('.spkspnsh_yes').attr('checked',false);
            $(this).parent().parent().parent().find('.dasl_yes').attr('checked',false);
            $(this).parent().parent().parent().find('.spkspnsh_no').attr('checked',true);
            $(this).parent().parent().parent().find('.dasl_no').attr('checked',true);
        });

		$('.dasl_yes').live('click',function(){
            $(this).parent().parent().parent().find('.hi_yes').attr('checked',false);
            $(this).parent().parent().parent().find('.spkspnsh_yes').attr('checked',false);
            $(this).parent().parent().parent().find('.hi_no').attr('checked',true);
            $(this).parent().parent().parent().find('.spkspnsh_no').attr('checked',true);
        });


	});
</script>