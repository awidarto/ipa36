<h3><?php print $header?></h3>
<!--
<ol class="form_nav">
    <li class="current_form">Personal Information & Main Registration</li>
</ol>
<div class="clear"></div>
<?php print $get_galadinner_count.' vs '.$this->config->item('galadinner_quota'); ?>
-->
<script language="javascript">

    var conv_lock = <?=$conv_lock?>;
    
    function validateConv(){
        if(jQuery('input[name=registertype]:radio:checked').val() == null){
            var ans = confirm('Please specify your convention registration type');
            if(ans == true){
                
            }
        }
    }

    function calculate(){
        var total_idr = 0;
        var total_usd = 0;
        
        if(jQuery('input[name=registertype]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=registertype]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=registertype]:radio:checked').val()); 
        }

        if(jQuery('input[name=golf]:radio:checked').val() != null && jQuery('input[name=golf]:radio:checked').val() > 1){
            if(jQuery('input[name=golf]:radio:checked').attr('class') == 'USD'){
                total_usd += parseInt(jQuery('input[name=golf]:radio:checked').val()); 
            }else{
                total_idr += parseInt(jQuery('input[name=golf]:radio:checked').val()); 
            }
        }

        if(jQuery('input[name=galadinner]:radio:checked').val() != null && jQuery('input[name=galadinner]:radio:checked').val() > 1){
            if(jQuery('input[name=galadinner]:radio:checked').attr('class') == 'USD'){
                total_usd += parseInt(jQuery('input[name=galadinner]:radio:checked').val()); 
            }else{
                total_idr += parseInt(jQuery('input[name=galadinner]:radio:checked').val()); 
            }
        }

        if(jQuery('input[name=galadinneraux]:radio:checked').val() != null && jQuery('input[name=galadinneraux]:radio:checked').val() > 1){
            if(jQuery('input[name=galadinneraux]:radio:checked').attr('class') == 'USD'){
                total_usd += parseInt(jQuery('input[name=galadinneraux]:radio:checked').val()); 
            }else{
                total_idr += parseInt(jQuery('input[name=galadinneraux]:radio:checked').val()); 
            }
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
        if(conv_lock == 0){
            calculate();
        }
        
        jQuery.ajaxSetup( { type: "post" } );
                
        jQuery( "#company" ).autocomplete({
    		source: "<?=base_url()?>register/ajaxcompany",
    		minLength: 2
    	});
        
    });
    
    </script>
<?php print form_open('register/convention',array('class'=>'horizontal'))?>

<?php 
    
    $open = true;

    if( time() > strtotime($this->preference->item('convention_registration_date')) && $this->preference->item('convention_registration_date') != '' && $this->preference->item('convention_registration_date') != '[TBA]'){
        $open = true;
    }else{
        $open = false;
    }
    
    if($this->session->userdata('company') == 'Quad'){
        $open = true;
    }
    
    //print $conv_lock;
    if($conv_lock == 1){
        $lock = 'disabled';
    }else{
        $lock = '';
    }
    
    //print $lock;
?>
<?php if($open == true): ?>    

    <fieldset>
        <ol>
            <li>
                <div class="annotation">(*) denotes mandatory field</div>
            </li>
            <?php if($conv_id > 0): ?>
                <li>
                    <span style="font-weight:bold;font-size:18px;">Registration Number : <?php print $conv_id;?></span>
                </li>
            <?php endif;?>
            <li>
                <div class="note">CONVENTION PACKAGES</div>
                <?php print form_label('Registration Type <br />( cost is per person ) :*','registertype')?>
                <ul style="margin-left:200px;">
                    <table>
                        <tr style="height:25px;">
                            <td style="width:200px;">&nbsp;
                                
                            </td>
                            <td style="width:120px;">
                                Domestic
                            </td>
                            <td style="width:100px;">
                                Overseas
                            </td>
                        </tr>
                        <tr style="height:25px;">
                            <td>
                                <strong>Professional</strong>
                            </td>
                            <td>
                                <?php print form_radio('registertype',$this->config->item('member_domestic'),$this->validation->set_radio('registertype',$this->config->item('member_domestic')),'id="registertype" class="IDR" rel="Professional Domestic" onClick="calculate()" '.$lock)?>
                                IDR <?=number_format($this->config->item('member_domestic')) ?>&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                <?php print form_radio('registertype',$this->config->item('member_overseas'),$this->validation->set_radio('registertype',$this->config->item('member_overseas')),'id="registertype" class="USD" rel="Professional Overseas" onClick="calculate()" '.$lock)?>
                                USD <?=number_format($this->config->item('member_overseas')) ?>
                            </td>
                        </tr>
                        <tr style="height:15px;">
                            <td colspan="3">&nbsp;
                                
                            </td>
                        </tr>
                        <tr style="height:25px;">
                            <td>
                                <strong>Student *</strong>
                            </td>
                            <td>
                                <?php print form_radio('registertype',$this->config->item('student_domestic'),$this->validation->set_radio('registertype',$this->config->item('student_domestic')),'id="registertype" class="IDR" rel="Student Domestic" onClick="calculate()" '.$lock)?>
                                IDR <?=number_format($this->config->item('student_domestic')) ?>&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                <?php print form_radio('registertype',$this->config->item('student_overseas'),$this->validation->set_radio('registertype',$this->config->item('student_overseas')),'id="registertype" class="USD" rel="Student Overseas" onClick="calculate()" '.$lock)?>
                                USD <?=number_format($this->config->item('student_overseas')) ?>
                            </td>
                        </tr>
                        <tr style="height:15px;">
                            <td colspan="3">
                                * valid only for undergraduate students
                            </td>
                        </tr>
                    </table>
                </ul>
            </li>
            <li>
                <div class="note">Please help IPA by volunteering as a Technical Program Judge</div>
                <ul style="margin-left:13px;" class="shortcourse">
                    <li>
				<?=form_label('','judge')?>
                <?=form_radio('judge','yes',$this->validation->set_radio('judge','yes'),$lock)?>Yes
                <?=form_radio('judge','no',$this->validation->set_radio('judge','no'),$lock)?>No
            <br />
            </li>
            </ul>
            </li>
            <li>
                <div class="note">GOLF | 17th May 2011, 6.30 AM</div>
                <div class="note" style="background-color:red;">Registration for Golf has been closed</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <table>
                            <tr style="height:25px;">
                                <td style="width:100px;">
                                    First come first served
                                </td>
                                <td colspan="2" >
                                    <strong>Fee:  IDR <?=number_format($this->config->item('golf_domestic')) ?></strong>
                                </td>
                            </tr>
                            <tr style="height:25px;">
                                <td style="width:200px;">
                                    Venue: <strong>Rainbow Hills Golf</strong><br />
                                </td>
                                <td style="width:100px;vertical-align:middle;">
                                    <?php print form_radio('golf',$this->config->item('golf_domestic'),$this->validation->set_radio('golf',$this->config->item('golf_domestic')),'class="IDR" onClick="calculate()" disabled '.$lock)?>
                                    Attending
                                </td>
                                <td style="width:120px;vertical-align:middle;">
                                    <?php print form_radio('golf','0',$this->validation->set_radio('golf','0'),'id="golf" onClick="calculate()"  disabled '.$lock)?>
                                    Not Attending
                                </td>
                            </tr>
                        </table>
                    </li>
                    <li>
                            Thank you for your interest in attending the Golf event.<br />
                            However, we have reached the quota for Golf registration and the Golf registration has been closed.<br />
                            <!--
                            Your name will be put on the waiting list and you will recieve further notification regarding the availability.
                            -->
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">GALA DINNER | 19th May 2011, 7.00 PM</div>
                <?php if($get_galadinner_count > $this->config->item('galadinner_quota')):?>
                    <div class="note" style="background-color:red;">Registration for Gala Dinner has been closed</div>
                <?php endif;?>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <table>
                            <tr style="height:25px;">
                                <td style="width:200px;">
                                    Venue: <strong>Ballroom Hotel Mulia, Senayan</strong>
                                </td>
                                <td colspan="2" >
                                    <strong>Fee: IDR <?=number_format($this->config->item('galadinner_domestic')) ?></strong>
                                </td>
                            </tr>
                            <?php
                                
                                if($get_galadinner_count > $this->config->item('galadinner_quota')){
                                    if($lock == 'disabled'){
                                        $galaover = '';
                                    }else{
                                        $galaover = 'disabled';
                                    }
                                }else{
                                    $galaover = '';
                                }
                            
                            ?>
                            <tr style="height:25px;">
                                <td>&nbsp;
                                    
                                </td>
                                <td style="width:100px;vertical-align:middle;">
                                    <?php print form_radio('galadinner',$this->config->item('galadinner_domestic'),$this->validation->set_radio('galadinner',$this->config->item('galadinner_domestic')),'class="IDR" onClick="calculate()" '.$lock.$galaover)?>
                                    Attending
                                </td>
                                <td style="width:120px;vertical-align:middle;">
                                    <?php print form_radio('galadinner','0',$this->validation->set_radio('galadinner','0'),'id="galadinner" onClick="calculate()" '.$lock.$galaover)?>
                                    Not Attending
                                </td>
                            </tr>
	                        <tr style="height:15px;">
	                            <td colspan="3">&nbsp;
	                                
	                            </td>
	                        </tr>
                            <tr style="height:25px;">
                                <td style="width:200px;">
                                    Accompanying Person
                                </td>
                                <td colspan="2" >
                                    <strong>Fee: IDR <?=number_format($this->config->item('galadinner_domestic')) ?></strong>
                                </td>
                            </tr>
                            <tr style="height:25px;">
                                <td>&nbsp;
                                    
                                </td>
                                <td style="width:100px;vertical-align:middle;">
                                    <?php print form_radio('galadinneraux',$this->config->item('galadinner_domestic'),$this->validation->set_radio('galadinneraux',$this->config->item('galadinner_domestic')),'class="IDR" onClick="calculate()" '.$lock.$galaover)?>
                                    Attending
                                </td>
                                <td style="width:120px;vertical-align:middle;">
                                    <?php print form_radio('galadinneraux','0',$this->validation->set_radio('galadinneraux','0'),'id="galadinneraux" onClick="calculate()" '.$lock.$galaover)?>
                                    Not Attending
                                </td>
                            </tr>
                        </table>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note" style="background-color:black;text-align:right;" >TOTAL CONVENTION PACKAGE CHARGE : <span id="total_idr"><?=$total_idr;?></span> | <span id="total_usd"><?=$total_usd;?></span><br />
					<span class="annotation" style="font-weight:normal;">No refund will be granted for cancellation after 29th April 2011</span>
				</div>
                <input type="hidden" value="0" name="total_idr" id="h_total_idr" />
                <input type="hidden" value="0" name="total_usd" id="h_total_usd" />
                <input type="hidden" value="0" name="galadinnercurr" id="h_galadinner" />
                <input type="hidden" value="0" name="golfcurr" id="h_golf" />
                <input type="hidden" value="0" name="registrationtype" id="h_registrationtype" />
                <input type="hidden" value="<?=$conv_id;?>" name="conv_id" id="conv_id" />
            </li>
            
            <?php if($conv_lock != 1):?>
            <li class="submit restricted" style="float:right;<?=($open == false)?'display:none;':'';?>">
            	<div class="buttons">
            		<a href="<?php print base_url() ?>user/profile" class="negative" >
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>

        		    <button type="submit" class="positive" name="submit" value="submitConv" onClick="javascript:calculate();">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Submit Convention Package Registration
            		</button>
            		
            	</div>
            	<div class="clear"></div>
            </li>
            <?php endif;?>
        	<div class="clear"></div>
            <li>
                <div class="note">GROUP REGISTRATION</div>
                <p>
                    To do <strong>Group Registration</strong> kindly download the Microsoft Excel document from the link below and follow the instructions
                    <br />
                    <a href="http://www.ipa.or.id/convex/uploads/GroupRegistrationForm.xls">Group Registration Template</a> 
                </p>
            </li>
            
            
        <?php else: ?>
                <li>
                    <?php if($this->preference->item('convention_registration_date') == '[TBA]'):?>
                        <div class="note" >Convention registration will be open soon</div>
                    <?php else:?>
                        <div class="note" >Convention registration will be open at <?=date('d-m-Y H:i:s',strtotime($this->preference->item('convention_registration_date')));?></div>
                    <?php endif;?>
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
                    <tr>
                        <td colspan="2">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        PT Fasen Creative Quality/QUAD Event Management is the official organizer for the 35th IPA Convention & Exhibition
                        </td>
                    </tr>
                </table>
            </li>
<!--
<li class="submit" style="float:right;">
	<div class="buttons">
		<a href="<?php print base_url() ?>" class="negative" >
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