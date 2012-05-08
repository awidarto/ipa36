
<table style="border:thin solid #eee;">
    <tr >
        <td  style="width:50%;"><img src="<?=base_url().'public/qr/'.$qrfile ?>" style="width:300px;height:300px;" alt="QRCode Image" /></td>
        <td  style="width:50%;vertical-align:top;padding:15px">
            <ul style="list-style-type:none;font-size:14px;">
                <li style="list-style-type:none;font-size:16px;font-weight:bold;"><?=$userdata['fullname']?></li>
                <li style="list-style-type:none;font-size:14px;"><?=$userdata['email']?></li>
                <li style="list-style-type:none;font-size:16px;"><?=$userdata['company']?></li>
            </ul>
        </td>
    </tr>
</table>
<?=anchor(base_url().'public/qr/'.$qrpdf,'Download PDF')?>&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight:bold;cursor:pointer;text-decoration:underline;color:maroon;" onClick="javascript:pop_print();">Print</span>
<script language="javascript">
function pop_print(){
    window.open("user/pv","Print Badge","menubar=no,width=400,height=500,toolbar=no");
}
</script>