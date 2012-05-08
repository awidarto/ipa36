
<style>
    div.header{font-size:14px;}

	table.dashboard { border: solid #888 1px}
	table.dashboard td { border: solid #DDD 1px; background-color:#EEE; font-size:13px; }

	td a:link {color:#000; text-decoration:none}
	td a:visited {color:#000;}
	td a:hover {color:#666;}
	td a:active {color:#000;}
    td:hover {background-color:#DDD;}

	td.subheader { text-align:right; background-color:#EEE; color:#7e5252; padding-right: 13px; }
	td.header { text-align:left; background-color:#6a4141; color:#FFF; vertical-align:middle; padding-left: 5px; padding-bottom: 2px; padding-top: 2px; border-bottom:solid #000 2px;}
	td.topheader { text-align:center; background-color:#492121; color:#FFF; vertical-align:middle; font-size:14px; }

</style>

<table id="dashboard" width="100%"; cellspacing="0" cellpadding="0">

  <tr>
    <td height="100" colspan="3" align="center" valign="middle" class="topheader"><strong>35th IPA Convention and Exhibition<br />
      Jakarta Convention Center, 18th - 20th May 2011<br />
      REGISTRATION REPORT - SUMMARY</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle" class="header"><strong>Convention Registration</strong></td>
  </tr>
  <tr>
    <td colspan="2"><?php print anchor('media/admin/conventionpd',$this->lang->line('ipa_pro_domestic_convention'))  ?></td>
    <td><?php print $pro_domestic_convention ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php print anchor('media/admin/conventionpo',$this->lang->line('ipa_pro_overseas_convention')) ?></td>
    <td><?php print $pro_overseas_convention ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php print anchor('media/admin/conventionsd',$this->lang->line('ipa_student_domestic_convention')) ?></td>
    <td><?php print $student_domestic_convention ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php print anchor('media/admin/conventionso',$this->lang->line('ipa_student_overseas_convention')) ?></td>
    <td><?php print $student_overseas_convention ?></td>
  </tr>
  <tr>
    <td colspan="2" class="subheader" width="75%"><strong>Total Convention Registration (not including FOC)</strong></td>
    <td><?php print $total_convention_attendees ?></td>
	<!--<td>81</td>-->
  </tr>
  <tr>
    <td colspan="3" class="header"><strong>Exhibition Registration</strong></td>
  </tr>
<!--
  <tr>
    <td colspan="2"><?php print anchor('media/admin/judge','Exhibitors (non-FOC)') ?></td>
    <td><?php print $exhibitor_non_entitlement ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php print anchor('media/admin/foc','Booth Complimentary (FOC)') ?></td>
    <td><?php print $exhibitor_entitlement ?></td>
  </tr>
  <tr>
    <td colspan="2">Additional Booth Assistant*</td>
    <td id="booth_assistant" ><?php print $booth_assistant ?></td>
    <script>
        $("#booth_assistant").editInPlace({
            url: "<?=site_url('user/ajaxset/boothassistant')?>",
            success: function(){
                //$('#booth_assistant').html(gt);
            }
        });
    </script>
  </tr>
-->
  <tr>
    <td colspan="2" class="subheader" width="75%"><strong>Total Exhibition Registration</strong></td>
    <td><?php print $exhibitor_personnel ?></td>
  </tr>
  <tr>
    <td colspan="2">Other Complimentary</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="subheader" width="75%"><strong>Total Convention Attendees (including FOC)</strong></td>
    <td><?php print $total_convention_plus_foc_attendees ?></td>
  </tr>  
</table>
<br />

<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
    <tr>
    <td colspan="3" class="header"><strong>Technical Program Judge</strong></td>
    </tr>
    <td colspan="2" class="subheader" width="75%"><strong><?php print anchor('media/admin/judge','Total Judge Participants') ?></strong></td>
    <td width="50%"><?php print $judge_members ?></td>
  </tr>
</table>

<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
  <tr>
    <td colspan="2" class="header"><strong>Golf</strong></td>
  </tr>
  <tr>
    <td width="75%"><?php print anchor('media/admin/golf','Golf - with Convention Registration') ?></td>
    <td width="25%"><?php print $golf_members ?></td>
  </tr>
  <tr>
    <td>Golf - Complimentary Convention Registration*</td>
    <td id="golf_offline"><?php print $golf_offline_members ?></td>
    <script>
        $("#golf_offline").editInPlace({
            url: "<?=site_url('user/ajaxset/golf')?>",
            success: function(){
                var gt = parseInt($('#golf').html()) + parseInt($('#golf_offline').html());
                $('#golftotal').html(gt);
            }
        });
    </script>
  </tr>
  <tr>
    <td>Golf - Participant in Waiting List</td>
    <td><?php print $golfwait_members ?></td>
  </tr>
  <tr>
    <td class="subheader"><strong>Total Golf Participants</strong></td>
    <td><?php print $golf_total_members ?></td>
  </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
  <tr>
    <td colspan="2" class="header"><strong>Gala Dinner</strong></td>
  </tr>
  <tr>
    <td width="75%"><?php print anchor('media/admin/galadinner','Gala Dinner - with Convention Registration') ?></td>
    <td width="25%"><?php print $galadinner_members ?></td>
  </tr>
  <tr>
    <td>Gala Dinner - Complimentary Convention Registration*</td>
    <td id="galadinner_offline"><?php print $galadinner_offline_members ?></td>
    <script>
        $("#galadinner_offline").editInPlace({
            url: "<?=site_url('user/ajaxset/galadinner')?>",
            success: function(){
                var gt = parseInt($('#galadinner').html()) + parseInt($('#galadinneraux').html()) + parseInt($('#galadinner_offline').html());
                //alert(gt);
                $('#galadinnertotal').html(gt);
            }
        });
    </script>
  </tr>
  <tr>
    <td>Gala Dinner - Accompanying</td>
    <td><?php print $galadinneraux_members ?></td>
  </tr>
  <tr>
    <td class="subheader"><strong>Total Gala Dinner Participants</strong></td>
    <td><?php print $galadinner_total_members ?></td>
  </tr>
</table> 

<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
  <tr>
    <td colspan="2" class="header"><strong>Non Convention Participants</strong></td>
  </tr>
  <?php $total_non_conv = 0;?>
  <?php foreach($this->config->item('off_roles') as $item): ?>
      <tr>
        <td width="75%"><?php print anchor('media/admin/officials',$item) ?></td>
        <td width="25%"><?php print ${str_replace(" ","_",strtolower($item))."_num"} ?></td>
        <?php $total_non_conv += ${str_replace(" ","_",strtolower($item))."_num"};?>
      </tr>
  <?php endforeach; ?>
  <tr>
    <td class="subheader"><strong>Total Non Convention Participants</strong></td>
    <td><?php print $total_non_conv ?></td>
  </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
  <tr>
    <td colspan="2" class="header"><strong>Visitors</strong></td>
  </tr>
  <tr>
    <td width="75%"><?php print anchor('media/admin/visitors','Visitors') ?></td>
    <td width="25%"><?php print $visitors ?></td>
  </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
<tr>
  <td colspan="2" class="header"><strong>Total Event Attendees</strong></td>
</tr>
<tr>
  <td width="75%"><?php print anchor('media/admin/golf','Total Convention Attendees (including FOC)') ?></td>
  <td width="25%"><?php print $total_convention_plus_foc_attendees ?></td>
</tr>
<tr>
  <td width="75%"><?php print anchor('media/admin/officials','Non Convention Participants') ?></td>
  <td width="25%"><?php print $total_non_conv ?></td>
</tr>
<tr>
  <td width="75%"><?php print anchor('media/admin/visitors','Visitors') ?></td>
  <td width="25%"><?php print $visitors ?></td>
</tr>

<tr>
  <td class="subheader" width="75%"><strong>Total Event Attendees</strong></td>
  <td width="25%"><?php print $total_convention_plus_foc_attendees + $total_non_conv + $visitors; ?></td>
</tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
    <tr>
      <td colspan="2" class="header"><strong>Actual Event Attendees</strong></td>
    </tr>
    <tr>
      <td colspan="2" class="header"><strong>18 May 2011</strong></td>
    </tr>
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendance','Convention Attendees') ?></td>
      <td width="25%"><?php print $convention_18 ?></td>
    </tr>
<!--    
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendanceoff','Officials') ?></td>
      <td width="25%"><?php print $official_18 ?></td>
    </tr>
-->
    <?php foreach($this->config->item('off_roles') as $item): ?>
        <tr>
          <td width="75%"><?php print anchor('media/admin/officials',$item) ?></td>
          <td width="25%"><?php print ${str_replace(" ","_",strtolower($item))."_18"} ?></td>
        </tr>
    <?php endforeach; ?>

    <tr>
      <td width="75%"><?php print anchor('media/admin/attendancevis','Walk In Visitor') ?></td>
      <td width="25%"><?php print $visitor_18 ?></td>
    </tr>
        <tr>
          <td class="subheader" width="75%"><strong>Total Daily Event Attendees</strong></td>
          <td width="25%"><?php print $convention_18+$total_official_18+$visitor_18; ?></td>
        </tr>

    <tr>
      <td colspan="2" class="header"><strong>19 May 2011</strong></td>
    </tr>
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendance','Convention Attendees') ?></td>
      <td width="25%"><?php print $convention_19 ?></td>
    </tr>
        <?php foreach($this->config->item('off_roles') as $item): ?>
        <?php $official_19 = 0;?>
            <tr>
              <td width="75%"><?php print anchor('media/admin/officials',$item) ?></td>
              <td width="25%"><?php print ${str_replace(" ","_",strtolower($item))."_19"} ?></td>
              <?php $official_19 += ${str_replace(" ","_",strtolower($item))."_19"};?>
            </tr>
        <?php endforeach; ?>
<!--
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendanceoff','Officials') ?></td>
      <td width="25%"><?php print $official_19 ?></td>
    </tr>
-->
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendancevis','Walk In Visitor') ?></td>
      <td width="25%"><?php print $visitor_19 ?></td>
    </tr>
    <tr>
      <td class="subheader" width="75%"><strong>Total Daily Event Attendees</strong></td>
      <td width="25%"><?php print $convention_19+$total_official_19+$visitor_19; ?></td>
    </tr>

    <tr>
      <td colspan="2" class="header"><strong>20 May 2011</strong></td>
    </tr>
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendance','Convention Attendees') ?></td>
      <td width="25%"><?php print $convention_20 ?></td>
    </tr>
        <?php foreach($this->config->item('off_roles') as $item): ?>
        <?php $official_20 = 0;?>
            <tr>
              <td width="75%"><?php print anchor('media/admin/officials',$item) ?></td>
              <td width="25%"><?php print ${str_replace(" ","_",strtolower($item))."_20"} ?></td>
              <?php $official_20 += ${str_replace(" ","_",strtolower($item))."_20"};?>
            </tr>
        <?php endforeach; ?>
<!--    
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendanceoff','Officials') ?></td>
      <td width="25%"><?php print $official_20 ?></td>
    </tr>
-->
    <tr>
      <td width="75%"><?php print anchor('media/admin/attendancevis','Walk In Visitor') ?></td>
      <td width="25%"><?php print $visitor_20 ?></td>
    </tr>
        <tr>
          <td class="subheader" width="75%"><strong>Total Daily Event Attendees</strong></td>
          <td width="25%"><?php print $convention_20+$total_official_20+$visitor_20; ?></td>
        </tr>

    <tr>
      <td class="subheader" width="75%"><strong>Total Actual Event Attendees</strong></td>
      <td width="25%"><?php print $total_visitor_attending; ?></td>
    </tr>
</table>



<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
    <tr>
      <td colspan="2" class="header"><strong>Attendee By Nationality</strong></td>
    </tr>
    <?php foreach($nationality_count as $n):?>
    <tr>
      <td width="75%"><?php print $n['nationality'] ?></td>
      <td width="25%"><?php print $n['natcount'] ?></td>
    </tr>
    <?php endforeach;?>
</table>



<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="dashboard">
  <tr>
    <td colspan="3" class="header"><strong>Short Courses</strong></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="25%">Member</td>
    <td width="25%">Non-Member</td>
  </tr>
  <tr>
    <td>Course 1: Real Time Technologies for On-Time Drilling Operations<br />
Samit Sengupta &amp; Dr. Julian Pickering - Geologix Limited, UK</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Course #1 - with Convention Registration</td>
    <td><?php print $total_course_1_member ?></td>
    <td><?php print $total_course_1_non_member ?></td>
  </tr>
  <tr>
    <td>Course #1 - only</td>
    <td><?php print $total_course_1_only_member ?></td>
    <td><?php print $total_course_1_only_non_member ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>Course 2: Production Optimization Using Nodal System, Analysis: An Integrated Approach<br />
Tutuka Ariadji, MSc., PhD. - Petroleum Engineering Dept., ITB</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Course #2 - with Convention Registration</td>
    <td><?php print $total_course_2_member ?></td>
    <td><?php print $total_course_2_non_member ?></td>
  </tr>
  <tr>
    <td>Course #2 - only</td>
    <td><?php print $total_course_2_only_member ?></td>
    <td><?php print $total_course_2_only_non_member ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>Course 3: Pressure Data for Exploration Success<br />
Steve O'Connor - GeoPressure Technology Limited, UK</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Course #3 - with Convention Registration</td>
    <td><?php print $total_course_3_member ?></td>
    <td><?php print $total_course_3_non_member ?></td>
  </tr>
  <tr>
    <td>Course #3 - only</td>
    <td><?php print $total_course_3_only_member ?></td>
    <td><?php print $total_course_3_only_non_member ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>Course 4: Petroleum Geochemistry: A Quest for Oil and Gas<br />
Awang Harun Satyana - BPMIGAS, Indonesia</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Course #4 - with Convention Registration</td>
    <td><?php print $total_course_4_member ?></td>
    <td><?php print $total_course_4_non_member ?></td>
  </tr>
  <tr>
    <td>Course #4 - only</td>
    <td><?php print $total_course_4_only_member ?></td>
    <td><?php print $total_course_4_only_non_member ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>Course 5: Farmins and Farmouts for Explorationist<br />
Peter J. Cockroft, Blue Energy Limited, Australia </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Course #5 - with Convention Registration</td>
    <td><?php print $total_course_5_member ?></td>
    <td><?php print $total_course_5_non_member ?></td>
  </tr>
  <tr>
    <td>Course #5 - only</td>
    <td><?php print $total_course_5_only_member ?></td>
    <td><?php print $total_course_5_only_non_member ?></td>
  </tr>
    <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong><?php print anchor('media/admin/shortcourses','Total Short Courses with Convention Participants') ?></strong>: <?php print $total_convention_shortcourse_members ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong><?php print anchor('media/admin/shortcourses','Total Short Courses Only Participants') ?></strong>: <?php print $total_shortcourse_only_members ?></td>
  </tr>
</table>  


<!-- Hide Statistics Details

<br /><br />
<br /><br />
<br /><br />

<h3>STATISTICS IN DETAILS</h3>

<table width="100%" cellspacing="0">
	<thead>
		<tr><th width="50%">Convention & Short Course</th><th>&nbsp</th></tr>
	</thead>
	<tbody>
	    <tr><td><?php print $this->lang->line('ipa_convex_members') ?></td><td><?php print $total_convex_members ?></td></tr>
    	<tr><td>&nbsp;&nbsp;&nbsp;<?php print anchor('media/admin/conventionpd',$this->lang->line('ipa_pro_domestic_convention'))  ?></td><td><?php print $pro_domestic_convention ?></td></tr> 
    	<tr><td>&nbsp;&nbsp;&nbsp;<?php print anchor('media/admin/conventionpo',$this->lang->line('ipa_pro_overseas_convention')) ?></td><td><?php print $pro_overseas_convention ?></td></tr>
    	<tr><td>&nbsp;&nbsp;&nbsp;<?php print anchor('media/admin/conventionsd',$this->lang->line('ipa_student_domestic_convention')) ?></td><td><?php print $student_domestic_convention ?></td></tr>
    	<tr><td>&nbsp;&nbsp;&nbsp;<?php print anchor('media/admin/conventionso',$this->lang->line('ipa_student_overseas_convention')) ?></td><td><?php print $student_overseas_convention ?></td></tr>

		<tr><td><?php print anchor('media/admin/convention',$this->lang->line('ipa_convention_members')) ?></td><td><?php print $total_convention_only_members ?></td></tr>
		<tr><td><?php print anchor('media/admin/shortcourses',$this->lang->line('ipa_shortcourse_members')) ?></td><td><?php print $total_shortcourse_only_members ?></td></tr>
		<tr><td><?php print $this->lang->line('ipa_convention_shortcourse_members') ?></td><td><?php print $total_convention_shortcourse_members ?></td></tr>
		<tr><td><?php print $this->lang->line('ipa_convention_entitled') ?></td><td><?php print $entitled_convention ?></td></tr>
		<tr><td><?php print $this->lang->line('ipa_convention_paid_members') ?></td><td><?php print $total_paid_convention_members ?></td></tr>
		<tr><td><?php print $this->lang->line('ipa_shortcourse_paid_members') ?></td><td><?php print $total_paid_shortcourse_members ?></td></tr>


		
		<tr><td><?php print anchor('media/admin/golf',$this->lang->line('ipa_golf_members')) ?></td><td  id="golf"><?php print $golf_members ?></td></tr>
		<tr>
		    <td><?php print $this->lang->line('ipa_golf_offline_members') ?></td>
		    <td id="golf_offline"><?php print $golf_offline_members ?></td>
		</tr>
            <script>
                $("#golf_offline").editInPlace({
                    url: "<?=site_url('user/ajaxset/golf')?>",
                    success: function(){
                        var gt = parseInt($('#golf').html()) + parseInt($('#golf_offline').html());
                        $('#golftotal').html(gt);
                    }
                });
            </script>
		<tr><td><?php print $this->lang->line('ipa_golfwait_members') ?></td><td><?php print $golfwait_members ?></td></tr>
		<tr><td><?php print $this->lang->line('ipa_golf_total_members') ?></td><td id="golftotal"><?php print $golf_total_members ?></td></tr>
		<tr><td><?php print anchor('media/admin/galadinner',$this->lang->line('ipa_galadinner_members')) ?></td><td id="galadinner"><?php print $galadinner_members ?></td></tr>
		<tr><td><?php print anchor('media/admin/galadinner',$this->lang->line('ipa_galadinneraux_members')) ?></td><td id="galadinneraux" ><?php print $galadinneraux_members ?></td></tr>
		<tr><td><?php print $this->lang->line('ipa_galadinner_offline_members') ?></td><td id="galadinner_offline"><?php print $galadinner_offline_members ?></td></tr>
		<tr><td><?php print $this->lang->line('ipa_galadinner_total_members') ?></td><td id="galadinnertotal"><?php print $galadinner_total_members ?></td></tr>
            <script>
                $("#galadinner_offline").editInPlace({
                    url: "<?=site_url('user/ajaxset/galadinner')?>",
                    success: function(){
                        var gt = parseInt($('#galadinner').html()) + parseInt($('#galadinneraux').html()) + parseInt($('#galadinner_offline').html());
                        //alert(gt);
                        $('#galadinnertotal').html(gt);
                    }
                });
            </script>
    	<tr><td><?php print $this->lang->line('ipa_exhibitor') ?></td><td><?php print $exhibitor_personnel ?></td></tr>
	    <tr><td><?php print anchor('media/admin/foc',$this->lang->line('ipa_exhibitor_entitled')) ?></td><td><?php print $exhibitor_entitlement ?></td></tr>
		<tr><td><?php print $this->lang->line('booth_assistant') ?></td><td id="booth_assistant"><?php print $booth_assistant ?></td></tr>
            <script>
                $("#booth_assistant").editInPlace({
                    url: "<?=site_url('user/ajaxset/boothassistant')?>",
                    success: function(){
                        //$('#booth_assistant').html(gt);
                    }
                });
            </script>
	</tbody>
</table>

-->

<table width="100%" cellspacing="0">
	<thead>
		<tr><th width="50%">Exhibition Booth</th><th>&nbsp;</th></tr>
	</thead>

	<tbody>
        <tr><td><?php print anchor('auth/admin/booth',$this->lang->line('booth_total_booth')) ?></td><td><?php print $booth_total_booth ?> Units</td></tr>
        <tr><td><?php print anchor('media/admin/boothbuyer',$this->lang->line('booth_total_sold_rev')) ?></td><td>USD <?php print number_format($booth_total_sold_rev) ?></td></tr>
        <tr><td><?php print anchor('media/admin/boothbuyer',$this->lang->line('booth_total_rev')) ?></td><td>USD <?php print number_format($booth_total_rev) ?> </td></tr>
        <tr><td><?php print anchor('media/admin/boothbuyer',$this->lang->line('booth_total_sold')) ?></td><td><?php print $booth_total_sold ?> Units (<?=floor($booth_total_sold/$booth_total_booth*100)?>%)</td></tr>
        <tr><td><?php print anchor('media/admin/boothbuyer',$this->lang->line('booth_total_book')) ?></td><td><?php print $booth_total_book ?> Units (<?=floor($booth_total_book/$booth_total_booth*100)?>%)</td></tr>
        <tr><td><?php print anchor('media/admin/boothbuyer',$this->lang->line('booth_open_booth')) ?></td><td><?php print $booth_open_booth ?> Units</td></tr>

        <tr><td colspan=2 >&nbsp;</td></tr>
        
        <tr><td><?php print $this->lang->line('booth_total_area') ?></td><td><?php print $booth_total_area ?> square meters</td></tr>
        <tr><td><?php print $this->lang->line('booth_total_book_area') ?></td><td><?php print $booth_total_book_area ?> sqm (<?=floor($booth_total_book_area/$booth_total_area*100)?>%)</td></tr>
        <tr><td><?php print $this->lang->line('booth_total_sold_area') ?></td><td><?php print $booth_total_sold_area ?> sqm (<?=floor($booth_total_sold_area/$booth_total_area*100)?>%)</td></tr>	
        <tr><td><?php print $this->lang->line('booth_open_booth_area') ?></td><td><?php print $booth_open_booth_area ?> sqm (<?=100 - (floor($booth_total_book_area/$booth_total_area*100) + floor($booth_total_sold_area/$booth_total_area*100))?>%)</td></tr>
        
        
    </tbody>
    
</table>




