<?php
	error_reporting(0);
	$current_method = $this->uri->segment(2);
?>
<div style="min-height: 300px;" class="portlet x12">		
	<div class="portlet-header">
		<h4><?php if($current_method=='order'){?>Order Detail<?php }else{?>Process Order Detail<?php }?></h4>
	</div> <!-- .portlet-header -->
			<div class="portlet-content">
			<?php if(count($order)>0){?>
				<?php if($current_method=='process'){?>	
					<div class="buttonrow" align="center">					
						<input type="button" class="btn <?php echo ($order->order_shipdate > 0)?"btn-green no-pointer":"btn-grey process-order"; ?>" value="<?php echo ($order->order_shipdate>0)?"Order Processed":"Process Order"?>" >
						<br><br>
						<?php if($order->order_shipdate > 0){?>
							<label style="font-size:16px">Order Processed by: <?php echo $order->order_process;?></label>
						<?php }?>					
					</div>			
				<?php }?>
				
				<h1>Shipping Address:</h1>			
					<div class="pl-20 fontGL mb-30">
						<div>
							<?php 
								$badgeshipping	= @unserialize($order->order_shipping); 
								//print_r($badgeshipping['store_name']);
								echo ($badgeshipping['store_name']!="")?$badgeshipping['store_name']:"JCP Store ".str_pad($order->store_number,5,'0',STR_PAD_LEFT);
							?>
						</div>
						<div>ATTN:  <?php echo ($shipping['attn']!='')?$shipping['attn']:'';?></div>
						<div><?php echo $shipping['address'];?></div>
						<div><?php echo $shipping['city'].', '.$shipping['state'].' '.$shipping['zip'];?></div>
					</div>
					<br>
					<h3 class="title">Order Placed By: <?php echo ($order->order_customer!='')?$order->order_customer:'';?></h3>
					<br>
					<h2 class="title">Order Total:</h2>
					<div class="pl-20 fontGL mb-30">
						<?php if($order->order_total>0) {?>
							<div><?php echo $order->order_total; echo ($order->order_total>1)?' Badges':' Badge';?></div>
						<?php }?>
						<?php if($order->order_mf_qty>0) {?>
							<div><?php echo $order->order_mf_qty; echo ($order->order_mf_qty>1)?' Magnet Packs of 5':' Magnet Pack of 5';?></div>
						<?php }?>
						<?php if($order->order_pf_qty>0) {?>
							<div><?php echo $order->order_pf_qty; echo ($order->order_pf_qty>1)?' Pin Packs of 5':' Pin Pack of 5';?></div>
						<?php }?>
						<?php if($order->order_extender_qty>0) {?>
							<div><?php echo $order->order_extender_qty; echo ($order->order_extender_qty>1)?' Adhesive Charm Extender Packs of 5':' Adhesive Charm Extender Pack of 5';?></div>
						<?php }?>
						<?php if($order->order_bar_qty>0) {?>
							<div><?php echo $order->order_bar_qty; echo ($order->order_bar_qty>1)?' Salon Magnetic Charm Bar Packs of 5':' Salon Magnetic Charm Bar Pack of 5';?></div>
						<?php }?>
						<?php if(!empty($serviceyear)) {
							foreach ($serviceyear as $key => $value) { ?>
							<div><?php echo $value['qty']." ".$value['name']; ?></div>
						<?php } } ?>

					</div><br><br>
					
				<?php if($current_method=='process'){?>
				<div class="buttonrow" align="center" style="float:right;margin-right:30px">
					<a href="<?php echo base_url();?>admin/process/exportTotext/<?php echo $order->order_id;?>"><input type="button" class="btn btn-grey" value="Export to text"></a>
				</div>
				<?php }?>
				<?php }?>
				<h1><?php echo ($current_method=='process')?'Ordered Badges:':'Your Order:'?></h1>
				<table cellspacing="0" cellpadding="0" border="0">	
					<thead>
						<tr>
							<th>Style</th>
							<th>Name</th>
							<th>License #</th>
							<th>Title</th>
							<th>Fastener</th>
							<th class="price" align="left">Hablo Espanol</th>
                            <th class="price" align="left">Hearing Impaired</th>
                            <th class="price" align="left">Deaf-ASL</th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($badges)&& ($badges)>0) {?>							
							<?php $i=0; foreach($badges as $badge){?>
								<tr>						
									<td><?php if(isset($badge['style'])) {echo $badge['style'];}else{}?></td>			
									<td><?php if(isset($badge['name'])){echo $badge['name'];}else{}?></td>
									<td><?php if(isset($badge['license'])){echo $badge['license'];}else{}?></td>
									<td><?php if(isset($badge['title'])){echo $badge['title'];}else{}?></td>
									<td class="price"><?php if(isset($badge['fastener'])){echo $badge['fastener'];}else{}?></td>
									<td class="total" ><?php if(isset($badge['spk_spanish'])){echo $badge['spk_spanish'];}else{}?></td>
                                    <td class="total" ><?php if(isset($badge['hearing_impaired'])){echo $badge['hearing_impaired'];}else{}?></td>
								 	<td class="total" ><?php if(isset($badge['dasl'])){echo $badge['dasl'];}else{}?></td>								</tr>
							<?php $i++;}?>
						<?php } else {?>
							<tr>
								<td colspan="7" align="center">No badge</td>
							</tr>
						<?php }?>
					</tbody>
					
				</table>				
	</div> <!-- .portlet-content -->	
	<?php if($current_method=='process'&& count($order)>0){?>	
		<form action="<?php echo base_url();?>admin/process/detail/<?php echo $order->order_id;?>" method="post" id="process_detail_form">
		</form>
	<?php }?>
	
</div>
<div id="dialog" title="Tracking Number">
	<div id="content_dialog"></div>
</div>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	$(document).ready(function(){
		$('.process-order').click(function(){
			$('#dialog').dialog();
			var new_value = '<p>Tracking Number: <input type="text" name="tracking_number" id="tracking_number">';
			new_value += '<div id="error_msg" style="color:red;"></div></p>';
			new_value += '<p><input type="button" onclick="ok_tracking();" value="OK" class="btn btn-grey">&nbsp;&nbsp;&nbsp;<input type="button" onclick="cancel_tracking();" value="Cancel" class="btn btn-grey"></p>';
			$('#content_dialog').html(new_value);
//			var check_process = $(this).attr('value');			
//			var input_process = "<input type='hidden' name='process' value='1'/>"; 		
//			$('#process_detail_form').append(input_process);
//			$('#process_detail_form').submit();
		});
	});

	function ok_tracking() {
		var tracking_number = $('#tracking_number').val();
		if(tracking_number == '') {
			msg = 'Tracking Number is required';	
			$('#tracking_number').focus();
			$('#error_msg').html(msg);
			return false;		
		} else {
			var check_process = $(this).attr('value');			
			var input_process = "<input type='hidden' name='process' value='1'/>"; 		
			input_process += "<input type='hidden' name='trk_number' value='"+tracking_number+"'>";
			$('#process_detail_form').append(input_process);
			$('#process_detail_form').submit();
		}
	}
	
	function cancel_tracking() {
		$('#dialog').dialog('close');
	}
</script>