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
                
                //print_r($user);
            ?>
       <br /><br /> 
       
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
            Payment for <?=$user['registrationtype']?> at The 35th Annual IPA Convention & Exhibition 2011
        </td>
        <td style="width:5%">
            PAX
        </td>
        <td>
            1
        </td>
        <td style="width:15%:text-align:right">
            <?php print ($user['registrationtype'] == 'Booth Assistant 30' )?'USD 30<br />':''?>
            <?php print ($user['registrationtype'] == 'Booth Assistant 150')?'USD 150<br />':''?>
        </td>
            <td style="width:15%:text-align:right">
            <?php print ($user['registrationtype'] == 'Booth Assistant 30' )?'USD 30<br />':''?>
            <?php print ($user['registrationtype'] == 'Booth Assistant 150')?'USD 150<br />':''?>
        </td>
        <td style="width:15%">
            -
        </td>
    

    <tr>
        <td colspan="4">&nbsp;
            
        </td>
        <td>
            Total
        </td>
        <td style="width:15%:text-align:right">
            <?php print ($user['registrationtype'] == 'Booth Assistant 30' )?'USD 30<br />':''?>
            <?php print ($user['registrationtype'] == 'Booth Assistant 150')?'USD 150<br />':''?>
        </td>
        <td style="width:15%">
            -
        </td>
    

<?php if($tax == true):?>
    <tr>
        <td colspan="4">&nbsp;
            
        </td>
        <td>
            PPN(10%)
        </td>
        <td style="width:15%">
            <?php
                
                if($user['registrationtype'] == 'Booth Assistant 30' ){
                    
                    $ppn = 30*0.1;
                    $total = 30*1.1;
                    
                }elseif($user['registrationtype'] == 'Booth Assistant 150'){
                    $ppn = 150*0.1;
                    $total = 150*1.1;
                }
            ?>
                USD <?php print $ppn;?>
        </td>
        <td style="width:15%">
            -
        </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;
            
        </td>
        <td>
            Total + PPN(10%)
        </td>
        <td style="width:15%:text-align:right">
            USD <?php print $total;?>
        </td>
        <td style="width:15%">
            -
        </td>
    </tr>

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