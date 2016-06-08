<div class="header fontGL clb">
	<div class="clb mb-20 logo">
		<a href="<?php echo base_url();?>order/select"><img src="<?php echo base_url();?>application/views/front_end/images/jcp.png" width="260" class="jcp fll" /></a>
		<a href="<?php echo base_url();?>order/select"><img src="<?php echo base_url();?>application/views/front_end/images/namebadge.png" class="namebadge" /></a>
	</div>
	<div class="clb">
		<div class="fll">
			Unit: <strong><?php echo $store->store_number;?></strong><span class="split">&nbsp;</span>		
			<a href="<?php echo base_url();?>order/listorders" class="txtB">View Previous Orders</a>
			<span class="split">&nbsp;</span>
			<a href="<?php echo base_url();?>instructions" class="txtB">Instructions</a>
			<span class="split">&nbsp;</span>
			<a href="<?php echo base_url();?>order/select" class="txtB">Order Badges</a>
		</div>
		<div class="flr">(<a href="<?php echo base_url();?>store/logout">Logout</a>)</div>
	</div>
</div>
