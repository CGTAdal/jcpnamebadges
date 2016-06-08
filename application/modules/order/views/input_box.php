<?php if($type!=2) {?>
	<div class="order-box clb input_box additional_box" value="<?php echo $number;?>">
		<h3>Badge <?php echo $number;?> <a class="remove_input_box" href="javascript: void(0)">(remove)</a></h3>
		<div style="padding-left:15px;">
			<label>
				<span>First name:</span>
				<input type="text" class="first_name" size="50" value="" name="first_name_<?php echo $number;?>" id="acpro_inp2">				
			</label>
			<div>
				<label class="lblRadioCheckbox">
					<input type="radio" value="Magnetic" name="fastener_<?php echo $number;?>" checked="checked">Magnetic
				</label>
				<span style="padding:0 25px;" class="split">&nbsp;</span>
				<label class="lblRadioCheckbox">
					<input type="radio" value="Pin" name="fastener_<?php echo $number;?>">Pin
				</label>
				<span style="padding:0 10px;" class="split"></span>
				<font color="#d6d6d6" size="+2">|</font>
				<span style="padding:0 10px;" class="split"></span>
				<strong>Speaks Spanish:</strong>
				<span style="width:auto;" class="split"></span>
				<label class="lblRadioCheckbox order-box-ss">
					<input type="radio" value="No" name="speaks_spanish_<?php echo $number;?>" checked="checked">No
				</label>
				<span style="width:auto;" class="split"></span>
				<label class="lblRadioCheckbox order-box-ss">
					<input type="radio" value="Yes" name="speaks_spanish_<?php echo $number;?>">Yes
				</label>
			</div>
		</div>
	</div>
<?php } else if($type==2) {?>
	<div class="order-box clb input_box_b additional_box_b" value="<?php echo $number;?>">
		<h3>Badge <?php echo $number;?> <a class="remove_input_box" href="javascript: void(0)">(remove)</a></h3>
		<div style="padding-left:15px;">
			<label>
				<span>First name:</span>
				<input type="text" class="first_name" size="50" value="" name="first_name_b_<?php echo $number;?>" id="acpro_inp2">				
			</label>
			<label>
				<span>Title:</span>
				<?php 
					echo form_dropdown("title_b_{$number}", $titles, "", "id='title_b_{$number}'");
				?>
			</label>
			<div>
				<label class="lblRadioCheckbox">
					<input type="radio" value="Magnetic" name="fastener_b_<?php echo $number;?>" checked="checked">Magnetic
				</label>
				<span style="padding:0 25px;" class="split">&nbsp;</span>
				<label class="lblRadioCheckbox">
					<input type="radio" value="Pin" name="fastener_b_<?php echo $number;?>">Pin
				</label>
				<span style="padding:0 10px;" class="split"></span>
				<font color="#d6d6d6" size="+2">|</font>
				<span style="padding:0 10px;" class="split"></span>
				<strong>Speaks Spanish:</strong>
				<span style="width:auto;" class="split"></span>
				<label class="lblRadioCheckbox order-box-ss">
					<input type="radio" value="No" name="speaks_spanish_b_<?php echo $number;?>" checked="checked">No
				</label>
				<span style="width:auto;" class="split"></span>
				<label class="lblRadioCheckbox order-box-ss">
					<input type="radio" value="Yes" name="speaks_spanish_b_<?php echo $number;?>">Yes
				</label>
			</div>
		</div>
	</div>
<?php } else {?>
	<div class="order-box clb input_box_c additional_box_b" value="<?php echo $number;?>">
		<h3>Badge <?php echo $number;?><a class="remove_input_box" href="javascript: void(0)">(remove)</a></h3>
		<div style="padding-left:15px;">
			<div>
				<label class="lblRadioCheckbox">
					<input type="radio" value="Magnetic" name="fastener_c_<?php echo $number;?>" checked="checked">Magnetic
				</label>
				<span style="padding:0 25px;" class="split">&nbsp;</span>
				<label class="lblRadioCheckbox">
					<input type="radio" value="Pin" name="fastener_c_<?php echo $number;?>">Pin
				</label>
			</div>
		</div>
	</div>
<?php }?>