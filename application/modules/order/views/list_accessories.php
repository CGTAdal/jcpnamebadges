<?php foreach($accessories as $item) {?>
	<?php if($item['qty']>0) {?>
		<li>
			<p><strong>Item:</strong><span><?php echo $item['name']?></span></p>
			<p><strong>Quantity:</strong><span><?php echo $item['qty']?></span></p>
			<a href="javascript:void(0);" class="remove_cart_accessories" value="<?php echo $item['type'];?>">Remove</a>
		</li>
	<?php }?>
<?php }?>
