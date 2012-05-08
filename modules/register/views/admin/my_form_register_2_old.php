<h3><?php print $header?></h3>
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
?>
<?php if($open == true): ?>    

    <fieldset>
        <ol>
            <li>
                <div class="annotation">(*) mandatory field</div>
            </li>
            <li>
                <div class="note">Convention Packages</div>
                <?php print form_label('Registration Type <br />( cost is per person ) :*','registertype')?>
                <ul style="margin-left:200px;">
                    <li>Member (IPA Professional Division's Individual Member)<br />
                        IPA Membership Id <?php print form_input('ipaid',$this->validation->ipaid,'id="ipaid" class="text" style="width:15em;"')?>
                    </li>
                    <li>
                        <?php print form_radio('registertype',$this->config->item('member_domestic'),$this->validation->set_radio('registertype',$this->config->item('member_domestic')),'id="registertype" class="IDR" rel="Member Domestic"')?>
                        Domestic IDR <?=number_format($this->config->item('member_domestic')) ?>
                        <?php print form_radio('registertype',$this->config->item('member_overseas'),$this->validation->set_radio('registertype',$this->config->item('member_overseas')),'id="registertype" class="USD" rel="Member Overseas"')?>
                        Overseas USD <?=number_format($this->config->item('member_overseas')) ?>
                    </li>
                    <li>Non Member</li>
                    <li>
                        <?php print form_radio('registertype',$this->config->item('non_member_domestic'),$this->validation->set_radio('registertype',$this->config->item('non_member_domestic')),'id="registertype" class="IDR"rel="Non Member Domestic"')?>
                        Domestic IDR <?=number_format($this->config->item('non_member_domestic')) ?>
                        <?php print form_radio('registertype',$this->config->item('non_member_overseas'),$this->validation->set_radio('registertype',$this->config->item('non_member_overseas')),'id="registertype" class="USD" rel="Non Member Overseas"')?>
                        Overseas USD <?=number_format($this->config->item('non_member_overseas')) ?>
                    </li>
                    <li>Student</li>
                    <li>
                        <?php print form_radio('registertype',$this->config->item('student_domestic'),$this->validation->set_radio('registertype',$this->config->item('student_domestic')),'id="registertype" class="IDR" rel="Student Domestic"')?>
                        Domestic IDR <?=number_format($this->config->item('student_domestic')) ?>
                        <?php print form_radio('registertype',$this->config->item('student_overseas'),$this->validation->set_radio('registertype',$this->config->item('student_overseas')),'id="registertype" class="USD" rel="Student Overseas"')?>
                        Overseas USD <?=number_format($this->config->item('student_overseas')) ?>
                    </li>
                </ul>
            </li>
            <li>
                <div class="note">GOLF | 18th May 2011, 6.30 AM</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Venue : Royale Halim, Jakarta</p>
                        <?php print form_radio('golf','0',$this->validation->set_radio('golf','0'),'id="golf"')?>
                        Not Attending
                        <?php print form_radio('golf',$this->config->item('golf_domestic'),$this->validation->set_radio('golf',$this->config->item('golf_domestic')),'class="IDR"')?>
                        Domestic IDR <?=number_format($this->config->item('golf_domestic')) ?>
                        <?php print form_radio('golf',$this->config->item('golf_overseas'),$this->validation->set_radio('golf',$this->config->item('golf_overseas')),'class="USD"')?>
                        Overseas USD <?=number_format($this->config->item('golf_overseas')) ?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">GALA DINNER | 18th May 2011, 7 PM</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Venue : Ballroom Hotel Mulia, Senayan</p>
                        <?php print form_radio('galadinner','0',$this->validation->set_radio('galadinner','0'),'id="galadinner"')?>
                        Not Attending
                        <?php print form_radio('galadinner',$this->config->item('galadinner_domestic'),$this->validation->set_radio('galadinner',$this->config->item('galadinner_domestic')),'class="IDR"')?>
                        Domestic IDR <?=number_format($this->config->item('galadinner_domestic')) ?>
                        <?php print form_radio('galadinner',$this->config->item('galadinner_overseas'),$this->validation->set_radio('galadinner',$this->config->item('galadinner_overseas')),'class="USD"')?>
                        Overseas USD <?=number_format($this->config->item('galadinner_overseas')) ?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note" style="background-color:orange;text-align:right;" >[ <span onClick="javascript:calculate();" style="cursor:pointer">click to calculate</span> ] TOTAL CHARGE : <span id="total_idr">0</span> | <span id="total_usd"></span></div>
                <input type="hidden" value="0" name="total_idr" id="h_total_idr" />
                <input type="hidden" value="0" name="total_usd" id="h_total_usd" />
                <input type="hidden" value="0" name="galadinnercurr" id="h_galadinner" />
                <input type="hidden" value="0" name="golfcurr" id="h_golf" />
                <input type="hidden" value="0" name="registrationtype" id="h_registrationtype" />
            </li>
            <li class="submit restricted" style="float:right;<?=($open == false)?'display:none;':'';?>">
            	<div class="buttons">
            		<a href="<?php print base_url() ?>user/profile" class="negative" >
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>

            		<a href="<?php print base_url() ?>user/profile" class="positive" onClick="javascript:alert('Your booking is successfully saved. Please check your email for further detail on registration process.')">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Submit Convention Package Registration
            		</a>
            		
            	</div>
            	<div class="clear"></div>
            </li>
        	<div class="clear"></div>

            <li>
                <div class="note">SHORT COURSES | Hotel Mulia, 16 - 17 May 2011</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Title: <b>Real Time Technologies for On-Time Drilling Operations</b><br />
                        Instructor: Samit Sengupta & Dr. Julian Pickering – Geologix Limited, UK</p>
                        <?php print form_radio('course_1','0',$this->validation->set_radio('course_1','0'),'id="course_1"')?>
                        Not Attending
                        <?php print form_radio('course_1',$this->config->item('course_1_member'),$this->validation->set_radio('course_1',$this->config->item('course_1_member')),'class="USD"')?>
                        IPA Member USD <?=number_format($this->config->item('course_1_member')) ?>
                        <?php print form_radio('course_1',$this->config->item('course_1_non_member'),$this->validation->set_radio('course_1',$this->config->item('course_1_non_member')),'class="USD"')?>
                        Non Member USD <?=number_format($this->config->item('course_1_non_member')) ?>
                    </li>

                    <li>
                        <p>Title: <b>Production Optimization Using Nodal System, Analysis: An Integrated Approach</b><br />
                        Instructor: Tutuka Ariadji, Ms.C., Ph.D. - Petroleum Engineering Dept., Institute of Technology Bandung</p>
                        <?php print form_radio('course_2','0',$this->validation->set_radio('course_2','0'),'id="course_2"')?>
                        Not Attending
                        <?php print form_radio('course_2',$this->config->item('course_2_member'),$this->validation->set_radio('course_2',$this->config->item('course_2_member')),'class="USD"')?>
                        IPA Member USD <?=number_format($this->config->item('course_2_member')) ?>
                        <?php print form_radio('course_2',$this->config->item('course_2_non_member'),$this->validation->set_radio('course_2',$this->config->item('course_2_non_member')),'class="USD"')?>
                        Non Member USD <?=number_format($this->config->item('course_2_non_member')) ?>
                    </li>

                    <li>
                        <p>Title: <b>Pressure Data for Exploration Success</b><br />
                        Instructor: Steve O’Connor - GeoPressure Technology Limited, UK</p>
                        <?php print form_radio('course_3','0',$this->validation->set_radio('course_3','0'),'id="course_3"')?>
                        Not Attending
                        <?php print form_radio('course_3',$this->config->item('course_3_member'),$this->validation->set_radio('course_3',$this->config->item('course_3_member')),'class="USD"')?>
                        IPA Member USD <?=number_format($this->config->item('course_3_member')) ?>
                        <?php print form_radio('course_3',$this->config->item('course_3_non_member'),$this->validation->set_radio('course_3',$this->config->item('course_3_non_member')),'class="USD"')?>
                        Non Member USD <?=number_format($this->config->item('course_3_non_member')) ?>
                    </li>

                    <li>
                        <p>Title: <b>Petroleum Geochemistry: A Quest for Oil and Gas</b><br />
                        Instructor: Awang Harun Satyana - BPMIGAS, Indonesia</p>
                        <?php print form_radio('course_4','0',$this->validation->set_radio('course_4','0'),'id="course_4"')?>
                        Not Attending
                        <?php print form_radio('course_4',$this->config->item('course_4_member'),$this->validation->set_radio('course_4',$this->config->item('course_4_member')),'class="USD"')?>
                        IPA Member USD <?=number_format($this->config->item('course_4_member')) ?>
                        <?php print form_radio('course_4',$this->config->item('course_4_non_member'),$this->validation->set_radio('course_4',$this->config->item('course_4_non_member')),'class="USD"')?>
                        Non Member USD <?=number_format($this->config->item('course_4_non_member')) ?>
                    </li>

                    <li>
                        <p>Title: <b>Farmins and Farmouts for Explorationist</b><br />
                        Instructor: Peter J. Cockroft, Blue Energy Limited, Australia</p>
                        <?php print form_radio('course_5','0',$this->validation->set_radio('course_5','0'),'id="course_5"')?>
                        Not Attending
                        <?php print form_radio('course_5',$this->config->item('course_5_member'),$this->validation->set_radio('course_5',$this->config->item('course_5_member')),'class="USD"')?>
                        IPA Member USD <?=number_format($this->config->item('course_5_member')) ?>
                        <?php print form_radio('course_5',$this->config->item('course_5_non_member'),$this->validation->set_radio('course_5',$this->config->item('course_5_non_member')),'class="USD"')?>
                        Non Member USD <?=number_format($this->config->item('course_5_non_member')) ?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">Please help IPA by volunteering as Technical Program Judge</div>
                <?=form_label('','judge')?>
                <?=form_radio('judge','yes',$this->validation->set_radio('judge','yes'))?>Yes
                <?=form_radio('judge','no',$this->validation->set_radio('judge','no'))?>No
            </li>
            <li>
                <div class="note" style="background-color:orange;text-align:right;" >[ <span onClick="javascript:calculate();" style="cursor:pointer">click to calculate</span> ] TOTAL CHARGE : <span id="total_idr">0</span> | <span id="total_usd"></span></div>
                <input type="hidden" value="0" name="total_idr" id="h_total_idr" />
                <input type="hidden" value="0" name="total_usd" id="h_total_usd" />
                <input type="hidden" value="0" name="galadinnercurr" id="h_galadinner" />
                <input type="hidden" value="0" name="golfcurr" id="h_golf" />
                <input type="hidden" value="0" name="registrationtype" id="h_registrationtype" />
            </li>
            <li class="submit restricted" style="float:right;<?=($open == false)?'display:none;':'';?>">
            	<div class="buttons">
            		<a href="<?php print base_url() ?>user/profile" class="negative" >
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>

            		<a href="<?php print base_url() ?>user/profile" class="positive" onClick="javascript:alert('Your booking is successfully saved. Please check your email for further detail on registration process.')">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Submit Short Courses Registration
            		</a>
            		
            	</div>
            	<div class="clear"></div>
            </li>
        	<div class="clear"></div>
            <li>
                <div class="note">GROUP REGISTRATION</div>
                <p>
                    To do Group Registration kindly download the Microsoft Excel document from the link below and follow the instructions
                    <br />
                    <a href="<?=base_url()?>public/xls/template.xls">Group Registration Template</a> 
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