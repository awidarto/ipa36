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
            $.post("<?=base_url()?>register/ajaxbook", 
                { b: booth, c: company, p: picid },
                function(data){
                    if(data.status == "err"){
                        alert(data.result);
                    }else{
                        jQuery("#booking").html(data.result);
                        jQuery("#entitlement").html(data.entitlement);
                        jQuery("#total_usd").html(data.total_price);
                    }
                },"json");
        }else{
            alert('Please pick available booth first');
        }
        
    }
    
    function cancelBook(booth){
        var company = jQuery("#company").val();
        var picid = jQuery("#pic_id").val();
        $.post("<?=base_url()?>register/ajaxcancel", 
            { b: booth, c: company, p: picid },
            function(data){
                if(data.status == "err"){
                    alert(data.result);
                }else{
                    jQuery("#booking").html(data.result);
                    jQuery("#entitlement").html(data.entitlement);
                    jQuery("#total_usd").html(data.total_price);
                }
            },"json");
    }
    
    $(document).ready(function() {
        jQuery('#floorplan a').fancybox(
            {
        		'transitionIn'		: 'elastic',
        		'transitionOut'		: 'elastic',
        		'titlePosition' 	: 'inside',
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

    
<?php print form_open('register/sponsor',array('class'=>'horizontal'))?>

<?php if( time() > strtotime($this->preference->item('sponsorship_registration_date')) && $this->preference->item('sponsorship_registration_date') != '' && $this->preference->item('sponsorship_registration_date') != '[ TBA ]' ) : ?>    

    <fieldset>
        <ol>
            <li>
                <div class="note">Company Information</div>
                <?php print form_label('Company :*','company')?>
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
                    <li>Prime Area : USD 450 / sq m</li>
                    <li>Regular Area : USD 400 / sq m</li>
                </ul>
                <?php print form_label('Floorplans :','floorplans')?>
                <ul id="floorplan">
                    <?php
                        /*
                        <li><a href="<?=base_url()?>public/fp/cenderawasih.jpg" rel="floorplan" title="Cenderawasih Room" ><img src="<?=base_url()?>public/fp/th_cenderawasih.jpg" class="shadow" /></a></li>
                        <li><a href="<?=base_url()?>public/fp/assembly_hall.jpg" rel="floorplan" title="Assembly Hall" ><img src="<?=base_url()?>public/fp/th_assembly_hall.jpg" class="shadow" /></a></li>
                        */
                    ?>
                    <li><a href="<?=base_url()?>public/fp/main_lobby.jpg" rel="floorplan" title="Main Lobby" ><img src="<?=base_url()?>public/fp/th_main_lobby.jpg" class="shadow" /></a></li>
                </ul>
                <div class="clear"></div>
                
                <?php print form_label('I wish to reserve :','boothreserve')?>
                <ul style="margin-left:200px;">
                    <li>Booth Number :<br />
                        <?php print form_input('boothnumber','','id="boothnumber" class="text" style="width:5em;"')?>
                        <span onClick="javascript:bookNow();" style="cursor:pointer;border:thin solid #aaa;background-color:maroon;color:white;padding:2px 4px;" >Book Now !</span>
                    </li>
                    <li>
                        Reservation List :
                        <div id='booking'>
                            <?php
                                if(isset($booth) AND is_array($booth)){
                                    $html = "<ol id='reservation'>";
                                    foreach($booth as $bot){
                                        $html.= sprintf("<li>Booth %s - %s sq m - booked by %s - %s %s <span class=\"cancel_button\" onClick=\"javascript:cancelBook('%s')\" >cancel</span></li>",
                                                $bot['booth_number'],
                                                $bot['area'],
                                                $bot['orderby'],
                                                $bot['type'],
                                                'USD '.number_format($bot['price_total']),
                                                $bot['booth_number']
                                                );
                        	        }
                        	        $html.="</ol>";
                        	        print $html;
                                }
                            ?>
                        </div>
                    </li>
                </ul>
            </li>
            <li>
                <div class="note">Entitlement</div>
                <div>Exhibitor Personnel : <span id="entitlement"><?=$entitlement;?></span> person(s)</div>
            </li>
            <li>
                <div class="note" style="background-color:orange;text-align:right;" >
                TOTAL CHARGE : <span id="total_usd"><?=$total_charge;?></span></div>
                <input type="hidden" value="0" name="total_idr" id="h_total_idr" />
                <input type="hidden" value="0" name="total_usd" id="h_total_usd" />
                <input type="hidden" value="0" name="galadinnercurr" id="h_galadinner" />
                <input type="hidden" value="0" name="golfcurr" id="h_golf" />
                <input type="hidden" value="0" name="registrationtype" id="h_registrationtype" />
            </li>
    <?php else: ?>
            <li>
                <div class="note" >Sponsorship registration will be opened at <?=$this->preference->item('sponsorship_registration_date');?></div>
            </li>
    <?php endif;?>
            
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
                            A/N PT. FASEN CREATIVE QUALITY<br />
                        </td>
                        <td>
                            <strong>Rupiah Account :</strong><br />
                            Bank Mandiri<br />
                            KCP Jakarta Kemang Selatan<br />
                            A/C 126-00-0602403-7<br />
                            A/N PT. FASEN CREATIVE QUALITY<br />
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