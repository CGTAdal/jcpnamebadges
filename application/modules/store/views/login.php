<?php echo form_open(''); ?>
	<div class="login">
		<a href=""><img src="<?php echo base_url();?>application/views/front_end/images/jcp.png" class="mb-20" /></a><br />
		<a href=""><img src="<?php echo base_url();?>application/views/front_end/images/namebadge.png" class="mb-60" /></a>
		<div class="login-c">
			<label>
				<span>Store Number:</span>
				<?php 
					$data = array(
								'name'	=> "store_number",
								'value'	=> $this->input->post('store_number'),
							);
					echo form_input($data);
					echo form_error('store_number');
					echo ($error_messages!="")?"<p>".$error_messages."</p>":"";
				?>
			</label>
			<label><span>&nbsp;</span><input type="submit" name="submit" value="Submit" /></label>
		</div>
	</div>
<?php echo form_close();?>