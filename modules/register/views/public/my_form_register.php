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
<?php print form_open('register/admin/register/user',array('class'=>'horizontal'))?>
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
                <?php print form_label('Nationality :*','nationality')?>
                <?php print form_input('nationality',$this->validation->nationality,'id="nationality" class="text"')?>
            </li>
            <li>
                <?php print form_label('Cellphone :','mobile')?>
                <?php print form_input('mobile',$this->validation->mobile,'id="mobile" class="text"')?>
            </li>
            <?php if($upd == 'update'):?>
                <li>
                    <div class="note">If you do not wish to change your password, please set the password field blank</div>
                    <label for="username"><?php print $this->lang->line('userlib_username')?> :*</label>
                    <?php print $this->validation->username?>
                </li>
            <?php else: ?>
                <li>
                    <div class="note">To be used to create your account on IPA Convention & Exhibition Registration site</div>
                    <label for="username"><?php print $this->lang->line('userlib_username')?> :*</label>
                    <input type="text" name="username" id="username" size="32" class="text" value="<?php print $this->validation->username?>" />
                </li>
                <li>
                    <label for="password"><?php print $this->lang->line('userlib_password')?> :*</label>
                    <input type="password" name="password" id="password" size="32" class="text" />
                    <span class="annotation">Minimum <?php print $this->preference->item('min_password_length')?> characters or more</span>
                </li>
                <li>
                    <label for="confirm_password"><?php print $this->lang->line('userlib_confirm_password')?> *:</label>
                    <input type="password" name="confirm_password" id="confirm_password" size="32" class="text" />
                </li>
            <?php endif;?>
            <li>
                <div class="note">Company Information</div>
                <?php print form_label('Company :*','company')?>
                <?php print form_input('company',$this->validation->company,'id="company" class="text"')?>
            </li>
            <li>
                <?php print form_label('Position :','position')?>
                <?php print form_input('position',$this->validation->position,'id="position" class="text"')?>
            </li>
            <li>
                <?php print form_label('Telephone* :','phone')?>
                <?php print form_input('phone',$this->validation->phone,'id="phone" class="text"')?>
            </li>
            <li>
                <?php print form_label('Fax :','fax')?>
                <?php print form_input('fax',$this->validation->fax,'id="fax" class="text"')?>
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
<!--            
            <li>
                <div class="note">Expo Packages</div>
                <?php print form_label('Registration Type <br />( cost is per person ) :*','registertype')?>
                <ul style="margin-left:200px;">
                    <li>Member (IPA Professional Division's Individual Member)<br />
                        IPA Membership Id <?php print form_input('ipaid',$this->validation->ipaid,'id="ipaid" class="text" style="width:15em;"')?>
                    </li>
                    <li>
                        <?php print form_radio('registertype',$this->config->item('member_domestic'),$this->validation->set_radio('registertype',$this->config->item('member_domestic')),'id="registertype" class="IDR" rel="Member Domestic"')?>
                        Domestic IDR <?=$this->config->item('member_domestic') ?>
                        <?php print form_radio('registertype',$this->config->item('member_overseas'),$this->validation->set_radio('registertype',$this->config->item('member_overseas')),'id="registertype" class="USD" rel="Member Overseas"')?>
                        Overseas USD <?=$this->config->item('member_overseas') ?>
                    </li>
                    <li>Non Member</li>
                    <li>
                        <?php print form_radio('registertype',$this->config->item('non_member_domestic'),$this->validation->set_radio('registertype',$this->config->item('non_member_domestic')),'id="registertype" class="IDR"rel="Non Member Domestic"')?>
                        Domestic IDR <?=$this->config->item('non_member_domestic') ?>
                        <?php print form_radio('registertype',$this->config->item('non_member_overseas'),$this->validation->set_radio('registertype',$this->config->item('non_member_overseas')),'id="registertype" class="USD" rel="Non Member Overseas"')?>
                        Overseas USD <?=$this->config->item('non_member_overseas') ?>
                    </li>
                    <li>Student</li>
                    <li>
                        <?php print form_radio('registertype',$this->config->item('student_domestic'),$this->validation->set_radio('registertype',$this->config->item('student_domestic')),'id="registertype" class="IDR" rel="Student Domestic"')?>
                        Domestic IDR <?=$this->config->item('student_domestic') ?>
                        <?php print form_radio('registertype',$this->config->item('student_overseas'),$this->validation->set_radio('registertype',$this->config->item('student_overseas')),'id="registertype" class="USD" rel="Student Overseas"')?>
                        Overseas USD <?=$this->config->item('student_overseas') ?>
                    </li>
                </ul>
            </li>
            <li>
                <?php print form_label('Additional :','boothassistant')?>
                <?php print form_checkbox('boothassistant',1,$this->validation->set_checkbox('boothassistant','1'),'class="USD"')?>
                Additional Booth Assistant, USD <?=$this->config->item('boothassistant') ?>
            </li>
            <li>
                <div class="note">Please help IPA by volunteering as Technical Program Judge</div>
                <?=form_label('','judge')?>
                <?=form_radio('judge','yes',$this->validation->set_radio('judge','yes'))?>Yes
                <?=form_radio('judge','no',$this->validation->set_radio('judge','no'))?>No
            </li>
            <li>
                <div class="note">SHORT COURSES | Hotel Mulia, 16 - 17 May 2011</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Title: Integrated Production Optimization for Oil and Gas Fields<br />
                        Instructor: Dr. Tutuka Ariadji, Petroleum Engineering Department, Institute of Technology Bandung</p>
                        <?php print form_radio('course_1','0',$this->validation->set_radio('course_1','0'),'id="course_1"')?>
                        Not Attending
                        <?php print form_radio('course_1',$this->config->item('course_1_member'),$this->validation->set_radio('course_1',$this->config->item('course_1_member')),'class="USD"')?>
                        IPA Member USD <?=$this->config->item('course_1_member') ?>
                        <?php print form_radio('course_1',$this->config->item('course_1_non_member'),$this->validation->set_radio('course_1',$this->config->item('course_1_non_member')),'class="USD"')?>
                        Non Member USD <?=$this->config->item('course_1_non_member') ?>
                    </li>

                    <li>
                        <p>Title: Petroleum Geochemistry: A Quest for Oil and Gas<br />
                        Instructor: Awang Harun Satyana, BPMIGAS, Indonesia</p>
                        <?php print form_radio('course_2','0',$this->validation->set_radio('course_2','0'),'id="course_2"')?>
                        Not Attending
                        <?php print form_radio('course_2',$this->config->item('course_2_member'),$this->validation->set_radio('course_2',$this->config->item('course_2_member')),'class="USD"')?>
                        IPA Member USD <?=$this->config->item('course_2_member') ?>
                        <?php print form_radio('course_2',$this->config->item('course_2_non_member'),$this->validation->set_radio('course_2',$this->config->item('course_2_non_member')),'class="USD"')?>
                        Non Member USD <?=$this->config->item('course_2_non_member') ?>
                    </li>

                    <li>
                        <p>Title: Understanding the Indonesian Upstream Oil and gas Industry<br />
                        Instructor: Dr. H.L. Ong, Lecturer, Institute of Technology Bandung and Advisor to PT. Geoservices</p>
                        <?php print form_radio('course_3','0',$this->validation->set_radio('course_3','0'),'id="course_3"')?>
                        Not Attending
                        <?php print form_radio('course_3',$this->config->item('course_3_member'),$this->validation->set_radio('course_3',$this->config->item('course_3_member')),'class="USD"')?>
                        IPA Member USD <?=$this->config->item('course_3_member') ?>
                        <?php print form_radio('course_3',$this->config->item('course_3_non_member'),$this->validation->set_radio('course_3',$this->config->item('course_3_non_member')),'class="USD"')?>
                        Non Member USD <?=$this->config->item('course_3_non_member') ?>
                    </li>

                    <li>
                        <p>Title: Farmins and Farmouts for Explorationist<br />
                        Instructor: Peter J. Cockroft, Blue Energy Limited, Australia</p>
                        <?php print form_radio('course_4','0',$this->validation->set_radio('course_4','0'),'id="course_4"')?>
                        Not Attending
                        <?php print form_radio('course_4',$this->config->item('course_4_member'),$this->validation->set_radio('course_4',$this->config->item('course_4_member')),'class="USD"')?>
                        IPA Member USD <?=$this->config->item('course_4_member') ?>
                        <?php print form_radio('course_4',$this->config->item('course_4_non_member'),$this->validation->set_radio('course_4',$this->config->item('course_4_non_member')),'class="USD"')?>
                        Non Member USD <?=$this->config->item('course_4_non_member') ?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">GOLF | May 18th 2011, 6.30 AM</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Venue : Royale Halim, Jakarta</p>
                        <?php print form_radio('golf','0',$this->validation->set_radio('golf','0'),'id="golf"')?>
                        Not Attending
                        <?php print form_radio('golf',$this->config->item('golf_domestic'),$this->validation->set_radio('golf',$this->config->item('golf_domestic')),'class="IDR"')?>
                        Domestic IDR <?=$this->config->item('golf_domestic') ?>
                        <?php print form_radio('golf',$this->config->item('golf_overseas'),$this->validation->set_radio('golf',$this->config->item('golf_overseas')),'class="USD"')?>
                        Overseas USD <?=$this->config->item('golf_overseas') ?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">GALA DINNER | May 18th 2011, 7 PM</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Venue : Ballroom Hotel Mulia, Senayan</p>
                        <?php print form_radio('galadinner','0',$this->validation->set_radio('galadinner','0'),'id="galadinner"')?>
                        Not Attending
                        <?php print form_radio('galadinner',$this->config->item('galadinner_domestic'),$this->validation->set_radio('galadinner',$this->config->item('galadinner_domestic')),'class="IDR"')?>
                        Domestic IDR <?=$this->config->item('galadinner_domestic') ?>
                        <?php print form_radio('galadinner',$this->config->item('galadinner_overseas'),$this->validation->set_radio('galadinner',$this->config->item('galadinner_overseas')),'class="USD"')?>
                        Overseas USD <?=$this->config->item('galadinner_overseas') ?>
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
                            Beneficiary: PT. FASEN CREATIVE QUALITY<br />
                        </td>
                        <td>
                            <strong>Rupiah Account :</strong><br />
                            Bank Mandiri<br />
                            KCP Jakarta Kemang Selatan<br />
                            A/C 126-00-0602403-7<br />
                            Beneficiary: PT. FASEN CREATIVE QUALITY<br />
                        </td>
                    </tr>
                </table>
            </li>
-->            
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