<?php if($is_print):?>
    <?php $this->load->view($this->config->item('backendpro_template_public') . 'print_header');?>
    <h3><?php print $header?></h3>
    <style>
        body { margin: 5px 15px;}
    </style>
<?php else:?>
    <h3><?php print $header?></h3>
<?php endif;?>


<!--
<ol class="form_nav">
    <li class="current_form">Personal Information & Main Registration</li>
</ol>
<div class="clear"></div>
-->
<?php print form_open('register/individual/',array('class'=>'horizontal'))?>
    <fieldset>
        <table>
            <tr>
                <td style="padding:5px;">
                    <div id="picture" style="width:120px;height:150px;border:thin solid grey;">
                    <?php if(is_user()): ?>
                        <img style="width:120px;height:150px;" src="<?php print base_url().'public/avatar/'.$userdata['picture'].'?'.time();?>">
                    <?php endif;?>
                    
                    </div>
                    <?php if(!$is_print):?>
                        <?=anchor('user/changepic','Change My Picture');?><br />
                        <?=anchor('/media/admin/media/snappic/'.$userdata['id'].'/'.time(),'Take My Picture','class="snappic"');?> <span class="annotation">( requires camera / webcam installed )</span><br />
                        <script>
                            $("a.snappic").fancybox({ 
                                'hideOnContentClick': false,
                                'showCloseButton': true,
                                'frameWidth' : 800,
                                'frameHeight' : 500,
                            });
                        </script>
                        <?=anchor('user/profile/update','Update My Profile');?><br />
                        <?=anchor('user/changepass','Change My Password');?>
                    <?php endif;?>
                </td>
                <td style="vertical-align:top;">
                    <ol>
                        <?php if($userdata['conv_seq'] > 0 || $userdata['sc_seq'] > 0) : ?>
                        <li>
                            <?php print form_label('Registration Number :','reg_number')?>
                            <span style="font-size:14px;font-weight:bold;"><?=$userdata['conv_id']?></span>
                        </li>
                        <?php endif;?>
                        <li>
                            <?php print form_label('Salutation :','salutation')?>
                            <?=$userdata['salutation']?>
                        </li>
                        <li>
                            <?php print form_label('First Name :','firstname')?>
                            <?=$userdata['firstname']?>
                        </li>
                        <li>
                            <?php print form_label('Last Name :','lastname')?>
                            <?=$userdata['lastname']?>
                        </li>
                        <li>
                            <?php print form_label('Nationality :','nationality')?>
                            <?=$userdata['nationality']?>
                        </li>
                        <li>
                            <label for="email"><?php print $this->lang->line('userlib_email')?> :*</label>
                            <?=$userdata['email']?>
                        </li>
                    <!--
                        <li>
                            <?php print form_label('Cellphone :*','mobile')?>
                            <?=$userdata['mobile']?>
                        </li>
                    -->
                    </ol>
                </td>
            </tr>
        </table>
        <ol style="font-size:1em">
            <li>
                <div class="note">To be used to create your account on 35th IPA Convention & Exhibition Registration 2011 site</div>
                <label for="username"><?php print $this->lang->line('userlib_username')?> :*</label>
                <?=$userdata['username']?>
            </li>
            <li class="annotation">Use username and password to login and update your registration information</li>
            <li>
                <div class="note">Company Information</div>
                <?php print form_label('Company :','company')?>
                <?=$userdata['company']?>
            </li>
            <li>
                <?php print form_label('Position :','position')?>
                <?=$userdata['position']?>
            </li>
            <li>
                <?php print form_label('Telephone* :','phone')?>
                <?=$userdata['phone']?>
            </li>
            <li>
                <?php print form_label('Fax* :','fax')?>
                <?=$userdata['fax']?>
            </li>
            <li>
                <?php print form_label('Address 1 :','street')?>
                <?=$userdata['street']?>
            </li>
            <li>
                <?php print form_label('Address 2 :','street2')?>
                <?=$userdata['street2']?>
            </li>
            <li>
                <?php print form_label('City :','city')?>
                <?=$userdata['city']?>
            </li>
            <li>
                <?php print form_label('ZIP :','zip')?>
                <?=$userdata['zip']?>
            </li>
            <li>
                <?php print form_label('Country :','country')?>
                <?=$userdata['country']?>
            </li>
<!--
            <li>
                <div class="note">Expo Packages</div>
                <?php print form_label('Registration Type :','registrationtype')?>
                <?=$userdata['registrationtype']?>
                <?=($userdata['ipaid'] != '' AND ($userdata['registrationtype'] == 'Member Overseas' OR $userdata['registrationtype'] == 'Member Domestic'))?'[ IPA Membership Id :'.$userdata['ipaid'].' ]':'';?>
            </li>
            <li>
                <?php print form_label('Registration Fee :','registertype')?>
                <?=($userdata['registrationtype'] == 'Member Overseas' OR $userdata['registrationtype'] == 'Non Member Overseas' OR $userdata['registrationtype'] == 'Student Overseas')?'USD':'IDR';?>
                <?=number_format($userdata['registertype'])?>
                
            </li>
            <li>
                <?php print form_label('Additional Booth Assistant:','boothassistant')?>
                <?=($userdata['boothassistant'])?'USD '.number_format($this->config->item('boothassistant')):'No' ?> 
            </li>
            <li>
                <div class="note">Volunteering as Technical Program Judge</div>
                <?=form_label('','judge')?><?=$userdata['judge']?>
            </li>
            <li>
                <div class="note">SHORT COURSES | Hotel Mulia, 16 - 17 May 2011</div>
                <ol style="margin-left:40px;" class="shortcourse">
                    <li>
                        <p>Title: Integrated Production Optimization for Oil and Gas Fields<br />
                        Instructor: Dr. Tutuka Ariadji, Petroleum Engineering Department, Institute of Technology Bandung</p>
                        <?=($userdata['course_1'] == 0)?'Not Attending':'USD '.number_format($userdata['course_1'])?>
                    </li>

                    <li>
                        <p>Title: Petroleum Geochemistry: A Quest for Oil and Gas<br />
                        Instructor: Awang Harun Satyana, BPMIGAS, Indonesia</p>
                        <?=($userdata['course_2'] == 0)?'Not Attending':'USD '.number_format($userdata['course_2'])?>
                    </li>

                    <li>
                        <p>Title: Understanding the Indonesian Upstream Oil and gas Industry<br />
                        Instructor: Dr. H.L. Ong, Lecturer, Institute of Technology Bandung and Advisor to PT. Geoservices</p>
                        <?=($userdata['course_3'] == 0)?'Not Attending':'USD '.number_format($userdata['course_3'])?>
                    </li>

                    <li>
                        <p>Title: Farmins and Farmouts for Explorationist<br />
                        Instructor: Peter J. Cockroft, Blue Energy Limited, Australia</p>
                        <?=($userdata['course_4'] == 0)?'Not Attending':'USD '.number_format($userdata['course_4'])?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">GOLF | May 18th 2011, 6.30 AM</div>
                <ol style="margin-left:40px;" class="shortcourse">
                    <li>
                        <p>Venue : Royale Halim, Jakarta</p>
                        <?=($userdata['golf'] == 0)?'Not Attending':$userdata['golfcurr'].' '.number_format($userdata['golf'])?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">GALA DINNER | May 18th 2011, 7 PM</div>
                <ol style="margin-left:40px;" class="shortcourse">
                    <li>
                        <p>Venue : Ballroom Hotel Mulia, Senayan</p>
                        <?=($userdata['galadinner'] == 0)?'Not Attending':$userdata['galadinnercurr'].' '.number_format($userdata['galadinner'])?>
                        
                    </li>
                </ol>
            </li>
            <li>
                <div class="note" style="background-color:orange;text-align:right;" >TOTAL CHARGE : <span id="total_idr">IDR <?=number_format($userdata['total_idr'])?></span> & <span id="total_usd">USD <?=number_format($userdata['total_usd'])?></span></div>
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
-->

        </ol>
    </fieldset>
<?php print form_close()?>
<table style="border:thin solid #eee;margin-top:20px;">
    <tr >
        <td  style="width:50%;vertical-align:middle;text-align:center;padding:15px;"><img width="255" src="<?=($is_print)?$qrfile:base_url().'public/qr/'.$qrfile.'?'.time() ?>" alt="QRCode Image" /></td>
        <td  style="width:50%;vertical-align:top;padding:15px">
            <ul style="list-style-type:none;font-size:14px;line-height:1.5em;margin-top:20px;">
                <li>
                    <div id="picture" style="width:120px;height:150px;border:thin solid grey;">
                    <?php if(is_user()): ?>
                        <img style="width:120px;height:150px;" src="<?php print base_url().'public/avatar/'.$userdata['picture'];?>">
                    <?php endif;?>
                    
                    </div>
                </li>
                <li>&nbsp;</li>
                <li style="list-style-type:none;font-size:16px;font-weight:bold;"><?=$userdata['fullname']?></li>
                <li style="list-style-type:none;font-size:14px;"><?=$userdata['email']?></li>
                <li style="list-style-type:none;font-size:16px;"><?=$userdata['company']?></li>
            </ul>
        </td>
    </tr>
</table>
<?php if($is_print): ?>
    <script language=javascript>
        function printWindow() {
            bV = parseInt(navigator.appVersion);
            if (bV >= 4) window.print();
        }
        printWindow();
        window.close();
    </script>
<?php endif ?>
<?php
    if($is_print){
        $this->load->view($this->config->item('backendpro_template_public') . 'print_footer');
    }else{
        ?>
<?php // anchor('user/pdf','Download PDF')?>&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight:bold;cursor:pointer;text-decoration:none;color:maroon;" onClick="javascript:pop_print();"><?php print $this->bep_assets->icon('printer');?> Print</span>
<script language="javascript">
function pop_print(){
    window.open("<?=base_url();?>/user/pv/<?=$userdata['id']?>","Print Badge","menubar=no,width=800,height=1024,scrollbars=1,toolbar=no");
}
</script>
        <?php
    }
?>

