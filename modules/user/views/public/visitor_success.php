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
<?php print form_open('register/visitor/',array('class'=>'horizontal'))?>
    <fieldset>
        <table>
            <tr>
                <td style="padding:5px;">
                    <div id="picture" style="width:120px;height:150px;border:thin solid grey;">
                    <img style="width:120px;height:150px;" src="<?php print base_url().'public/avatar/'.$userdata['picture'].'?'.time();?>">
                    
                    </div>
                    <?php if(!$is_print):?>
                        <?=anchor('user/changepicvis/'.$user['id'],'Change My Picture');?><br />
                        <?=anchor('/media/snappicvis/'.$userdata['id'].'/'.time(),'Take My Picture','class="snappic"');?> <span class="annotation">( requires camera / webcam installed )</span><br />
                        <script>
                            $("a.snappic").fancybox({ 
                                'hideOnContentClick': false,
                                'showCloseButton': true,
                                'frameWidth' : 800,
                                'frameHeight' : 500,
                            });
                        </script>
                    <?php endif;?>
                </td>
                <td style="vertical-align:top;">
                    <ol>
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
                            <label for="email"><?php print $this->lang->line('userlib_email')?> :*</label>
                            <?=$userdata['email']?>
                        </li>
                    </ol>
                </td>
            </tr>
        </table>
        <ol style="font-size:1em">
            <li>
                <div class="note">Company Information</div>
                <?php print form_label('Company :','company')?>
                <?=$userdata['company']?>
            </li>
            <li>
                <?php print form_label('Telephone* :','phone')?>
                <?=$userdata['phone']?>
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
        </ol>
    </fieldset>
<?php print form_close()?>
<table style="border:thin solid #eee;margin-top:20px;">
    <tr >
        <td  style="width:50%;vertical-align:middle;text-align:center;padding:15px;"><img width="255" src="<?=base_url().'public/qr/'.$qrfile.'?'.time() ?>" alt="QRCode Image" /></td>
        <td  style="width:50%;vertical-align:top;padding:15px">
            <ul style="list-style-type:none;font-size:14px;line-height:1.5em;margin-top:20px;">
                <li>
                    <div id="picture" style="width:120px;height:150px;border:thin solid grey;">
                    <img style="width:120px;height:150px;" src="<?php print base_url().'public/avatar/'.$userdata['picture'];?>">
                    
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
        //printWindow();
        //window.close();
    </script>
<?php endif ?>
<?php
    if($is_print){
        $this->load->view($this->config->item('backendpro_template_public') . 'print_footer');
    }else{
        ?>
<?php // anchor('user/pdf','Download PDF')?>&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight:bold;cursor:pointer;text-decoration:none;color:maroon;" onClick="javascript:pop_print();"><?php print $this->bep_assets->icon('printer');?> Print</span>
<a target="_blank" href="<?=site_url('/media/printbadgevis/'.$userdata['id'].'/'.time());?>">
    <?php print $this->bep_assets->icon('printer')?>Print Badge
</a><br />

<script language="javascript">
function pop_print(){
    window.open("<?=base_url();?>/user/pvis/<?=$userdata['id']?>","Print Badge","menubar=no,width=800,height=1024,scrollbars=1,toolbar=no");
}
</script>
        <?php
    }
?>

