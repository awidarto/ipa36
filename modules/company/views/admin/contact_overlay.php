<style>
    .head{
        font-size:14px;
        font-weight:bold;
    }
</style>
<div style="width:800px;height:500px;padding:0px;margin:0px;">

<table width="90%">
    <tr>
        <td width="40%">
            <ul style="list-style-type:none;">
                <li><span class="head"><?=$user['firstname'].' '.$user['lastname'];?></span></li>
                <li><?=$user['company'];?></li>
                <li><img style="width:120px;height:150px;" src="<?php print base_url().'public/avatar/'.$user['picture'];?>"></li>
                <li><img src="<?//=base_url().'public/qr/'.$qrfile ?>" alt="QRCode Image" /></li>
            </ul>
        </td>
        <td width="60%">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
    <td height="10" colspan="2" align="center" valign="middle" bgcolor="#FF9900">&nbsp;</td>
  </tr>  
  <tr>
    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#FF9933"><strong>Convention</strong></td>
  </tr>
  <tr>
    <td>Registration Type</td>
    <td><?=$user['registrationtype'];?></td>
  </tr>
  <tr>
    <td>Volunteering as Judge</td>
    <td><?=$user['judge'];?></td>
  </tr>
  <tr>
    <td>Participating in Golf</td>
    <td><?=$user['golf'];?></td>
  </tr>
  <tr>
    <td>Attending Gala Dinner</td>
    <td><?=$user['galadinner'];?></td>
  </tr>
  <tr>
    <td>Attending Gala Dinner with a companion</td>
    <td><?=$user['galadinneraux'];?></td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="center" valign="middle" bgcolor="#FF9900">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="center" valign="middle" bgcolor="#FF9900"><strong>Short Courses</strong></td>
  </tr>
  <tr>
    <td>Attending Short Course 1</td>
    <td><?=$user['course_1'];?></td>
  </tr>
  <tr>
    <td>Attending Short Course 2</td>
    <td><?=$user['course_2'];?></td>
  </tr>
  <tr>
    <td>Attending Short Course 3</td>
    <td><?=$user['course_3'];?></td>
  </tr>
  <tr>
    <td>Attending Short Course 4</td>
    <td><?=$user['course_4'];?></td>
  </tr>
  <tr>
    <td>Attending Short Course 5</td>
    <td><?=$user['course_5'];?></td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="center" valign="middle" bgcolor="#FF9900">&nbsp;</td>
  </tr>  
  <tr>
    <td height="20" colspan="2" align="center" valign="middle" bgcolor="#FF9900"><strong>Miscellaneous Details</strong></td>
  </tr>
  <tr>
    <td>Registered as Exhibitor</td>
    <td><?=$user['exhibitor'];?></td>
  </tr>
  <tr>
    <td>Registered as Exhibitor's Entitlement</td>
    <td><?=$user['foc'];?></td>
  </tr>
  <tr>
    <td>Registered as Media</td>
    <td><?=$user['media'];?></td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="center" valign="middle" bgcolor="#FF9900">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="center" valign="middle" bgcolor="#FF9900"><strong>Total Fee(s)</strong></td>
  </tr>
  <tr>
    <td>Convention Registration</td>
    <td>USD <?=$user['total_usd'];?> | IDR <?=$user['total_idr'];?> </td>
  </tr>
  <tr>
    <td>Short Courses Registration</td>
    <td>USD <?=$user['total_usd_sc'];?> | IDR <?=$user['total_idr_sc'];?></td>
  </tr>
</table>
		
        </td>
    </tr>
</table>
</div>

<script>
    function sendComment(){
        $('#sendcomment').show();
        
        $.post("<?php print site_url('user/comment/add'); ?>", 
            { 'uid':'<?php print $uid ?>','commentmessage' : $('#commentmessage').val() },
            function(data){
                loadComment();
            }
        );
        
        $('#sendcomment').hide();
    }
    
    function loadComment(){
        $.post("<?php print site_url('user/comment/get'); ?>", 
            { 'uid':'<?php print $uid ?>'},
            function(data){
                $('#komentarlist').html(data);
            }
        );
    }
    
    function lockUser(){
        $.post("<?php print site_url('user/lock'); ?>", 
            { 'uid':'<?php print $uid ?>'},
            function(data){
                alert(data.result);
            },'json'
        );
    }
</script>

