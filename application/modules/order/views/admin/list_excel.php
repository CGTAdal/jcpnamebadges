<table cellpadding="10" cellspacing="0" align="center">
	<thead>
		<tr>
			<th>Order Date</th>
			<th>Order #</th>
			<th >Unit #</th>
			<th>Ship Date</th>
			<th>AOR</th>
			<!--<th>Item</th>-->
			<!--<th>Badge Quantity</th>-->
			<th>JCPenney Name Badge</th>
			<th>Generic (No Name)</th>
			<th>Optical</th>
			<th>Salon</th>	
			<th>In-Home Window Treatments</th>	
			<th>5-Pack Magnets</th>
			<th>5-Pack Pins</th>
			<th>5-Pack Adhesive Charm Extender</th>
			<th>5-Pack Salon Magnetic Charm Bar</th>
			<?php for($i=0;$i<=65;){ ?>
				<th><?php echo ($i==0)?1:$i; ?>Y 5-Pack</th>	
			<?php $i= $i+5; } ?>
			<th>Badge Cost</th>
			<th>Handling</th>		
			<th >Total</th>
			<th style="text-align:right">Net Cost</th>
			<th>Tracking Number</th>
		</tr>
	</thead>
	<?php if(count($orders)>0) {?>
		<?php $i=0;foreach($orders as $order) {?>
			<tr>
				<td>
					<?php echo date('m/d/Y',$order->order_date);?>
				</td>
				<td>
					<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
				</td>
				<td><?php echo $order->store_number;?></td>
				<td><?php echo ($order->order_shipdate==0)?'pending':date('m/d/Y',$order->order_shipdate);?></td>
				<td><?php 
					$badgeshipping	= @unserialize($order->order_shipping); 
					echo isset($badgeshipping['aor'])?$badgeshipping['aor']:$order->store_aor;
					?></td>
				<!--<td>Name Badges</td>-->
				<?php 
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
						
						?>		
						<td> <?php if(isset($badgesList['4'])){ echo $badgesList['4']['count'];  }else{ echo "0"; } ?></td>
						<td> <?php if(isset($badgesList['6'])){ echo $badgesList['6']['count'];  }else{ echo "0"; }  ?></td>
						<td> <?php if(isset($badgesList['5'])){ echo $badgesList['5']['count'];  }else{ echo "0"; }  ?></td>
						<td> <?php if(isset($badgesList['10'])){ echo $badgesList['10']['count'];  }else{ echo "0"; }  ?></td> 							
						<td> <?php if(isset($badgesList['11'])){ echo $badgesList['11']['count'];  }else{ echo "0"; }  ?></td> 							
						<!--<td>
							<?php //echo $order->order_total?>
						</td>--> 
				<td>
					<?php echo $order->order_mf_qty?>
				</td>
				<td>
					<?php echo $order->order_pf_qty?>
				</td>
				<td>
					<?php echo $order->order_extender_qty?>
				</td>
				<td>
					<?php echo $order->order_bar_qty?>
				</td> 
				<?php 
					$badges	= @unserialize($order->order_items); 
					$serviceyear = (isset($badges['serviceyear']))?$badges['serviceyear']:Null;
					$k =0; 
					for($i=0;$i<=65;){  ?>
					<td>
					<?php  //print_r($serviceyear[$k]);
						if(!empty($serviceyear) && @$serviceyear[$k]['div_Id']==($i==0)?1:$i){
					 		echo isset($serviceyear[$k]['qty'])?$serviceyear[$k]['qty']:0;								 
						}else{
							echo "0";
						} 
						$i= $i+5;
						$k++; ?>
					</td>
					<?php } ?>  
				<td ><?php
						$totalAmount = 0;
						$totalserice = 0;								
						if(isset($badges['badges'])){ 
							foreach ($badges['badges'] as $key => $value) {  
								$totalAmount += isset($value['badge_price'])?$value['badge_price']:DEFAULT_BADGES_PRICE;
							}
						}
					if($totalAmount==0){ $totalAmount = $order->order_total*DEFAULT_BADGES_PRICE; }
					if(!empty($serviceyear)){
						foreach ($serviceyear as $key => $value) {  $totalserice+=(int)$value['qty']; }
					} 	
					echo number_format( $totalAmount + $totalserice*EACH_CHARM_PRICE + $order->order_extender_qty*ACCESSORIES_EXT_PRICE + $order->order_bar_qty*ACCESSORIES_BAR_PRICE + $order->order_mf_qty*EXTRA_MAGNETS_PRICE + $order->order_pf_qty*EXTRA_PINS_PRICE, 2);?>
				</td>
				<td><?php echo HANDLING_CHARGE_PER_ORDER; ?></td>
				<td>
					<?php echo number_format($totalAmount + $totalserice*EACH_CHARM_PRICE + $order->order_extender_qty*ACCESSORIES_EXT_PRICE + $order->order_bar_qty*ACCESSORIES_BAR_PRICE + $order->order_mf_qty*EXTRA_MAGNETS_PRICE + $order->order_pf_qty*EXTRA_PINS_PRICE +HANDLING_CHARGE_PER_ORDER,2);?>
				</td>
				<td align="center">
					<?php echo number_format(number_format($order->order_total*BADGES_NET_PRICE + $totalserice*CHARMS_NET_PRICE + $order->order_extender_qty*ACCESSORIES_EXT_NET_PRICE + $order->order_bar_qty*ACCESSORIES_BAR_NET_PRICE + $order->order_mf_qty*EXTRA_MAGNETS_NET_PRICE + $order->order_pf_qty*EXTRA_PINS_NET_PRICE, 2)+3.00,2);?>
				</td>
				<td>
					<?php echo (isset($order->tracking_number) && $order->tracking_number !='') ? '<a target="_blank" href="https://www.google.com/#q='.$order->tracking_number.'">Track Order</a>' : '';?>
				</td>
			</tr>
		<?php $i++;}?>
	<?php } else {?>
		<tr class="fontGL row0">
			<td colspan="3">No order</td>
		</tr>				
	<?php }?>
</table>