<h3><?php print $header?></h3>
<!--
<ol class="form_nav">
    <li class="current_form">Personal Information & Main Registration</li>
</ol>
<div class="clear"></div>
-->
        <ul id="profile_list" style="list-style-type:none">
            <li>
                <?php print $userdata['salutation'].' '.$userdata['firstname'].' '.$userdata['lastname'] ?>
            </li>
            <li>
                Nationality : <?php print $userdata['nationality'];?>
            </li>
            <li>
                Email : <?php print $userdata['email'];?>
            </li>
            <li>
                Cellphone : <?php print $userdata['mobile'];?>
            </li>
            <li>
                <div class="note">To be used to create your account on IPA Convention & Expo Registration site</div>
                Username : <?php print $userdata['username'];?>
            </li>
            <li>
                <div class="note">Company Information</div>
                Company : <?php print $userdata['company'].' ['.$userdata['companycode'].']';?>
            </li>
            <li>
                Position : <?php print $userdata['position'];?>
            </li>
            <li>
                Address 1 : <?php print $userdata['street'];?>
                Address 2 : <?php print $userdata['street2'];?>
            </li>
            <li>
                City : <?php print $userdata['city'];?>
            </li>
            <li>
                ZIP : <?php print $userdata['zip'];?>
            </li>
            <li>
                Country : <?php print $userdata['country'];?>
            </li>
            <li>
                Telephone : <?php print $userdata['phone'];?>
            </li>
            <li>
                Fax : <?php print $userdata['fax'];?>
            </li>
            <li>
                <div class="note">Expo Packages</div>
                Registration Fee : <?=$userdata['registertype']?>
            </li>
            <li>
                Additional Booth Assistant : <?=($userdata['boothassistant'])?'USD '.$this->config->item('boothassistant'):'No' ?> 
            </li>
            <li>
                <div class="note">Please help IPA by volunteering as Technical Program Judge</div>
                <?=$userdata['judge']?>
            </li>
            <li>
                <div class="note">SHORT COURSES | Hotel Mulia, 16 - 17 May 2011</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Title: Integrated Production Optimization for Oil and Gas Fields<br />
                        Instructor: Dr. Tutuka Ariadji, Petroleum Engineering Department, Institute of Technology Bandung</p>
                        <?=($userdata['course_1'] == 0)?'Not Attending':'USD '.$userdata['course_1']?>
                    </li>

                    <li>
                        <p>Title: Petroleum Geochemistry: A Quest for Oil and Gas<br />
                        Instructor: Awang Harun Satyana, BPMIGAS, Indonesia</p>
                        <?=($userdata['course_2'] == 0)?'Not Attending':'USD '.$userdata['course_1']?>
                    </li>

                    <li>
                        <p>Title: Understanding the Indonesian Upstream Oil and gas Industry<br />
                        Instructor: Dr. H.L. Ong, Lecturer, Institute of Technology Bandung and Advisor to PT. Geoservices</p>
                        <?=($userdata['course_3'] == 0)?'Not Attending':'USD '.$userdata['course_1']?>
                    </li>

                    <li>
                        <p>Title: Farmins and Farmouts for Explorationist<br />
                        Instructor: Peter J. Cockroft, Blue Energy Limited, Australia</p>
                        <?=($userdata['course_4'] == 0)?'Not Attending':'USD '.$userdata['course_1']?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note">GOLF | May 18th 2011, 6.30 AM</div>
                <?=$userdata['golf']?>
            </li>
            <li>
                <div class="note">GALA DINNER | May 18th 2011, 7 PM</div>
                <ol style="margin-left:200px;" class="shortcourse">
                    <li>
                        <p>Venue : Ballroom Hotel Mulia, Senayan</p>
                        <?=$userdata['galadinner']?>
                    </li>
                </ol>
            </li>
            <li>
                <div class="note" style="background-color:orange;text-align:right;" >TOTAL CHARGE : <span id="total_idr">IDR <?=$userdata['total_idr']?></span> | <span id="total_usd">USD <?=$userdata['total_usd']?></span></div>
            </li>
            <li>
                Payment Transfer to<br />
                <br />
                <table width=100% >
                    <tr>
                        <td>
                            <strong>USD Account :</strong><br /> 
                            Bank Mandiri<br />
                            KCP Jakarta Kemang Selatan<br />
                            A/C 126-00-0602405-2<br />
                            A/N PT. FASEN CREATIVE QUALITY<br />
                        </td>
                        <td>
                            <strong>Rupiah Account :</strong><br />
                            Bank Mandiri<br />
                            KCP Jakarta Kemang Selatan<br />
                            A/C 126-00-0602403-7<br />
                            A/N PT. FASEN CREATIVE QUALITY<br />
                        </td>
                    </tr>
                </table>
            </li>
        </ul>
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
