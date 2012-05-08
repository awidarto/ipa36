<h2><?php print $header?></h2>

<script>
$(document).ready(function() { 
    var currentid;

    $("a.preview").fancybox({ 
        'hideOnContentClick': false,
        'showCloseButton': true,
        'frameWidth' : 800,
        'frameHeight' : 500,
    }); 
    
    $("#search_box").hide();
    $("#search_toggle").html("Show Search");

    $("#summary_box").hide();
    $("#summary_toggle").html("Show Summary");
    
	//swfobject.registerObject("player","9.0.98","expressInstall.swf");
}); 

function delFile(filename){
    var del_ok = confirm("Sure to delete this file " + filename + " ?")
	if (del_ok){
		$.post("<?php print site_url('media/admin/usermedia/deletefile'); ?>", 
            { 'f':filename },
            function(data){
                alert(data.msg);
                if(data.result){
                    $("#"+filename).hide();
                }
            },'json'
        );
	}
}

function toggleSearch(){
    $("#search_box").toggle();
    if($("#search_box").is(":visible")){
        $("#search_toggle").html("Hide Search");
    }else{
        $("#search_toggle").html("Show Search");
    }
}

function toggleSummary(){
    $("#summary_box").toggle();
    if($("#summary_box").is(":visible")){
        $("#summary_toggle").html("Hide Summary");
    }else{
        $("#summary_toggle").html("Show Summary");
    }
}

</script>
    <script>
        function ajaxSold(b){
            var ans = confirm("You are about to change Booth " + b + " status to SOLD, are you sure ?");
            if(ans == true){
                var booth = b;
                if(booth != ''){
                    jQuery("#process").show();
                    $.post("<?=base_url()?>auth/admin/booth/ajaxsold/" + Math.random(), 
                        { b: booth },
                        function(data){
                            jQuery("#process").hide();
                            if(data.status == "err"){
                                jQuery("#booking").html(data.result);
                                alert(data.msg);
                            }else{
                                jQuery("#" + b).html(data.result);
                                alert(data.msg);
                            }
                        },"json");
                }else{
                    alert('Please pick available booth first');
                }
            }
        }

        function ajaxRelease(b){
            var ans = confirm("You are about to change Booth " + b + " status to OPEN, are you sure ?");
            if(ans == true){
                var booth = b;
                if(booth != ''){
                    jQuery("#process").show();
                    $.post("<?=base_url()?>auth/admin/booth/ajaxrelease/" + Math.random(), 
                        { b: booth },
                        function(data){
                            jQuery("#process").hide();
                            if(data.status == "err"){
                                jQuery("#booking").html(data.result);
                                alert(data.msg);
                            }else{
                                jQuery("#" + b).html(data.result);
                                alert(data.msg);
                            }
                        },"json");
                }else{
                    alert('Please pick available booth first');
                }
            }
        }


</script>

<?php if(isset($print)):?>
    <style>
        tr{
            font-family:san-serif,helvetica;
            font-size:12px;
        }
        h2{
            font-family:san-serif,helvetica;
            font-size:14px;
        }
        
    </style>
<?php else:?>
    <style>
        .toggle_bar{
            text-align:right;
            border-bottom:thin solid grey;
            font-weight:bold;
        }
        
        #search_toggle,#summary_toggle{
            border-top:thin solid grey;
            border-left:thin solid grey;
            border-right:thin solid grey;
            padding:3px;
        }
                
        table#summary td{
            padding:3px 10px;
        }

        table#summary td,table#summary th {
            border-left: thin solid grey;
        }

        table#summary thead th {
            border: thin solid grey;
            padding:3px 10px;
        }
        
        
    </style>

    <?php if(isset($summary_list)):?>
    <div class="toggle_bar" ><span id="summary_toggle" onClick="javascript:toggleSummary();" style="cursor:pointer;">Show Summary</span></div>
    <div class="box">
        <div id="summary_box">
            <?php if(count($summary_list) > 0): ?>
                <table id="summary">
                    <thead>
                        <tr>
                            <th class="left top" colspan="2" >Summary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($summary_list as $key=>$val):?>
                        <tr>
                            <td>
                                <?php print $key;?>
                            </td>
                            <td style="border-right:thin solid grey;">
                                <?php print $val;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php else:?>
            <?php endif;?>
        </div>
    </div>
    <?php endif;?>
    <div class="clear"></div>

    <?php if($search):?>
    <div class="toggle_bar" ><span id="search_toggle" onClick="javascript:toggleSearch();" style="cursor:pointer;">Show Search</span></div>
    <div class="box">
        <div id="search_box">
            <?=$search;?>
            <?=$reset_search;?>
        </div>
    </div>
    <?php endif;?>
    <div class="box">
        <?php if($paging):?>
            <?=$paging;?>
        <?php endif;?>
    </div>
    <div class="clear"></div>
    <?=$exportlink; ?>
<?php endif;?>

<table>
<?php if(isset($print)):?>
    <h2><?=$header;?></h2>
<?php endif;?>
<style>
.left_align td{
    text-align:left;
}
.sidepad{
    padding: 5px 10px;
}

td.center{
    text-align:center;
}

td, th {
    border-left: thin solid grey;
}

thead th {
    border-top: thin solid grey;
}

.orange{
    background-color: yellow;
}
</style>

<?=form_open('auth/admin/members/delete')?>
<table class="data_grid" cellspacing="0"  valign="middle" >
    <thead>
        <tr>
            <th class="middle top" >ID</th>
            <th class="sidepad">Company</th>
            <th class="sidepad">Contacts</th>
            <th class="sidepad top center">Booth Number</th>
            <th class="sidepad top center">Type</th>
            <th class="sidepad top center">Width</th>
            <th class="sidepad top center">Length</th>
            <th class="sidepad top center">Area</th>
            <th class="sidepad top center">Price/Sqm</th>
            <th class="sidepad top center">Price Total</th>
            <th class="sidepad top center">Status</th>
            <th class="sidepad top center">Last Modified</th>
            <th class="sidepad top center" style="border-right:thin solid grey;">Action</th>
        </tr>
<!--
[booth_number] => A-101
[hall] => Assembly Hall
[width] => 3
[length] => 3
[area] => 9
[price_sqm] => 450
[price_total] => 4050
[type] => Platinum
[orderstatus] => sold
[orderby] => PT PERTAMINA (PERSERO)
[pic_id] => 83
[ordertimestamp] => 2011-02-10 13:23:58
[close] => 0
-->            
    </thead>
    <tfoot>
        <tr>
            <td colspan="16"  style="border-right:thin solid grey;">* Click on <span style="color:red">red</span> colored property to edit</td>
            <!--
            <td><?=form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('userlib_delete_user_confirm').'\');"')?></td>
            -->
        </tr>
    </tfoot>
<?php if(isset($documents)): ?>
    <tbody>
        <?php foreach($documents as $row):
            // Check if this user account belongs to the person logged in
            // if so don't allow them to delete it
            $delete  = ($row->id == $this->session->userdata('id')?'&nbsp;':form_checkbox('select[]',$row->id,FALSE)); 
            $delete = '';
            
            //print_r($row);
        ?>
        <tr class="left_align" id="<?=$row->booth_number;?>" >
            <td class="middle top"  style="padding: 5px 2px;"><?=$row->id;?></td>
            <td class="top" style="padding:5px;">
                <b><?=$row->company?></b><br />
                <?=$row->country?><br />
                P : <?=$row->phone;?><br />
                F : <?=$row->fax;?><br />
            </td>
            <td class="middle top" style="padding:5px;">
                <a class="preview" href="<?=site_url('/media/admin/media/contactlog/'.$row->id.'/'.time());?>">
                    <?=$row->firstname.' '.$row->lastname;?>
                </a><br />
                <?=$row->conv_id?><br />
                <?=$row->email?><br />
                M : <?=$row->mobile;?><br />
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php  print $row->booth_number;?><br />
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print $row->type;?>
            </td>
            <td class="center middle" style="padding:5px;font-weight:bold;">
                <?php print $row->width;?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print $row->length;?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print $row->area;?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print 'USD '.number_format($row->price_sqm);?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print 'USD '.number_format($row->price_total);?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print $row->orderstatus;?>
            </td>
            <td class="center middle orange">
                <?php print $row->ordertimestamp;?>
            </td>
            <td class="center middle"  style="border-right:thin solid grey;padding:5px;">
                <?php if($row->orderstatus == 'preassigned'):?>
                <a href="<?php print site_url('auth/admin/booth/form/'.$row['id'])?>"><?php print $this->bep_assets->icon('pencil');?></a>
                <?php elseif($row->orderstatus == 'booked'): ?>
                    <span style="cursor:pointer;" onClick="javascript:ajaxSold('<?=$row->booth_number ?>')"><?php print $this->bep_assets->icon('key');?></span>
                    &nbsp;
                <?php endif;?>
                <?php if($row->orderstatus == 'booked' || $row->orderstatus == 'sold'): ?>
                    <span style="cursor:pointer;" onClick="javascript:ajaxRelease('<?=$row->booth_number ?>')"><?php print $this->bep_assets->icon('arrow_refresh');?></span>
                <?php endif;?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
<?php else : ?>
    <tbody>
        <tr>
            <td colspan="8">No Member Record Found</td>
        </tr>
    </tbody>
<?php endif; ?>
</table>
<?=form_close()?>
<div class="box">
    <?php if($paging):?>
        <?=$paging;?>
    <?php endif;?>
</div>
<div class="clear"></div>
<?php if($page_query):?>
    <div class="box">
        <h3>Last Query</h3>
        <?=$page_query;?>
    </div>
<?php endif;?>
<?php if(isset($print)):?>
    <script language=javascript>
        function printWindow() {
            bV = parseInt(navigator.appVersion);
            if (bV >= 4) window.print();
        }
        printWindow();
    </script>
<?php endif;?>
<div id="dispatch_form" style="display:none;">
    <table id="dispatch_form_table">
    <tr>
        <td>Dispatch Location</td>
        <td><?=form_input('dispatch_loc','','id="dispatch_loc"')?></td>
    </tr>
    <tr>
        <td>Box ID</td>
        <td><?=form_input('dispatch_box','','id="dispatch_box"')?></td>
    </tr>
    </table>
    <span id="dispatch_progress" style="display:none">Dispatching...</span>
</div>

<script>
    function flagthis(id){
        $.post("<?php print site_url('user/flag'); ?>", 
            { 'uid':id },
            function(data){
                alert(data.result);
            },'json'
        );
    }
</script>


<!--
[id] => 83
[booth_number] => A-101
[hall] => Assembly Hall
[width] => 3
[length] => 3
[area] => 9
[price_sqm] => 450
[price_total] => 4050
[type] => Platinum
[orderstatus] => sold
[orderby] => PT PERTAMINA (PERSERO)
[pic_id] => 83
[ordertimestamp] => 2011-02-10 13:23:58
[close] => 0
[username] => murti
[email] => murti@pertamina.com
[password] => 76017ed096e44289c250e2fc28a5f04e3739693b
[active] => 1
[last_visit] => 2011-02-02 08:01:12
[created] => 2011-02-02 07:34:03
[modified] => 
[group] => Member
[group_id] => 1
[fullname] => Murti Dewi Hani
[salutation] => Ms.
[firstname] => Murti Dewi
[lastname] => Hani
[nationality] => Indonesia
[mobile] => 08118601246
[fax] => 021.3846913
[phone] => 021.3816442
[registertype] => 
[gender] => 0
[dob] => 1975-04-16
[street] => Jl Medan Merdeka Timur No 1A Gd. Perwira 6
[street2] => 
[city] => Jakarta
[zip] => 10110
[ipaid] => 
[company] => PT PERTAMINA (PERSERO)
[position] => Exhibition Officer
[country] => Indonesia
[domain] => http://www.ipa.or.id/convex/reg/
[boothassistant] => 
[course_1] => 
[course_2] => 
[course_3] => 
[course_4] => 
[course_5] => 
[judge] => 
[galadinner] => 
[galadinneraux] => 
[golf] => 0
[golfwait] => 0
[galadinnercurr] => 
[golfcurr] => 
[total_idr] => 0
[total_usd] => 0
[total_idr_sc] => 0
[total_usd_sc] => 0
[registrationtype] => 
[invoice_address_conv] => 
[invoice_address_sc] => 
[invoice_address_ex] => 
[conv_id] => 00-00-000083
[conv_lock] => 0
[sc_lock] => 0
[conv_seq] => 0
[sc_seq] => 0
[exhibitor] => 0
[foc] => 0
[media] => 0
-->