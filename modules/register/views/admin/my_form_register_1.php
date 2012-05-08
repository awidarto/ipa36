<h3><?php print $header?></h3>
<!--
<ol class="form_nav">
    <li class="current_form">Personal Information & Main Registration</li>
</ol>
<div class="clear"></div>
-->
<script language="javascript">
    var bookCounter = 0;
    
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
    
    function bookNow(){
        var booth = jQuery("#boothnumber").val();
        var company = jQuery("#company").val();
        var picid = jQuery("#pic_id").val();
        if(booth != ''){
            jQuery("#process").show();
            $.post("<?=base_url()?>register/ajaxbook/" + Math.random(), 
                { b: booth, c: company, p: picid },
                function(data){
                    jQuery("#process").hide();
                    if(data.status == "err"){
                        jQuery("#booking").html(data.result);
                        alert(data.msg);
                    }else{
                        jQuery("#booking").html(data.result);
                        jQuery("#entitlement").html(data.entitlement);
                        jQuery("#total_usd").html(data.total_price);
                        alert(data.msg);
                    }
                },"json");
        }else{
            alert('Please pick available booth first');
        }
        
    }
    
    function cancelBook(booth){
        var company = jQuery("#company").val();
        var picid = jQuery("#pic_id").val();
        jQuery("#process").show();
        $.post("<?=base_url()?>register/ajaxcancel/" + Math.random(), 
            { b: booth, c: company, p: picid },
            function(data){
                jQuery("#process").hide();
                if(data.status == "err"){
                    jQuery("#booking").html(data.result);
                    alert(data.msg);
                }else{
                    jQuery("#booking").html(data.result);
                    jQuery("#entitlement").html(data.entitlement);
                    jQuery("#total_usd").html(data.total_price);
                    alert(data.msg);
                }
            },"json");
    }
    
    $(document).ready(function() {
        jQuery('#floorplan a').fancybox(
            {
        		'transitionIn'		: 'elastic',
        		'transitionOut'		: 'elastic',
        		'titlePosition' 	: 'inside',
        		'type'              : 'iframe',
        		'width'             : 950,
        		'height'            : 500,
        		'autoScale'         : false,
        		'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
        		    /*return '<span id="fancybox-title-over" style="color:white">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';*/
        		    return '<span id="fancybox-title-over" style="color:white">' + title + '</span>';
        		}
            }
        );
        
        jQuery.ajaxSetup( { type: "post" } );
        
        jQuery( "#boothnumber" ).autocomplete({
			source: "<?=base_url()?>register/ajaxbooth",
			minLength: 1
		});

    });
    
    </script>
<?php print form_open('register/exhibition/'.$this->validation->pic_id,array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <div class="note">Company Information</div>
                <?php print form_label('Company :','company')?>
                <?php print $this->validation->company; ?>
                <input type="hidden" value="<?=$this->validation->company;?>" name="company" id="company" />
                <input type="hidden" value="<?=$this->validation->pic_id;?>" name="pic_id" id="pic_id" />
            </li>
            <li>
                <?php print form_label('Invoice Address :','invoice_address')?>
                <?php print $this->validation->invoice_address; ?>
                <input type="hidden" value="<?=$this->validation->invoice_address;?>" name="invoice_address" id="invoice_address" />
            </li>
            <li>
                <?php print form_label('Email :','email')?>
                <?php print $this->validation->email; ?>
                <input type="hidden" value="<?=$this->validation->email;?>" name="email" id="email" />
            </li>
            <li>
                <?php print form_label('Telephone :','phone')?>
                <?php print $this->validation->phone; ?>
                <input type="hidden" value="<?=$this->validation->phone;?>" name="phone" id="phone" />
            </li>
            <li>
                <div class="note">Booth Reservation</div>
                <ul style="margin-left:200px;">
                    <li>
                        <strong>Price per square meter :</strong>
                    </li>
                    <li>Silver : USD 400 / sq m</li>
                    <li>Gold : USD 430 / sq m</li>
                    <li>Platinum : USD 450 / sq m</li>
                </ul>
                <?php print form_label('Floorplan :','floorplans')?>
                <ul id="floorplan">
                    <?php
                        /*
                        <li><a href="<?=base_url()?>public/fp/cenderawasih.jpg" rel="floorplan" title="Cenderawasih Room" ><img src="<?=base_url()?>public/fp/th_cenderawasih.jpg" class="shadow" /></a></li>
                        <li><a href="<?=base_url()?>public/fp/assembly_hall.jpg" rel="floorplan" title="Assembly Hall" ><img src="<?=base_url()?>public/fp/th_assembly_hall.jpg" class="shadow" /></a></li>
                        */
                    ?>
                    <li>
                        <a href="<?=base_url()?>register/floorplan/main_lobby" rel="floorplan" title="Exhibition Floor Plan - use scroller to navigate" ><img src="<?=base_url()?>public/fp/th_main_lobby.jpg" class="shadow" /></a>
                    </li>
                </ul>
                <div class="clear"></div>
                
    <?php 

        $open = true;
        if( time() > strtotime($this->preference->item('exhibition_registration_date')) && $this->preference->item('exhibition_registration_date') != '' && $this->preference->item('exhibition_registration_date') != '[TBA]'){
            $open = true;
        }else{
            $open = false;
        }
        
        // security related : booking form generated 3 hours before opening time
        if(time() > (strtotime($this->preference->item('exhibition_registration_date')) - (12*60*60))){
            $openform = true;
        }else{
            $openform = false;
        }
        
        if($this->session->userdata('company') == 'Quad'){
            $open = true;
        }
    ?>
                
                <?php //print form_label('I wish to reserve :','boothreserve')?>
                <ul style="margin-left:200px;<?=($open == false)?'display:none;':'';?>" class="restricted">
                    <li>Booth Number :<br />
                        <?php print form_input('boothnumber','','id="boothnumber" class="text" style="width:5em;"')?>
                        <span onClick="javascript:bookNow();" style="cursor:pointer;border:thin solid #aaa;background-color:maroon;color:white;padding:2px 4px;" >Book Now !</span>
                        &nbsp;&nbsp;<span id="process" style="display:none" >Processing...</span>
                    </li>
                    <li style="font-size:11px;">
                        Use complete booth number, complete with '-' (dash sign), example : M-100<br />
                        The system only process one booth number at one time, please DO NOT fill in multiple booth numbers 
                    </li>
                    <li>
                        <style>
                        	.ui-autocomplete {
                        		max-height: 100px;
                        		overflow-y: auto;
                        		/* prevent horizontal scrollbar */
                        		overflow-x: hidden;
                        		/* add padding to account for vertical scrollbar */
                        		padding-right: 20px;
                        	}
                        	/* IE 6 doesn't support max-height
                        	 * we use height instead, but this forces the menu to always be this tall
                        	 */
                        	* html .ui-autocomplete {
                        		height: 100px;
                        	}
                    	</style>
                	
                        Reservation List :
                        <div id='booking'>
                            <?php
                                if(isset($booth) AND is_array($booth)){
                                    $html = "<ol id='reservation'>";
                                    foreach($booth as $bot){
                                        if($bot['orderstatus'] == 'booked'){
                                            $statusto = 'booked by';
                                            $button = sprintf("<span class=\"cancel_button\" onClick=\"javascript:cancelBook('%s')\" >cancel</span>",$bot['booth_number']);
                                        }else if($bot['orderstatus'] == 'sold'){
                                            $statusto = 'sold to';
                                            $button = "<span class=\"sold_button\" >sold</span>";
                                        }else{
                                            $button = "";
                                        }
                                        $html.= sprintf("<li>Booth %s - %s sq m - %s %s on behalf of %s - %s %s %s</li>",
                                                $bot['booth_number'],
                                                $bot['area'],
                                                $statusto,
                                                $bot['firstname'].' '.$bot['lastname'],
                                                $bot['orderby'],
                                                $bot['type'],
                                                'USD '.number_format($bot['price_total']),
                                                $button
                                                );
                        	        }
                        	        if(count($booth) < $this->preference->item('booth_booking_limit')){
                                        for($i=0; $i < ($this->preference->item('booth_booking_limit') - count($booth));$i++){
                                            $html .= "<li>- empty slot -</li>";
                                        }
                        	        }
                        	        $html.="</ol>";
                                }else{
                                    $html = "<ol id='reservation'>";
                                    for($i=0; $i < $this->preference->item('booth_booking_limit');$i++){
                                        $html .= "<li>- empty slot -</li>";
                                    }
                        	        $html.="</ol>";
                                }
                    	        print $html;
                            ?>
                        </div>
                    </li>
                </ul>
            </li>

            <?php if($open == false): ?>    
                    <script>
                            $(document).ready(function() {
                                var refreshId = setInterval(function(){
                            		$.post("<?=base_url()?>register/clock/exhibition/" + Math.random(), 
                                        null,
                                        function(data){
                                            if(data == "open"){
                                                jQuery("#restrictor").hide();
                                                jQuery(".restricted").show();
                                                clearInterval(refreshId);
                                            }else{
                                                jQuery("#hour").html(data);
                                            }
                                        });
                                }, 1000);
                            });
                    </script>
                    <li id="restrictor" >
                        <?php if($this->preference->item('exhibition_registration_date') == '[TBA]'):?>
                            <div class="note" >Exhibitor registration will be open soon</div>
                        <?php else:?>
                            <div id="redbar">
                                <div class="note" >Exhibitor registration will be open at <?=date('d-m-Y H:i:s',strtotime($this->preference->item('exhibition_registration_date')));?> WIB ( GMT+7, Jakarta, Indonesia )</div>
                                <?php //if($openform == true):?>
                                <div id="clock" style="font-size:35px;text-align:center;font-weight:normal;padding:25px;color:white;background-color:red;">Current Server Time : <span id="hour">&nbsp</span></div>
                                <div class="note" >
                                Please refresh your browser manually if the above clock does not disappear and a booking form does not appear after <?=date('d-m-Y H:i:s',strtotime($this->preference->item('exhibition_registration_date')));?> WIB (GMT+7, Jakarta, Indonesia).
                                </div>
                                <?php //endif;?>
                            </div>
                        <?php endif;?>
                    </li>
            <?php endif;?>
            
            <li>
                <div class="note">Booth Booking Rules</div>
                <ol style="list-style-type:decimal;">
                    <li>1. Booking online is strictly on a "first come first served" basis.</li>
                    <li>2. Booking is made using Company Name as a sole identifier.</li>
                    <li>3. Each Company Name is entitled to book up to <?=$this->preference->item('booth_booking_limit');?> booths.</li>
                    <li>4. Multiple Usernames are allowed to book for the same exact Company Name, either simultaneously or not simultaneously, and also become subject to the restriction set on point 3.</li>
                    <li>5. Overbooking for one Company by multiple Usernames using variations of Company Name (for example: 'PT. A Company' vs. 'A Company') is discouraged, and will be resolved manually by the Administrator.</li>
                    <li>6. For each booking and cancelation, a notification email will be sent to the registered email address of the Username doing the particular booking, along with necessary instructions to complete the process.</li>
                    <li>7. Each successful booking will block the particular Booth Number for particular Company Name, this state will be persistently stored in the database by the moment 'Book Now!' button is clicked, therefore there is no need to explicitly submit this form.</li>
                </ol>
                <div class="note">Exhibitor - Terms and Conditions</div>
                <p>
                    <b>BOOTH SPACE BOOKING:</b><br />
                    Booking shall be made online on "first come first served" basis.
                    To complete the booking process, you need to fill and sign the attached
                    Commitment Letter and return it by email as an attachment to
                    quadmice@quadevent.com and facsimile to +62-21-7661267 within 7
                    (seven) calendar days upon receipt of this Confirmation Letter.
                </p>
                <p>
                    <b>TERMS Of PAYMENT:</b><br />
                    Payment should be settled 1 (one) month after invoice date.
                </p>
                <p>
                    <b>CANCELLATION:</b><br />
                    To cancel your current booking(s) or make new booking(s), you will be required to login to your profile and make the necessary changes.
                    Confirmation of your new booking will be subject to availability of space
                    The following charges will be levied if this booking is cancelled:
                    <ul style="list-style-type:decimal;">
                        <li>1. 50% cancellation penalty is applicable to any cancellation after receipt of the Commitment Letter.</li>
                        <li>2. 100% cancellation penalty is applicable to any cancellation within 30 (thirty) days prior to the event.</li>
                    </ul>
                </p>
            </li>
            <li style="<?=($open == false)?'display:none;':'';?>" class="restricted">
                <div class="note">Entitlement</div>
                <div>Exhibitor Personnel : <span id="entitlement"><?=$entitlement;?></span> person(s)</div>
                <!--
                <div class="annotation">
                    <ol>
                        <li>Free of charge exhibitor personell entitled to a company is 2 persons per 9 square meters booth space, with maximum of 10 persons</li>
                        <li>Additional exhibitor personell ( 11th and so forth ) will be charged USD 60 per person.</li>
                    </ol>
                </div>
                -->
            </li>
            <li style="<?=($open == false)?'display:none;':'';?>" class="restricted">
                <div class="note" style="background-color:orange;text-align:right;" >
                TOTAL CHARGE : <span id="total_usd"><?=$total_charge;?></span></div>
                <input type="hidden" value="0" name="total_idr" id="h_total_idr" />
                <input type="hidden" value="0" name="total_usd" id="h_total_usd" />
                <input type="hidden" value="0" name="galadinnercurr" id="h_galadinner" />
                <input type="hidden" value="0" name="golfcurr" id="h_golf" />
                <input type="hidden" value="0" name="registrationtype" id="h_registrationtype" />
            </li>
            <li class="submit restricted" style="float:right;<?=($open == false)?'display:none;':'';?>">
            	<div class="buttons">
            		<a href="<?php print base_url() ?>media/admin/convex" class="negative" >
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>

            		<a href="<?php print base_url() ?>user/profile" class="positive" onClick="javascript:alert('Your booking is successfully saved. Please check your email for further detail on registration process.')">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Submit
            		</a>
            		
            	</div>
            	<div class="clear"></div>
            </li>
            <li>
                Payment Transfer to<br />
                <br />
                <table width=100% >
                    <tr>
                        <td>
                            <strong>USD Account :</strong><br /> 
                            Bank Mandiri<br />
                            KCP Jakarta Kemang Selatan<br />
                            A/C 126-00-0602405-2<br />
                            Beneficiary : PT. FASEN CREATIVE QUALITY<br />
                        </td>
                        <td>
                            <strong>Rupiah Account :</strong><br />
                            Bank Mandiri<br />
                            KCP Jakarta Kemang Selatan<br />
                            A/C 126-00-0602403-7<br />
                            Beneficiary : PT. FASEN CREATIVE QUALITY<br />
                        </td>
                    </tr>
                </table>
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
            <!--
            <li class="submit" style="float:right;">
            	<div class="buttons">
            		<a href="<?php print base_url() ?> class="negative">
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>

            		<button type="submit" class="positive" name="submit" value="submit" onClick="javascript:calculate();">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Submit
            		</button>
            		
            	</div>
            </li>
            -->
        </ol>
    </fieldset>
<?php print form_close()?>