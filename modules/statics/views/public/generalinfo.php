<style>
    p,h4,h3 {margin-left:10px;}
    ol {margin-left:30px;}
</style>
<h3><?=$header;?></h3>

<?php
    if($this->preference->item('exhibition_registration_date') == '[TBA]'){
        $exhibit = '';
    }else{
        $exhibit = '( Open online '.date('jS F Y H:i:s',strtotime($this->preference->item('exhibition_registration_date'))).' )';
    }

    if($this->preference->item('convention_registration_date') == '[TBA]'){
        $conv = '';
    }else{
        $conv = '( Open online '.date('jS F Y H:i:s',strtotime($this->preference->item('convention_registration_date'))).' )';
    }

    if($this->preference->item('sponsorship_registration_date') == '[TBA]'){
        $sponsor = '';
    }else{
        $sponsor = '( Open online '.date('jS F Y H:i:s',strtotime($this->preference->item('sponsorship_registration_date'))).' )';
    }

?>

<p>
    <b>For a first time site visitor</b>, or if you don’t already have an account:<br />
    <ol>
        <li>
            Access http://www.ipa.or.id/convex/webmain/main/home
        </li>
        <li>
            Set up a new  account by clicking “CREATE AN ACCOUNT” link from the menu
        </li>
        <li>
            After submitting your personal information, you will receive a notification confirming your new account.
        </li>
        <li>
            To login access to http://www.ipa.or.id/convex/webmain/main/home and click on LOGIN page
        </li>
        <li>
            You will have access to:
            <ul>
                <li>Exhibition booth space booking <?=$exhibit;?></li>
                <li>Convention registration <?=$conv?></li>
                <li>Sponsorship participation <?=$sponsor?></li>
            </ul>
        </li>
        <li><b>For booth space booking :</b><br />
            After you make a booth space booking, you will receive a notification letter of your booking.
        </li>
        <li>
            To complete the booth space booking process, you need to return to IPA Exhibition committee by email, the Commitment Letter within 7 (seven) days after receipt of the notification letter or it will be automatically released.
        </li>
    </ol>
</p>
<p>
    <b>If you already have an account</b><br />
    <ul>You may directly go to login page and have access to:
        <ul>
            <li>Exhibition booth space booking <?=$exhibit;?></li>
            <li>Convention registration <?=$conv?></li>
            <li>Sponsorship participation <?=$sponsor?></li>
        </ul>
    </ul>
</p>
<p>
    Hotline Number at: <b>+62.21.75912087</b><br />
    Or e-mail us at <b>quadmice@quadevent.com</b>
</p>
<p>
    <b>PAYMENTS:</b><br />
    Remittance of booth charges and/or Convention registration fees should be made by transfer to:<br />
    <br />
    <b>USD Account:</b><br />
    Beneficiary: PT. FASEN CREATIVE QUALITY<br />
    Bank Mandiri<br />
    KCP Jakarta Kemang Selatan<br />
    A/C 126-00-0602405-2<br />
    <br />
    <b>Rupiah Account:</b><br />
    Beneficiary: PT. FASEN CREATIVE QUALITY<br />
    Bank Mandiri<br />
    KCP Jakarta Kemang Selatan<br />
    A/C 126-00-0602403-7<br />
</p>