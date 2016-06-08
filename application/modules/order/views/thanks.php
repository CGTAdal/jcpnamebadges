<?php error_reporting(0); ?>
 <div class="main clb">
	<div class="mb-40">&nbsp;</div>
	<div class="mb-30 txtC shipping">Order Number: <span class="fontGL"><?php echo $orderId;?></span></div>
	<div class="mb-30 txtC shipping fontGL">Thank you for your order.</div>
	<div class="mb-30 txtC mb-30">
	<h3 class="title">Order Total: (<?php echo ($total_badges);?> Badges)</h3>
		<?php 
		$totalAmount = 0;
		$badgesList = array();
		$badgesData = "";
		$k=0; 
		if($total_badges>0) {	
			asort($badges['badges']); 
				foreach ($badges['badges'] as $key => $value) {  
					$totalAmount += $value['badge_price'];
					if($k==0){ $badgesData = $value['badge_Id']; }
							if(!isset($badgesList[$value['badge_Id']]['count'])){ $badgesList[$value['badge_Id']]['count'] = 0;}
							if($badgesData==$value['badge_Id']){
								$badgesList[$value['badge_Id']]['count'] +=1; 
								$badgesList[$value['badge_Id']]['price']=$value['badge_price']; 
								$badgesList[$value['badge_Id']]['name']=$value['style']; 
							}else{
								$badgesData = $value['badge_Id']; 	
								$badgesList[$value['badge_Id']]['count'] +=1; 
								$badgesList[$value['badge_Id']]['price']=$value['badge_price']; 
								$badgesList[$value['badge_Id']]['name']=$value['style']; 						
							}
							$k++;
						}
						foreach ($badgesList as $key => $bvalue) {							
						?>
							<div class="lineprice" ><font id="total-badges-number"><?php echo (ucfirst($bvalue['name']));?> Badges </font> = <?php echo $bvalue['count'].' x $'.number_format($bvalue['price'],2); ?></div>
				 		<?php } ?> 
				<div class="linetop width30">Total Sum <font id="total-badges-number">=</font>   $<?php echo number_format($totalAmount,2); ?></div>
				<div class="toplinedivservice width30">&nbsp;</div>
		<?php }?>
		<!-- Extra -->
		<?php if($total_mf > 0) {?>
			<div align="center">Total 5-Pack Magnets: <?php echo $total_mf.' x $'.EXTRA_MAGNETS_PRICE;?></div>
		<?php }?>
		<?php if($total_pf > 0) {?>
			<div align="center">Total 5-Pack Pins: <?php echo $total_pf.' x $'.EXTRA_PINS_PRICE;?></div>
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
					<div class="lineprice" id="<?php echo $value['div_Id']."cService"; ?>">Total <?php echo $value['name']; ?> = <?php echo $value['qty'].' x $'.EACH_CHARM_PRICE;?></div>
		<?php $fr++; } } ?>
		<div class="lineprice" >Handling charge per order: <?php echo "$".HANDLING_CHARGE_PER_ORDER; ?></div>
		<?php 
			$tmp 	= explode('.',number_format($totalAmount + $total_ext_qty*ACCESSORIES_EXT_PRICE + $total_bar_qty*ACCESSORIES_BAR_PRICE  + $totalserice*EACH_CHARM_PRICE + $total_mf*EXTRA_MAGNETS_PRICE + $total_pf*EXTRA_PINS_PRICE + HANDLING_CHARGE_PER_ORDER,2));
			$first 	= $tmp[0];
			$last	= $tmp[1];
			/*if($last > 0){
				$last = trim($last,'0');
			}*/
			$total_price = $first.'.'.$last;					
		?>
		<div class="linetop width30" align="center">Total for order #<?php echo $orderId;?>: &nbsp;&nbsp;  $<?php echo $total_price;?></div>
	</div>
	<div class="mb-40">&nbsp;</div>
</div>