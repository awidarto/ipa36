<style>
    p,h4,h3 {margin-left:10px;}
    ol {margin-left:30px;}
</style>
<h3><?=$header;?></h3>

<?php 

    $open = true;
    if( time() > strtotime($this->preference->item('sponsorship_registration_date')) && $this->preference->item('sponsorship_registration_date') != '' && $this->preference->item('sponsorship_registration_date') != '[TBA]'){
        $open = true;
    }else{
        $open = false;
    }

    if($this->session->userdata('company') == 'Quad'){
        $open = true;
    }
?>
<?php if($open == true): ?>    

<p>
<b>Sponsorship Package Standard</b><br />
All sponsors will receive the following valuable standard benefits:
    <ul>
        <li>Complimentary company delegation for two person including the Gala Dinner and Convention</li>
        <li>A4 full color advert in Event Catalog</li>
        <li>Logo and link on website</li>
        <li>Logo on promo materials sent out to thousands of companies and featured in adverts</li>
        <li>Company profile in sponsor section in Conference Book</li>
        <li>Post-event promotion (E-company brochure to delegates requesting via feedback)</li>
    </ul>
</p>

<p>
<b>Platinum Sponsorship</b><br />
Platinum sponsorship package $ 50,000 + VAT</p>
<p>The platinum package is a great opportunity to raise profile at The 35th IPA Annual Convention and Exhibition as the Main Sponsor, the sponsors will be entitled to 
    <ul>    
        <li>Sponsorship of Gala Dinner and complementary delegate registrations (including Gala Dinner)</li>
        <li>VIP Lounge available</li>
        <li>Company logo at opening ceremony</li>
        <li>Company logo at closing ceremony</li>
        <li>Company logo at the VIP lounge</li>
        <li>Company logo at the business lounge</li>
        <li>Company logo in printed media</li>
        <li>Company logo in the main stage</li>
        <li>Standard benefits package</li>
        <li>Company logo at cover of Catalog</li>
    </ul>   
</p>

<p>
<b>Gold Sponsorship Package</b><br />
Gold sponsorship package $ 30,000 + VAT</p>
<p>Gold sponsorship package is a great opportunity to raise profile at The 35th IPA Annual Convention and Exhibition as the Main Sponsor, the sponsors will be entitled to 
    <ul>    
        <li>Sponsorship of Gala Dinner and complementary delegate registrations (including Gala Dinner)</li>
        <li>VIP Lounge available</li>
        <li>Company logo at opening ceremony</li>
        <li>Company logo at closing ceremony</li>
        <li>Company logo at the VIP lounge</li>
        <li>Company logo at the business lounge</li>
        <li>Company logo in printed media</li>
        <li>Company logo in the main stage</li>
        <li>Standard benefits package</li>
    </ul>   
</p>

<p>
<b>Silver Sponsorship Package</b><br />
Silver sponsorship package $ 20,000 + VAT</p>
<p>Silver sponsorship package is a great opportunity to raise profile at The 35th IPA Annual Convention and Exhibition as the Main Sponsor, the sponsors will be entitled to
    <ul>
        <li>Sponsorship of Gala Dinner and complementary delegate registrations (including Gala Dinner)</li>
        <li>VIP Lounge available</li>
        <li>Company logo at the VIP lounge</li>
        <li>Company logo at the business lounge</li>
        <li>Company logo in printed media</li>
        <li>Company logo in the main stage</li>
        <li>Standard benefits package</li>
    </ul>
</p>
<p>
<b>On-site Promotion</b><br />
Other than the sponsorship package as describe above, the on site promotion is most welcome for the company that wish to promote without needs to take a sponsorship package with a benefit of self choosing publication site.
</p>
<p>
<b>Event Catalog</b><br />
The company logo will be displayed in front of the company logo will be displayed on the A4 full color advert in Event Catalog: $ 500
</p>
<p>
<b>Main Stage</b><br />
Main stage is the main activities of the event, the company logo will be displayed in main stage backdrop for $ 400
Company logo of 2500 square centimeter : 50 cm x 50 cm
</p>
<p>
<b>VIP Lounge</b><br />
Exclusive and prominent guests and exhibitors will be placed in the VIP Lounge, the company is welcome to choose the VIP Lounge to display its logo for $ 350
Company logo of 2500 square centimeter : 50 cm x 50 cm
</p>
<p>
<b>Coffee corner</b><br />
Coffee corner is the most suitable place to have the company logo since it is available for all exhibitors, place company logo for $ 350
Company logo of 2500 square centimeter : 50 cm x 50 cm
</p>
<p>
<b>Registration Counter</b><br />
The Registration counter is located at the Foyer just outside the Exhibition Halls and is prominently seen by all the Exhibitors and visitors as well as the Media that attend the Show. 
Great spot to place the company logo for $ 400 
Company logo of 2500 square centimeter : 50 cm x 50 cm
</p>
<p>
<b>ID Card</b><br />
Badges is distribute to all the participants of the 35th IPA Exhibition (Exhibitors, visitors, crew, organizer) therefore it is a perfect site to place to the Company logo.
The company logo in ID Cards for $ 1,000
Company logo: 1 square centimeter [1 cm x 1 cm]
</p>
<?php else: ?>
<p>
    <?php if($this->preference->item('sponsorship_registration_date') == '[TBA]'):?>
        <div class="note" >Sponsorship information will be available soon</div>
    <?php else:?>
        <div class="note" >Sponsorship information will be available at <?=date('d-m-Y H:i:s',strtotime($this->preference->item('sponsorship_registration_date')));?></div>
    <?php endif;?>
</p>
<?php endif;?>
