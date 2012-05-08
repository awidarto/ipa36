<style>
    td {

		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
    }
</style>

<table style="width:800px;height:500px;" border="1" bordercolor="#000000" cellspacing="0">
    <tr>
        <td colspan="7" valign="top">
            <h4>PT. FASEN CREATIVE QUALITY</h4>
            Jl. Bangka Raya No. 98, Pela Mampang<br />
            Jakarta Selatan - Indonesia - 12410<br />
            Tel. 021-7179-2480 | Fax. 021-719-1422<br />
            E-mail: oelay77@quadevent.com<br />
            Website: www.quadevent.com</td>
    
    <tr>
        <td colspan="7" style="text-align:center;height:45px">
            <h2>INVOICE</h2>
            Date : <?php print date('d-m-Y',time())?>
        </td>
    
    <tr>
      <td colspan="7" style="width:55%">
        Bill To :<br />
        <?php
                print $user['firstname'].' '.$user['lastname'].'<br />';
                print $user['company'].'<br />';
                print $user['street'].'<br />';
                print $user['city'].'<br />';
                print $user['zip'].'<br />';
                print $user['country'].'<br />';
                
                //print_r($user);
            ?>
       <br /><br /> </td>
    
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
    

<?php if($tax == true):?>
    <tr>
        <td colspan="4">&nbsp;
            
        </td>
        <td>
            PPN(10%)
        </td>
        <td style="width:15%">
            <?php print ($user['total_usd'] == 0)?'':'USD '.$user['total_usd']*0.1.'<br />'?>
        </td>
        <td style="width:15%">
            <?php print ($user['total_idr'] == 0)?'':'IDR '.$user['total_idr']*0.1.'<br />'?>
        </td>
    
    <tr>
        <td colspan="4">&nbsp;
            
        </td>
        <td>
            PPN(10%)
        </td>
        <td style="width:15%">
            <?php print ($user['total_usd'] == 0)?'':'USD '.$user['total_usd']*1.1.'<br />'?>
        </td>
        <td style="width:15%">
            <?php print ($user['total_idr'] == 0)?'':'IDR '.$user['total_idr']*1.1.'<br />'?>
        </td>
    

<?php endif;?>

    
</table>

    <script language=javascript>
        function printWindow() {
            bV = parseInt(navigator.appVersion);
            if (bV >= 4) window.print();
        }
        printWindow();
        window.close();
    </script>