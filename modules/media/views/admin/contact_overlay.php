<style>
	
	.userdetail { border: 0px; padding: 0px;}
	td { background-color:#EEE; font-size:11px; padding-left:4px; border: 0px;}
    .name { font-size: 18px; font-weight:bold;}
	td a:link {color:#000; text-decoration:none}
	td a:visited {color:#000;}
	td a:hover {color:#666;}
	td a:active {color:#000;}

	td.subheader { text-align:right; background-color:#EEE; color:#7e5252; padding-right: 12px; }
	td.header { text-align:left; background-color:#6a4141; color:#FFF; vertical-align:middle; padding-left: 5px; padding-bottom: 2px; padding-top: 2px; border-bottom:solid #000 2px;}
	td.topheader { text-align:center; background-color:#492121; color:#FFF; vertical-align:top; font-size:13px; padding-top: 10px;}	
	
</style>

<div style="width:725px; height:550px; padding:0px; margin:0px; overflow:auto; text-align:center;">
<table width="700px" class="userdetail">
    <tr>
        <td width="35%" class="topheader" style="background-color: #aaa">
                <span class="name"><?=$user['firstname'].' '.$user['lastname'];?></span><br/>
                <?=$user['company'];?><br /><br />
                <img style="width:120px;height:150px;border:3px solid white" src="<?php print base_url().'public/avatar/'.$user['picture'].'?'.time();?>"><br /><br />
                <img style="width:200px;border:18px solid white" src="<?=base_url().'public/qr/'.$qrfile ?>" alt="QRCode Image" /><br />
				<span class="name"><?=$user['conv_id'];?></span>
				<br />
				<a style="color:white;" target="_blank" href="<?=site_url('/media/admin/media/printbadge'.$regtype.'/'.$user['id'].'/'.time());?>">
                    <?php print $this->bep_assets->icon('printer')?>Print Badge
                </a><br /><br />

                <a style="color:white;" class="invoice" href="<?=site_url('/media/admin/media/invoice/'.$user['id'].'/'.time());?>">
                    <?php print $this->bep_assets->icon('printer')?>Print Invoice
                </a><br />

                <a style="color:white;" class="receipt" href="<?=site_url('/media/admin/media/receipt/'.$user['id'].'/'.time());?>">
                    <?php print $this->bep_assets->icon('printer')?>Print Receipt
                </a><br />
                
        </td>
        
        
        <td width="65%">
        <table width="100%" class="userdetail">
  <tr>
    <td height="25" colspan="2" class="header"><strong>Personal Information</strong></td>
  </tr>
  <tr>
    <td width="40%"><strong>Registration Number</strong></td>
    <td width="60%"><?=$user['conv_id'];?></td>
  </tr>
  <tr>
    <td><strong>Name</strong></td>
    <td><?=$user['salutation'];?> <?=$user['firstname'];?> <?=$user['lastname'];?></td>
  </tr>
  <tr>
    <td><strong>Cellphone</strong></td>
    <td><?=$user['mobile'];?></td>
  </tr>
  <tr>
    <td><strong>E-mail Address</strong></td>
    <td><?=$user['email'];?></td>
  </tr>    
  <tr>
    <td><strong>Nationality</strong></td>
    <td><?=$user['nationality'];?></td>
  </tr>
  <tr>
    <td><strong>Company</strong></td>
    <td><?=$user['company'];?></td>
  </tr>
  <tr>
    <td><strong>Position</strong></td>
    <td><?=$user['position'];?></td>
  </tr>
  <tr>
    <td><strong>Company Address</strong></td>
    <td><?=$user['street'];?>, <?=$user['street2'];?>, <?=$user['city'];?> <?=$user['zip'];?>, <?=$user['country'];?></td>
  </tr>
  <tr>
    <td><strong>Telephone / Fax</strong></td>
    <td><?=$user['phone'];?> / <?=$user['fax'];?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="header"><strong>Convention</strong></td>
  </tr>
  <tr>
    <td>Registration Type</td>
    <td><?=$user['registrationtype'];?></td>
  </tr>
  <tr>
    <td>Volunteering as Judge</td>
    <td><?=ucwords($user['judge']);?></td>
  </tr>
  <tr>
    <td>Participating in Golf</td>
    <td><?=($user['golf'] > 0)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Attending Gala Dinner</td>
    <td><?=($user['galadinner'] > 0)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Attending Gala Dinner with a companion</td>
    <td><?=($user['galadinneraux'] > 0)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td height="20" colspan="2" class="header"><strong>Short Courses</strong></td>
  </tr>
  <tr>
    <td>Attending Short Course 1</td>
    <td><?=($user['course_1'] > 0)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Attending Short Course 2</td>
    <td><?=($user['course_2'] > 0)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Attending Short Course 3</td>
    <td><?=($user['course_3'] > 0)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Attending Short Course 4</td>
    <td><?=($user['course_4'] > 0)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Attending Short Course 5</td>
    <td><?=($user['course_5'] > 0)?'Yes':'No';?></td>
  </tr> 
  <tr>
    <td height="20" colspan="2" class="header"><strong>Miscellaneous Details</strong></td>
  </tr>
  <tr>
    <td>Registered as Exhibitor</td>
    <td><?=($user['exhibitor'] == 1)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Registered as Exhibitor's Entitlement</td>
    <td><?=($user['foc'] == 1)?'Yes':'No';?></td>
  </tr>
  <tr>
    <td>Registered as Media</td>
    <td><?=($user['media'] == 1)?'Yes':'No';?></td>
  </tr>
<!--  <tr>
    <td height="20" colspan="2" class="header"><strong>Total Fee(s)</strong></td>
  </tr>
  <tr>
    <td>Convention Registration</td>
    <td>USD <?=$user['total_usd'];?> | IDR <?=$user['total_idr'];?> </td>
  </tr>
  <tr>
    <td>Short Courses Registration</td>
    <td>USD <?=$user['total_usd_sc'];?> | IDR <?=$user['total_idr_sc'];?></td>
  </tr>-->
</table>
		
        </td>
    </tr>
</table>
</div>


