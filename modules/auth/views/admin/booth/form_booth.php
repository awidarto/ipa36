<h2><?php print $header?></h2>
<style>
    .small_input{
        width:5em;
    }
</style>
<script>
    $(document).ready(function() {
    
        jQuery.ajaxSetup( { type: "post" } );
            
        jQuery( "#bookedby" ).autocomplete({
    		source: "<?=base_url()?>register/ajaxuser",
    		minLength: 2,
    		select: function( event, ui ) {
				$( "#bookedby" ).val( ui.item.label );
				$( "#booker" ).val( ui.item.value );
				$( "#company" ).val( ui.item.company );
				$( "#l_pic_id" ).html( ui.item.value );
				$( "#l_pic_name" ).html( ui.item.label );
				return false;
			}
			
    	});
    
    });
</script>
<?php print form_open('auth/admin/booth/form/'.$this->validation->id,array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <?php print form_label('Booth Number','booth_number')?>
                <?php print $this->validation->booth_number;?>
            </li>
            <li>
                <?php print form_label('Position','hall')?>
                <?php print $this->validation->hall;?>
            </li>
            <li>
                <?php print form_label('Type','type')?>
                <?php print $this->validation->type;?>
            </li>
            <li>
                <?php print form_label('Width','width')?>
                <?php print $this->validation->width;?> meters
            </li>
            <li>
                <?php print form_label('Length','length')?>
                <?php print $this->validation->length; ?> meters
            </li>
            <li>
                <?php print form_label('Total Area','area')?>
                USD <?php print $this->validation->area;?> square meters
            </li>
            <li>
                <?php print form_label('Price / Sq Meter','price_sqm')?>
                USD <?php print $this->validation->price_sqm;?> square meters
            </li>
            <li>
                <?php print form_label('Total Price','price_total')?>
                USD <?php print number_format($this->validation->price_total);?>
            </li>
            <li>
                <?php print form_label('Booked By (Company\'s PIC)','bookedby')?>
                <?php print form_input('bookedby','','id="bookedby" class="text"')?><br />
                <span>( This is an autocomplete input, use minimum of 2 characters to perform autosearching )</span>
                <input type="hidden" id="booth_number" name="booth_number" value="<?=$this->validation->booth_number;?>" />
                <input type="hidden" id="booker" name="booker" value="" />
                <input type="hidden" id="company" name="company" value="" />
                <ul>
                    <li>Person In Charge ID : <span id="l_pic_id"></span></li>
                    <li>Person In Charge : <span id="l_pic_name"></span></li>
                    <li>Booth Number : <span id="l_booth_number"><?=$this->validation->booth_number;?></span></li>
                </ul>
            </li>
            <li class="submit">
                <?php print form_hidden('id',$this->validation->id)?>
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?php print  $this->bep_assets->icon('disk');?>
	                	<?php print $this->lang->line('general_save')?>
	                </button>

	                <a href="<?php print  site_url('auth/admin/booth')?>" class="negative">
	                	<?php print  $this->bep_assets->icon('cross');?>
	                	<?php print $this->lang->line('general_cancel')?>
	                </a>
	            </div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>