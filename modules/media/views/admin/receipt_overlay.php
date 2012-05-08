<style>
    td {
        font-weight:bold;
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
    }
</style>

<table style="width:800px;height:500px;" border="1" bordercolor="#000000" cellspacing="0">
    <tr>
        <td colspan="7">
            <h4>PT. FASEN CREATIVE QUALITY</h4>
            Jl. Bangka Raya No. 98, Pela Mampang<br />
            Jakarta Selatan - Indonesia - 12410<br />
            Tel. 021-7179-2480 | Fax. 021-719-1422<br />
            E-mail: oelay77@quadevent.com<br />
            Website: www.quadevent.com<br /></td>
        </tr>
    
    <tr>
        <td colspan="7" style="text-align:center;">
            <h2>OFFICIAL RECEIPT</h2>
            Date : <?php print date('d-m-Y',time())?>
        </td>
    
    <tr>
      <td colspan="7" style="width:55%;height:160px;">
        Received from:<br />
        <?php
                print $user['firstname'].' '.$user['lastname'].'<br />';
                print $user['company'].'<br />';
                print $user['street'].'<br />';
                print $user['city'].'<br />';
                print $user['zip'].'<br />';
                print $user['country'].'<br />';
                
                //print_r($user);
            ?>
        </td>
    
    <tr id="head">
        <td style="width:5%">
            No.
        </td>
        <td>
            Description
        </td>
        <td style="width:5%">
            Unit
        </td>
        <td>
            Quantity
        </td>
        <td style="width:15%">
            Unit Price
        </td>
        <td style="width:15%">
            Amount ( USD )
        </td>
        <td style="width:15%">
            Amount ( IDR )
        </td>
    

    <tr>
        <td style="width:5%">
            1
        </td>
        <td>
            Payment for Participant at The 35th Annual IPA Convention & Exhibition 2011
        </td>
        <td style="width:5%">
            PAX
        </td>
        <td>
            1
        </td>
        <td>
            <?php print ($user['total_usd'] == 0)?'':'USD '.$user['total_usd'].'<br />'?>
            <?php print ($user['total_idr'] == 0)?'':'IDR '.$user['total_idr'].'<br />'?>
        </td>
        <td style="width:15%">
            <?php print ($user['total_usd'] == 0)?'':'USD '.$user['total_usd'].'<br />'?>
        </td>
        <td style="width:15%">
            <?php print ($user['total_idr'] == 0)?'':'IDR '.$user['total_idr'].'<br />'?>
        </td>
    

    <tr>
        <td colspan="4">&nbsp;
            
        </td>
        <td>
            Total
        </td>
        <td style="width:15%">
            <?php print ($user['total_usd'] == 0)?'':'USD '.$user['total_usd'].'<br />'?>
        </td>
        <td style="width:15%">
            <?php print ($user['total_idr'] == 0)?'':'IDR '.$user['total_idr'].'<br />'?>
        </td>
    

    <tr>
        <td colspan="4">&nbsp;
            
        </td>
        <td>
            <input type="checkbox" id="ppn" value="yes" />Add PPN(10%) 
        </td>
        <td style="width:15%">
        </td>
        <td style="width:15%">
            <span style="cursor:pointer;" onClick="javascript:printReceipt()"><?php print $this->bep_assets->icon('printer')?> Print Receipt</span>
        </td>
    

</table>

<script>
    function printReceipt(){
        var ppn;
        if($('#ppn:checked').val() !== undefined){
            ppn = "yes";
        }else{
            ppn = "no";
        }
        window.open('<?=base_url();?>media/admin/media/printreceipt/<?=$user['id']?>/'+ppn+'/<?=time();?>', '_blank', 'width=800,height=600,scrollbars=yes,status=no,resizable=no,screenx=100,screeny=100');
    }
</script>
