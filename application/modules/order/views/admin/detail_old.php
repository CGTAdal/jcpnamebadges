
<a href="<?php echo base_url();?>admin/order/ListOrder">Back</a>
<?php if(count($order)>0) {?>
	<div class="main clb">
		<div class="txtC mb-30">
			<div class="view-order">
				Order #:
				<span class="fontGL">
					<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
				</span>
				<span class="split"> </span>
				
			</div>
		</div>
		<div class="main-left fll">
			<div class="clb shipping">
				<h3 class="title">Shipping Address: </h3>
				<div class="pl-20 fontGL mb-30">
					<div>Jcp store <?php echo str_pad($order->store_id,5,'0',STR_PAD_LEFT);?></div>
					<div>ATTN:  <?php echo $shipping['attn'];?></div>
					<div><?php echo $shipping['address'];?></div>
					<div><?php echo $shipping['city'].', '.$shipping['state'].' '.$shipping['zip'];?></div>
				</div>
				<h3 class="title">Order Total:</h3>
				<div class="pl-20 fontGL mb-30">
					<div><?php echo $order->order_total; echo ($order->order_total>1)?' Badges':' Badge';?></div>
				</div>
			</div>
		</div>
		<!--END main left-->
		<div class="main-right flr">
			<div class="yourOrder">
				<h3 class="title">Your Order:</h3>
				<ul class="ul-main mb-30">
					<?php foreach($items as $c) {?>
						<li>
							<p><strong>Style:</strong><span><?php echo $c['style'];?></span></p>
							<?php if(isset($c['name'])) {?>
								<p><strong>Name:</strong><span><?php echo $c['name'];?></span></p>
							<?php }?>
							<?php if(isset($c['title'])) {?>
								<p><strong>Title:</strong><span><?php echo $c['title'];?></span></p>
							<?php }?>
							<p><strong>Fastener:</strong><span><?php echo $c['fastener'];?></span></p>
							<?php if(isset($c['spk_spanish'])) {?>
								<p><strong>Speaks Spanish:</strong><span><?php echo $c['spk_spanish'];?></span></p>
							<?php }?>
						</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<!--END main right-->
	</div>
<?php } else {?>
	<div class="main clb"><div style="padding-left:400px">No order found.</div></div>
<?php }?>
<!--END main-->
