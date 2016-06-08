<div class="order-generic">
	<h3 class="title">Enter Generic Badge Quantities: $2.75</h3>
	<div class="generic-box clb">
		<div class="generic-img fll">
			<img src="<?php echo base_url();?>application/views/front_end/images/jcpenney.jpg" />
			All Positions
		</div>
		<div class="generic-magpin fll">
			<input type="hidden" value="jcpenney" class="badge_name"/>
			<label><input type="text" class="generic_magnetic_quantity" value=""/> Enter Quantity Magnetic</label>
			<label><input type="text" class="generic_pin_quantity" value=""/> Enter Quantity Pin</label>
		</div>
        <div class="generic-img fll">
            <img src="<?php echo base_url();?>application/views/front_end/images/generic-spanish.jpg" />
            Hablo Espanol
        </div>
        <div class="generic-magpin fll">
            <input type="hidden" value="hablo espanol" class="badge_name"/>
            <label><input type="text" class="generic_magnetic_quantity" value=""/> Enter Quantity Magnetic</label>
            <label><input type="text" class="generic_pin_quantity" value=""/> Enter Quantity Pin</label>
        </div>
         <div class="generic-img fll">
            <img src="<?php echo base_url();?>application/views/front_end/images/generic-hearing-impaired.jpg" />
            Hearing Impaired
        </div>
        <div class="generic-magpin fll">
            <input type="hidden" value="hearing impaired" class="badge_name"/>
            <label><input type="text" class="generic_magnetic_quantity" value=""/> Enter Quantity Magnetic</label>
            <label><input type="text" class="generic_pin_quantity" value=""/> Enter Quantity Pin</label>
        </div>
        <div class="generic-img fll">
            <img src="<?php echo base_url();?>application/views/front_end/images/generic-deaf-als.jpg" />
            Deaf-ASL
        </div>
        <div class="generic-magpin fll">
            <input type="hidden" value="deaf als" class="badge_name"/>
            <label><input type="text" class="generic_magnetic_quantity" value=""/> Enter Quantity Magnetic</label>
            <label><input type="text" class="generic_pin_quantity" value=""/> Enter Quantity Pin</label>
        </div>
	</div>
</div>
<input type="hidden" id="styleID_1" value="<?php echo $styleID;?>" />
<div class="clb txtC mb-15"><input type="button" value="Add Badges to Order" id="add_generic_names"></div>
