<table style="border:none;font-family:sans-serif,lucida">
    <tr >
        <td  style="width:300px;text-align:center;"><img src="<?=$qrfile ?>" style="width:300px;height:300px;" alt="QRCode Image" /></td>
    </tr>
    <tr>
        <td  style="width:300px;vertical-align:top;padding:15px">
            <ul style="list-style-type:none;font-size:14px;margin-left:5px;text-align:left;padding:0px">
                <li style="list-style-type:none;font-size:16px;font-weight:bold;"><?=$userdata['fullname']?></li>
                <li style="list-style-type:none;font-size:14px;"><?=$userdata['email']?></li>
                <li style="list-style-type:none;font-size:16px;"><?=$userdata['company']?></li>
            </ul>
        </td>
    </tr>
</table>
<?php if($is_print):?>
    <script language=javascript>
        function printWindow() {
            bV = parseInt(navigator.appVersion);
            if (bV >= 4) window.print();
        }
        printWindow();
    </script>
<?php endif;?>