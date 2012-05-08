<style>
body {margin-bottom: 0px; margin-left: 0px; margin-right: 0px; margin-top: 0px;}

table.badge {
	border-width: 0px;
	border-spacing: 0px;
	border-style: solid;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
table.badge th {
	border-width: 0px;
	padding: 0px;
	border-style: inset;
}
table.badge td {
	border-width: 0px;
	padding: 0px;
	border-style: inset;
	border-color: gray;
}
    .name { font-size: 12px; font-weight:bold; text-transform: uppercase; font-family: “Myriad Pro”, Arial, Helvetica, Tahoma, sans-serif;}
	.company { font-size: 10px; font-weight:bold; text-transform: uppercase; font-family: “Myriad Pro”, Arial, Helvetica, Tahoma, sans-serif;}
</style>



<table width="510" class="badge">
  <tr>
    <td width="255" height="164"><img src="<?php print base_url();?>images/trans.gif" width="255" height="164" /></td>
    <td width="255" rowspan="5" align="center" valign="middle"><img style="width:200px;" src="<?=base_url().'public/qr/'.$qrfile ?>" alt="QRCode Image" />
    <br />
    <span class="name"><?=$user['conv_id'];?></span></td>
  </tr>
  <tr>
    <td height="113" align="center" valign="middle"><img style="width:85px;height:113px;" src="<?php print base_url().'public/avatar/'.$user['picture'].'?'.time();?>"></td>
  </tr>
  <tr>
    <td height="15"><img src="<?=base_url();?>images/trans.gif" width="255" height="15" /></td>
  </tr>
  <tr>
    <td width="255" height="62" align="center" valign="middle">
    <span class="name"><?=$user['salutation'];?> <?=$user['firstname'];?> <?=$user['lastname'];?></span><br />
    <span class="company"><?=$user['company'];?></span>
    
    </td>
  </tr>
  <tr>
    <td width="255" height="43" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>

<script language=javascript>
    function printWindow() {
        bV = parseInt(navigator.appVersion);
        if (bV >= 4) window.print();
    }
    printWindow();
    window.close();
</script>
