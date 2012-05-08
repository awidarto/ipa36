<h3><?php print $header?></h3>
<!--
<ol class="form_nav">
    <li class="current_form">Personal Information & Main Registration</li>
</ol>
<div class="clear"></div>
-->
<script language="javascript">

    var sc_lock = <?=$sc_lock?>;

    function validateConv(){
        if(jQuery('input[name=registertype]:radio:checked').val() == null){
            var ans = confirm('Please specify your convention registration type');
            if(ans == true){
                
            }
        }
    }

    function calculateSC(){
        var total_idr_sc = 0;
        var total_usd_sc = 0;

        var total_idr = 0;
        var total_usd = 0;
        
        if(jQuery('input[name=registertype]:radio:checked').attr('class') == 'USD'){
            total_usd += parseInt(jQuery('input[name=registertype]:radio:checked').val()); 
        }else{
            total_idr += parseInt(jQuery('input[name=registertype]:radio:checked').val()); 
        }

        if(jQuery('input[name=golf]:radio:checked').val() != null){
            if(jQuery('input[name=golf]:radio:checked').attr('class') == 'USD'){
                total_usd += parseInt(jQuery('input[name=golf]:radio:checked').val()); 
            }else{
                total_idr += parseInt(jQuery('input[name=golf]:radio:checked').val()); 
            }
        }

        if(jQuery('input[name=galadinner]:radio:checked').val() != null){
            if(jQuery('input[name=galadinner]:radio:checked').attr('class') == 'USD'){
                total_usd += parseInt(jQuery('input[name=galadinner]:radio:checked').val()); 
            }else{
                total_idr += parseInt(jQuery('input[name=galadinner]:radio:checked').val()); 
            }
        }
        
        if(jQuery('input[name=course_1]:radio:checked').val() != null){
            if(jQuery('input[name=course_1]:radio:checked').attr('class') == 'USD'){
                total_usd_sc += parseInt(jQuery('input[name=course_1]:radio:checked').val()); 
            }else{
                total_idr_sc += parseInt(jQuery('input[name=course_1]:radio:checked').val()); 
            }
        }
        
        if(jQuery('input[name=course_2]:radio:checked').val() != null){
            if(jQuery('input[name=course_2]:radio:checked').attr('class') == 'USD'){
                total_usd_sc += parseInt(jQuery('input[name=course_2]:radio:checked').val()); 
            }else{
                total_idr_sc += parseInt(jQuery('input[name=course_2]:radio:checked').val()); 
            }
        }

        if(jQuery('input[name=course_3]:radio:checked').val() != null){
            if(jQuery('input[name=course_3]:radio:checked').attr('class') == 'USD'){
                total_usd_sc += parseInt(jQuery('input[name=course_3]:radio:checked').val()); 
            }else{
                total_idr_sc += parseInt(jQuery('input[name=course_3]:radio:checked').val()); 
            }
        }

        if(jQuery('input[name=course_4]:radio:checked').val() != null){
            if(jQuery('input[name=course_4]:radio:checked').attr('class') == 'USD'){
                total_usd_sc += parseInt(jQuery('input[name=course_4]:radio:checked').val()); 
            }else{
                total_idr_sc += parseInt(jQuery('input[name=course_4]:radio:checked').val()); 
            }
        }


        if(jQuery('input[name=course_5]:radio:checked').val() != null){
            if(jQuery('input[name=course_5]:radio:checked').attr('class') == 'USD'){
                total_usd_sc += parseInt(jQuery('input[name=course_5]:radio:checked').val()); 
            }else{
                total_idr_sc += parseInt(jQuery('input[name=course_5]:radio:checked').val()); 
            }
        }
        
        jQuery('#total_idr').html('IDR '+total_idr);
        jQuery('#total_usd').html('USD '+total_usd);
        jQuery('#total_idr_sc').html('IDR '+total_idr_sc);
        jQuery('#total_usd_sc').html('USD '+total_usd_sc);

        
        jQuery('#h_total_idr').val(total_idr);
        jQuery('#h_total_usd').val(total_usd);

        jQuery('#h_total_idr_sc').val(total_idr_sc);
        jQuery('#h_total_usd_sc').val(total_usd_sc);

        jQuery('#h_galadinner').val(jQuery('input[name=galadinner]:radio:checked').attr('class'));
        jQuery('#h_golf').val(jQuery('input[name=golf]:radio:checked').attr('class'));
        jQuery('#h_registrationtype').val(jQuery('input[name=registertype]:radio:checked').attr('rel'));
    }
    
    
    $(document).ready(function() {
        if(sc_lock == 0){
            calculateSC();
        }
        
        jQuery.ajaxSetup( { type: "post" } );
                
        jQuery( "#company" ).autocomplete({
    		source: "<?=base_url()?>register/ajaxcompany",
    		minLength: 2
    	});
        
    });
    
    </script>
    <style>
        ol li h4{
            font-size:14px;
            margin-bottom:8px;
            font-weight:bold;
        }
        
        ol li h4 .ct{
            font-size:12px;
            font-weight:normal;
        }
        
        ol li .na{
            margin-left:25px;
        }
        
    </style>
    
<?php print form_open('register/shortcourses',array('class'=>'horizontal'))?>

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
    
    if($sc_lock == 1){
        $lock = 'disabled';
    }else{
        $lock = '';
    }
    
?>
<?php if($open == true): ?>    
    <style>
        ol.shortcourse li p{
            padding-left:15px;
        }
        ol.shortcourse li table{
            margin-left:15px;
        }
    </style>
    <fieldset>
        <ol>
            <li>
                <div class="annotation">(*) mandatory field</div>
            </li>
            <?php if($conv_id > 0): ?>
            <!--
                <li>
                    <span style="font-weight:bold;font-size:18px;">Registration Number : <?php print $conv_id;?></span>
                </li>
            -->
            <?php endif;?>
            <li>
                <div class="note">SHORT COURSES | Hotel Mulia, 16 - 17 May 2011</div>
                <ol style="margin-left:200px;list-style-type:decimal;list-style-position: outside;" class="shortcourse">
                    <li>
                        <h4>1. Real Time Technologies for On-Time Drilling Operations</h4>
                          <p>Samit Sengupta & Dr. Julian Pickering – Geologix Limited, UK</p>
                          <table>
                              <tr>
                                  <td style="width:200px">
                                      <?php print form_radio('course_1',$this->config->item('course_1_member'),$this->validation->set_radio('course_1',$this->config->item('course_1_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                      IPA Member USD <?=number_format($this->config->item('course_1_member')) ?>
                                  </td>
                                  <td style="width:200px">
                                      <?php print form_radio('course_1',$this->config->item('course_1_non_member'),$this->validation->set_radio('course_1',$this->config->item('course_1_non_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                      Non Member USD <?=number_format($this->config->item('course_1_non_member')) ?>
                                  </td>
                                  <td style="width:200px">
                                      <?php print form_radio('course_1','0',$this->validation->set_radio('course_1','0'),'class="na" id="course_1" onClick="javascript:calculateSC();" '.$lock)?>
                                      Not Attending
                                  </td>
                              </tr>
                          </table>
                    </li>

                    <li>
                        <h4>2. Production Optimization Using Nodal System, Analysis: An Integrated Approach</h4>
                        <p>Tutuka Ariadji, MSc., PhD. - Petroleum Engineering Dept., ITB</p>
                        <table>
                            <tr>
                                <td style="width:200px">
                                    <?php print form_radio('course_2',$this->config->item('course_2_member'),$this->validation->set_radio('course_2',$this->config->item('course_2_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                    IPA Member USD <?=number_format($this->config->item('course_2_member')) ?>
                                </td>
                                <td style="width:200px">
                                    <?php print form_radio('course_2',$this->config->item('course_2_non_member'),$this->validation->set_radio('course_2',$this->config->item('course_2_non_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                    Non Member USD <?=number_format($this->config->item('course_2_non_member')) ?>
                                </td>
                                <td style="width:200px">
                                    <?php print form_radio('course_2','0',$this->validation->set_radio('course_2','0'),'class="na" id="course_2" onClick="javascript:calculateSC();" '.$lock)?>
                                    Not Attending
                                </td>
                            </tr>
                        </table>
                    </li>

                    <li>
                        <h4>3. Pressure Data for Exploration Success</h4>
                        <p>Steve O’Connor - GeoPressure Technology Limited, UK</p>
                          <table>
                              <tr>
                                  <td style="width:200px">
                                      <?php print form_radio('course_3',$this->config->item('course_3_member'),$this->validation->set_radio('course_3',$this->config->item('course_3_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                      IPA Member USD <?=number_format($this->config->item('course_3_member')) ?>
                                  </td>
                                  <td style="width:200px">
                                      <?php print form_radio('course_3',$this->config->item('course_3_non_member'),$this->validation->set_radio('course_3',$this->config->item('course_3_non_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                      Non Member USD <?=number_format($this->config->item('course_3_non_member')) ?>
                                  </td>
                                  <td style="width:200px">
                                      <?php print form_radio('course_3','0',$this->validation->set_radio('course_3','0'),'class="na" id="course_3" onClick="javascript:calculateSC();" '.$lock)?>
                                      Not Attending
                                  </td>
                              </tr>
                          </table>
                    </li>

                    <li>
                        <h4>4. Petroleum Geochemistry: A Quest for Oil and Gas</h4>
                        <p>Awang Harun Satyana - BPMIGAS, Indonesia</p>
                          <table>
                              <tr>
                                  <td style="width:200px">
                                      <?php print form_radio('course_4',$this->config->item('course_4_member'),$this->validation->set_radio('course_4',$this->config->item('course_4_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                      IPA Member USD <?=number_format($this->config->item('course_4_member')) ?>
                                  </td>
                                  <td style="width:200px">
                                      <?php print form_radio('course_4',$this->config->item('course_4_non_member'),$this->validation->set_radio('course_4',$this->config->item('course_4_non_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                      Non Member USD <?=number_format($this->config->item('course_4_non_member')) ?>
                                  </td>
                                  <td style="width:200px">
                                      <?php print form_radio('course_4','0',$this->validation->set_radio('course_4','0'),'class="na" id="course_4" onClick="javascript:calculateSC();" '.$lock)?>
                                      Not Attending
                                  </td>
                              </tr>
                          </table>
                    </li>

                    <li>
                        <h4>
                            5. Farmins and Farmouts for Explorationist
                        </h4>
                        <p>
                            Peter J. Cockroft, Blue Energy Limited, Australia
                        </p>
                        <table>
                            <tr>
                                <td style="width:200px">
                                    <?php print form_radio('course_5',$this->config->item('course_5_member'),$this->validation->set_radio('course_5',$this->config->item('course_5_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                    IPA Member USD <?=number_format($this->config->item('course_5_member')) ?>
                                </td>
                                <td style="width:200px">
                                    <?php print form_radio('course_5',$this->config->item('course_5_non_member'),$this->validation->set_radio('course_5',$this->config->item('course_5_non_member')),'class="USD" onClick="javascript:calculateSC();" '.$lock)?>
                                    Non Member USD <?=number_format($this->config->item('course_5_non_member')) ?>
                                </td>
                                <td style="width:200px">
                                    <?php print form_radio('course_5','0',$this->validation->set_radio('course_5','0'),'class="na" id="course_5" onClick="javascript:calculateSC();" '.$lock)?>
                                    Not Attending
                                </td>
                            </tr>
                        </table>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note" style="background-color:black;text-align:right;" >TOTAL SHORT COURSES CHARGE : <span id="total_idr_sc"><?=$total_idr_sc;?></span> | <span id="total_usd_sc"><?=$total_usd_sc;?></span></div>
                <input type="hidden" value="0" name="total_idr_sc" id="h_total_idr_sc" />
                <input type="hidden" value="0" name="total_usd_sc" id="h_total_usd_sc" />
                <input type="hidden" value="0" name="registrationtype" id="h_registrationtype" />
                <input type="hidden" value="<?=$conv_id;?>" name="conv_id" id="conv_id" />
            </li>
            
            <?php if($sc_lock != 1):?>
            <li class="submit restricted" style="float:right;<?=($open == false)?'display:none;':'';?>">
            	<div class="buttons">
            		<a href="<?php print base_url() ?>user/profile" class="negative" >
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>

        		    <button type="submit" class="positive" name="submit" value="submitSC" onClick="javascript:calculate();">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Submit Short Courses Registration
            		</button>
            		
            	</div>
            	<div class="clear"></div>
            </li>
            <?php endif;?>
        	<div class="clear"></div>
            <li>
                <div class="note">GROUP REGISTRATION</div>
                <p>
                    To do Group Registration kindly download the Microsoft Excel document from the link below and follow the instructions
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
				<strong>Payment for Short Courses fees can be made directly to IPA account in US Dollars and Indonesian Rupiah by Bank Telegraphic Transfer:</strong>
                <br />
                <table width=100% >
                    <tr>
                        <td>
							Bangkok Bank, Jakarta Branch<br />
							Jln. M.H. Thamrin No. 3, Jakarta 10110, Indonesia<br />
							Account Name: Indonesian Petroleum Association<br />
							US$ Account: 0309-100763-401<br />
							IDR Account: 0309-100763-001<br />
							Swift Code: BKKBIDJA<br />
                        </td>
                    </tr>
                </table>
            </li>

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


        </ol>
    </fieldset>
<?php print form_close()?>