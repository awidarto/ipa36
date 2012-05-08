<table style="border:thin solid #eee;">
    <tr >
        <td  style="width:325px;"><img src="<?=$qrfile ?>" style="width:300px;height:300px;" alt="QRCode Image" /></td>
        <td  style="width:300px;vertical-align:top;padding:15px">
            <ul style="list-style-type:none;font-size:14px;">
                <li style="list-style-type:none;font-size:16px;font-weight:bold;"><?=$userdata['fullname']?></li>
                <li style="list-style-type:none;font-size:14px;"><?=$userdata['email']?></li>
                <li style="list-style-type:none;font-size:16px;"><?=$userdata['company']?></li>
            </ul>
        </td>
    </tr>
</table>