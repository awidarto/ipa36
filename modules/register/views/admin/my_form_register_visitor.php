<h3><?php print $header; ?></h3>
<!--
<ol class="form_nav">
    <li class="current_form">Personal Information & Main Registration</li>
</ol>
<div class="clear"></div>
-->
<script language="javascript">
    function calculate(){
        var total_idr = 0;
        var total_usd = 0;
        if(jQuery('input[name=registertype]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=registertype]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=registertype]:radio:checked').val()); 
        }

        if(jQuery('input[name=course_1]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=course_1]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=course_1]:radio:checked').val()); 
        }

        if(jQuery('input[name=course_2]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=course_2]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=course_2]:radio:checked').val()); 
        }

        if(jQuery('input[name=course_3]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=course_3]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=course_3]:radio:checked').val()); 
        }

        if(jQuery('input[name=course_3]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=course_3]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=course_3]:radio:checked').val()); 
        }


        if(jQuery('input[name=golf]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=golf]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=golf]:radio:checked').val()); 
        }

        if(jQuery('input[name=galadinner]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=galadinner]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=galadinner]:radio:checked').val()); 
        }
        
        if (jQuery('input[name=boothassistant]:checked').val() !== undefined) {
            total_usd += parseInt('<?=$this->config->item('boothassistant')?>'); 
        }
        
        jQuery('#total_idr').html('IDR '+total_idr);
        jQuery('#total_usd').html('USD '+total_usd);

        jQuery('#h_total_idr').val(total_idr);
        jQuery('#h_total_usd').val(total_usd);
        jQuery('#h_galadinner').val(jQuery('input[name=galadinner]:radio:checked').attr('class'));
        jQuery('#h_golf').val(jQuery('input[name=golf]:radio:checked').attr('class'));
        jQuery('#h_registrationtype').val(jQuery('input[name=registertype]:radio:checked').attr('rel'));
        
    }
    
    $(document).ready(function() {
        calculate();
        
        jQuery.ajaxSetup( { type: "post" } );
                
        jQuery( "#company" ).autocomplete({
    		source: "<?=base_url()?>register/ajaxcompany",
    		minLength: 2
    	});
        
    });
    
    </script>
<?php print form_open('register/admin/register/visitor',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <div class="annotation">(*) mandatory field</div>
            </li>
            <li>
                <?php print form_label('Salutation :','salutation')?>
                <?php print form_radio('salutation','Mr.',$this->validation->set_radio('salutation','Mr.'),'id="salutation"')?>Mr.
                <?php print form_radio('salutation','Mrs.',$this->validation->set_radio('salutation','Mrs.'))?>Mrs.
                <?php print form_radio('salutation','Ms.',$this->validation->set_radio('salutation','Ms.'))?>Ms.
            </li>
            <li>
                <?php print form_label('First Name :*','firstname')?>
                <?php print form_input('firstname',$this->validation->firstname,'id="firstname" class="text"')?>
            </li>
            <li>
                <?php print form_label('Last Name :*','lastname')?>
                <?php print form_input('lastname',$this->validation->lastname,'id="lastname" class="text"')?>
            </li>
            <li>
                <label for="email"><?php print $this->lang->line('userlib_email')?> :*</label>
                <input type="text" name="email" id="email" class="text"  value="<?php print $this->validation->email?>" />
            </li>
            <li>
                <?php print form_label('Company :*','company')?>
                <?php print form_input('company',$this->validation->company,'id="company" class="text"')?>
            </li>
            <li>
                <?php print form_label('Telephone* :','phone')?>
                <?php print form_input('phone',$this->validation->phone,'id="phone" class="text"')?>
            </li>
            <li>
                <?php print form_label('Address 1 :','street')?>
                <?php print form_input('street',$this->validation->street,'id="street" class="text"')?>
            </li>
            <li>
                <?php print form_label('Address 2 :','street2')?>
                <?php print form_input('street2',$this->validation->street2,'id="street2" class="text"')?>
            </li>
            <li>
                <?php print form_label('City :','city')?>
                <?php print form_input('city',$this->validation->city,'id="city" class="text"')?>
            </li>
            <li>
                <?php print form_label('ZIP :','zip')?>
                <?php print form_input('zip',$this->validation->zip,'id="zip" class="text"')?>
            </li>
            <li>
                <?php print form_label('Country :','country')?>
                <?php print form_dropdown('country', $this->config->item('countries'),$this->validation->country,'id="country"');?>
                <?php print form_hidden('domain',base_url())?>
            </li>
            <?php
            // Only display captcha if needed
            if($this->preference->item('use_registration_captcha')){
            ?>
            <li class="captcha">
                <label for="recaptcha_response_field"><?php print $this->lang->line('userlib_captcha')?>:</label>
                <?php print $captcha?>
            </li>
            <?php } ?>
            <li class="submit" style="float:right;">
            	<div class="buttons">
            		<a href="<?php print base_url() ?>user/profile" class="negative" >
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>

            		<button type="submit" class="positive" name="submit" value="submit" onClick="javascript:calculate();">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Submit
            		</button>
            		
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>