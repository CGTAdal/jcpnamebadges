<?php if(count($order)>0) {?>
	<div class="main clb">
		<div class="txtC mb-30">
			<div class="view-order">
				Order #:
				<span class="fontGL">
					<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
				</span>
				<span class="split"> </span>
				Order Date: <span class="fontGL"><?php echo date('n/j/Y',$order->order_date);?></span>
			</div>
		</div>
		<div class="main-left fll">
			<div class="clb shipping">
				<h3 class="title">Shipping Address: </h3>
				<div class="pl-20 fontGL mb-30">					
					<div>
					<?php 
						$badgeshipping	= @unserialize($order->order_shipping); 
						echo isset($badgeshipping['store_name'])?$badgeshipping['store_name']:"JCP Store ".str_pad($order->store_number,5,'0',STR_PAD_LEFT);
					?>
					</div>
					<div>ATTN:  <?php echo $shipping['attn'];?></div>
					<div><?php echo $shipping['address'];?></div>
					<div><?php echo $shipping['city'].', '.$shipping['state'].' '.$shipping['zip'];?></div>
				</div>
				<h3 class="title">Order Placed By: <?php echo ($order->order_customer!='')?$order->order_customer:'';?></h3>
				<h3 class="title">Order Total: (<?php echo $order->order_total." Badges"; ?>)</h3>
				<div class="pl-20 fontGL mb-30">
					<?php 
				$totalAmount = 0; 
				$badgesData = unserialize($order->order_items);
				$badges = (!empty($badgesData['badges']))?$badgesData['badges']:Null; 
				if($total_badges>0) {
					$badgesList = array();
					$badgesItem = "";
					$k=0; 
					asort($badges); 
					foreach ($badges as $key => $value) { 
						$totalAmount += isset($value['badge_price'])?$value['badge_price']:DEFAULT_BADGES_PRICE;  
							if($k==0){ $badgesItem = isset($value['badge_Id'])?$value['badge_Id']:''; }
							if(!isset($badgesList[@$value['badge_Id']]['count'])){ $badgesList[@$value['badge_Id']]['count'] = 0;}
							if($badgesItem==@$value['badge_Id']){
								$badgesList[@$value['badge_Id']]['count'] +=1; 
								$badgesList[@$value['badge_Id']]['price']=isset($value['badge_price'])?$value['badge_price']:DEFAULT_BADGES_PRICE; 
								$badgesList[@$value['badge_Id']]['name']=isset($value['style'])?$value['style']:''; 
							}else{
								$badgesItem = @$value['badge_Id']; 	
								$badgesList[@$value['badge_Id']]['count'] +=1; 
								$badgesList[@$value['badge_Id']]['price']=isset($value['badge_price'])?$value['badge_price']:DEFAULT_BADGES_PRICE; 
								$badgesList[@$value['badge_Id']]['name']=isset($value['style'])?$value['style']:''; 						
							}
							$k++;	
						} 
						foreach ($badgesList as $key => $bvalue) {							
						?>
							<div class="lineprice" id="<?php echo 'badge_'.$key; ?>"><font id="total-badges-number"><?php echo (ucfirst($bvalue['name']));?> Badges </font> = <?php echo $bvalue['count'].' x $'.number_format($bvalue['price'],2); ?></div>
				 		<?php } ?>
					<div class="linetop badgesumamt">Total Sum  = <font id="total_badgesum"> $<?php echo number_format($totalAmount,2); ?> </font></div>
					<div class="toplinedivservice">&nbsp;</div>
					<?php }?> 
					<!-- Extra -->
					<?php if($total_mf > 0) {?>
						<div class="lineprice">Total 5-Pack Magnets = <?php echo $total_mf.' x $7.50';?></div>
					<?php }?>
					<?php if($total_pf > 0) {?>
						<div class="lineprice">Total 5-Pack Pins = <?php echo $total_pf.' x $5.00';?></div>
					<?php } ?>
					<!-- Accessories -->
					<?php if($total_ext_qty > 0) {?>
						<div  class="lineprice" id="total-extenders">Total 5-Pack Adhesive Charm Extender = <?php echo $total_ext_qty.' x $'.ACCESSORIES_EXT_PRICE;?></div>
					<?php }?>
					<?php if($total_bar_qty > 0) {?>
						<div  class="lineprice" id="total-bars">Total 5-Pack Salon Magnetic Charm Bar = <?php echo $total_bar_qty.' x $'.ACCESSORIES_BAR_PRICE;?></div>
					<?php }?>
					<?php $serviceyear = (!empty($badgesData['serviceyear']))?$badgesData['serviceyear']:Null; 
						 
						$totalserice = 0;
						$fr=1;
						if($serviceyear>0) { 						
							foreach ($serviceyear as $key => $value) {  $totalserice+=(int)$value['qty']; ?>
								<div class="lineprice" id="<?php echo $value['div_Id']."cService"; ?>">Total <?php echo $value['name']; ?> = <?php echo $value['qty'].' x $6.50';?></div>
						<?php $fr++; } } ?>
					<div class="lineprice">Handling charge per order = <?php echo "$"; echo isset($badgesData['handling_charge'])?$badgesData['handling_charge']:HANDLING_CHARGE_PER_ORDER; ?></div>
					<?php 
						$handling_amount = isset($badgesData['handling_charge'])?$badgesData['handling_charge']:HANDLING_CHARGE_PER_ORDER;
						$tmp 	= explode('.',number_format($totalAmount + $total_ext_qty*ACCESSORIES_EXT_PRICE + $total_bar_qty*ACCESSORIES_BAR_PRICE + $totalserice*EACH_CHARM_PRICE + $total_mf*EXTRA_MAGNETS_PRICE + $total_pf*EXTRA_PINS_PRICE + $handling_amount,2));
						$first 	= $tmp[0];
						$last	= $tmp[1];
						/*if($last > 0){
							$last = trim($last,'0');
						}*/
						$total_price = $first.'.'.$last;
					?>
					<div class="linetop">Total Amount =  <font color="red" id="total-order-price"><?php echo "$".$total_price;?></font></div>
				</div>
			</div>
		</div>
		<!--END main left-->
		<?php
			$order_box = Modules::run('order/detailOrderBox');
			echo $order_box; 
		?>
		<!--END main right-->
	</div>
<?php } else {?>
	<div class="main clb"><div style="padding-left:400px">No order found.</div></div>
<?php }?>
<!--END main-->