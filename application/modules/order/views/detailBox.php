<div class="main-right flr">
		<div class="yourOrder">
			<h3 class="title">Your Order:</h3>
			<h3 class="title no-border" id="badge-title" style="display:<?php echo (isset($cart['badges']))?"block":"none"?>">Badges:</h3>
			<ul class="ul-main mb-30" id = "shipping_list">
				<?php //print_r($cart);
					$badges = false;
					if(!isset($cart['badges']) && !isset($cart['extras']) && !isset($cart['serviceyear']) && !isset($cart['accessories']) && !isset($cart['handling_charge'])) {
						$badges = $cart;
					} else $badges = isset($cart['badges'])?$cart['badges']:false;
				?>
				<?php  if($badges) {?>
					<?php foreach($badges as $badge) {?>
						<li>
							<p><strong>Style:</strong><span><?php echo $badge['style'];?></span></p>
							<?php if(isset($badge['name'])) {?>
								<p><strong>Name:</strong><span><?php echo $badge['name'];?></span></p>
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
							<?php if($remove_cart == "shipping"){?>
							<a href="javascript:void(0);" class="remove_cart_item_shipping">Remove</a>
							<?php }?>
						</li>
					<?php }?>
				<?php }?>
			</ul>
			<!-- Extras -->
			<h3 class="title no-border" id="extras-title" style="display:<?php echo isset($cart['extras'])?"block":"none";?>">Extras:</h3>
			<ul class="ul-main mb-30" id="extras_list">
				<?php if(isset($cart['extras'])) {?>
					<?php foreach($cart['extras'] as $item) {?>
						<?php if($item['qty']>0) {?>
							<li>
								<p><strong>Item:</strong><span><?php echo isset($item['name'])?$item['name']:' -- '; ?></span></p>
								<p><strong>Quantity:</strong><span><?php echo $item['qty']?></span></p>
								<?php if($remove_cart == "shipping"){?>
									<a href="javascript:void(0);" class="remove_cart_extras" value="<?php echo $item['type'];?>">Remove</a>
								<?php }?>
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
								<?php if($remove_cart == "shipping"){?>
								<a href="javascript:void(0);" class="remove_cart_accessories" value="<?php echo $item['type'];?>">Remove</a>
								<?php }?>
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
								<?php if($remove_cart == "shipping"){?>
									<a href="javascript:void(0);" class="remove_cart_serviceyear" divId="<?php echo $item['div_Id']; ?>"  value="<?php echo $item['type'];?>">Remove</a>
								<?php }?>
							</li>
						<?php }?>
					<?php }?>
				<?php }?>	
			</ul>
		</div>
</div>
