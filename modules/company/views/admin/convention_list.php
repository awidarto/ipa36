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

    $("#summary_box").show();
    $("#summary_toggle").html("Hide Summary");
    
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
    <div class="toggle_bar" ><div class="toggle_tab"><?php print $this->bep_assets->icon('application_view_detail');?><span id="summary_toggle" onClick="javascript:toggleSummary();" style="cursor:pointer;">Show Summary</span></div></div>
    <div class="box">
        <div id="summary_box" style="display:none;">
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
    <div class="toggle_bar" ><div class="toggle_tab"><?php print $this->bep_assets->icon('zoom');?><span id="search_toggle" onClick="javascript:toggleSearch();" style="cursor:pointer;">Show Search</span></div></div>
    <div class="box">
        <div id="search_box" style="display:none;">
            <?=$search;?>
            <?=$reset_search;?>
        </div>
    </div>
    <?php endif;?>
    <div class="box" id="paging">
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
            <th class="sidepad">Company</th>
            <th class="sidepad top center" colspan="6">Convention</th>
            <th class="sidepad top center" colspan="2">Golf</th>
            <th class="sidepad" colspan="2">Gala Dinner</th>
            <th class="sidepad top center" colspan="7">Short Courses</th>
            <th class="sidepad" colspan="2" >Exhibitor</th>
            <th class="sidepad" style="border-right:thin solid grey;">Media</th>
        </tr>
        <tr>
            <th class="sidepad">&nbsp;</th>
            <th class="sidepad">PO</th>
            <th class="sidepad">PD</th>
            <th class="sidepad">SO</th>
            <th class="sidepad">SD</th>
            <th class="sidepad">USD</th>
            <th class="sidepad">IDR</th>
            <th class="sidepad">Att</th>
            <th class="sidepad">Wait</th>
            <th class="sidepad">Main</th>
            <th class="sidepad">Add</th>
            <th class="sidepad">1</th>
            <th class="sidepad">2</th>
            <th class="sidepad">3</th>
            <th class="sidepad">4</th>
            <th class="sidepad">5</th>
            <th class="sidepad">USD</th>
            <th class="sidepad">IDR</th>
            <th class="sidepad">Exhibitor</th>
            <th class="sidepad">Entitled</th>
            <th class="sidepad" style="border-right:thin solid grey;">&nbsp;</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="21"  style="border-right:thin solid grey;">* Click on <span style="color:red">red</span> colored property to edit</td>
            <!--
            <td><?=form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('userlib_delete_user_confirm').'\');"')?></td>
            -->
        </tr>
    </tfoot>
<?php if(isset($documents)): ?>
    <tbody>
        <?php foreach($documents as $row):?>
        <tr class="left_align">
            <td class="top" style="padding:5px;">
                <a class="preview" href="<?=site_url('/company/admin/media/userlist/'.base64_encode($row['company']).'/'.time());?>">
                    <b><?=$row['company']?></b>
                </a>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print $row['po'];?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print $row['pd'];?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print $row['so'];?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print $row['sd'];?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print number_format($row['total_usd']);?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print number_format($row['total_idr']);?>
            </td>
            <td class="center middle" style="padding:5px;font-weight:bold;">
                <?php print $row['golf'];?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print $row['golfwait'];?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print $row['galadinner'];?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print $row['galadinneraux'];?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print $row['course_1'];?>
            </td>
            <td class="center middle" style="padding:5px;">
                <?php print $row['course_2'];?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print $row['course_3'];?>
            </td>
            <td class="center middle" style="padding:5px;">
                <?php print $row['course_4'];?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print $row['course_5'];?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print number_format($row['total_usd_sc']);?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print number_format($row['total_idr_sc']);?>
            </td>
            <td class="center middle" style="padding:5px;">
                <?php print $row['exhibitor'];?>
            </td>
            <td class="center middle" style="padding:5px;">
                <?php print $row['foc'];?>
            </td>
            <td class="center middle orange" style="padding:5px;border-right:thin solid grey;">
                <?php print $row['media'];?>
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
<div class="box" id="paging">
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

[id] => 1
[uid] => 1
[section] => uservideo
[title] => 1.jpg
[message] => 
[fid] => avatar/
[file_name] => 1.jpg
[file_path] => /Applications/xampp/xamppfiles/htdocs/muketipis/public/avatar/
[full_path] => /Applications/xampp/xamppfiles/htdocs/muketipis/public/avatar/1.jpg
[file_type] => image/jpeg
[raw_name] => 1
[orig_name] => 1.jpg
[file_ext] => .jpg
[file_size] => 11.44
[mediatype] => image
[timestamp] => 2010-06-22 16:25:30
[datecreated] => 0000-00-00 00:00:00
[is_image] => 1
[image_width] => 450
[image_height] => 284
[image_type] => jpeg
[image_size_str] => width="450" height="284"
[thumbnail] => th_1.jpg
[mp3_file] => 
[flv_file] => 
[3gp_file] => 
[music_pic] => 
[postvia] => web
[process] => 0
[hint] => 
[scene] => 0
[auxflag] => 0
[hit] => 0
[reviewed] => 0
[username] => Administrator
[password] => 2c8997a41de8836d95d1d78fff07111e3eba5821
[email] => andy.awidarto@gmail.com
[active] => 1
[group] => 2
[activation_key] => 
[last_visit] => 2010-07-08 13:57:13
[created] => 2010-06-01 13:52:32
[modified] => 
[fullname] => Administrator
[sex] => 
[pob] => 
[dob] => 0000-00-00
[idnum] => 
[parentidnum] => 
[parentname] => 
[street] => 
[city] => 
[zip] => 
[mobile] => 
[phone] => 
[favactor] => 
[joinreason] => 
[picture] => 

-->