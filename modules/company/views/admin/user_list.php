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
    <?php // print_r($documents);?>
    <div class="box">
        <?php if($paging):?>
            <?=$paging;?>
        <?php endif;?>
    </div>
    <?php if($search):?>
    <div class="box">
        <div id="search_box">
            <?=$search;?>
            <?=$reset_search;?>
        </div>
    </div>
    <?php endif;?>
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
    padding: 5px 15px;
}

td.center{
    text-align:center;
}
</style>

<?=form_open('auth/admin/members/delete')?>
<table class="data_grid" cellspacing="0"  valign="middle" >
    <thead>
        <tr>
            <th width=5%>ID</th>
            <th style="width:110px;">QR Code</th>
            <th class="sidepad">Username</th>
            <th class="sidepad">Full Name</th>
            <th class="sidepad">Properties</th>
            <th class="sidepad">Created</th>
            <th class="sidepad">Last Visit</th>
            <th class="sidepad">Active</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan=6>* Click on <span style="color:red">red</span> colored property to edit</td>
            <td><?=form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('userlib_delete_user_confirm').'\');"')?></td>
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
        <tr class="left_align">
            <td class="middle"><?=$row->id;?></td>
            <td class="center middle"><a class="preview sidepad" href="<?=site_url('/media/admin/media/overlay/'.$row->id.'?'.time());?>"><img src="<?php print base_url().'public/qr/'.get_avatar($row->id,$this->config->item('qrcode_save_path'),'.png',null,'_qr');?>" style="width:100px;height:100px;" alt="<?php print $row->username;?>" /></a></td>
            <td class="middle"><?php print $row->username.'<br />'.$row->conv_id;?></td>
            <td class="middle">
                <a class="preview" href="<?=site_url('/media/admin/media/contactlog/'.$row->id.'/'.time());?>">
                    <?=$row->firstname.' '.$row->lastname;?>
                </a><br />
                <?=$row->email?><br />
                <b><?=$row->company?></b><br />
                <?=$row->country?><br />
                M : <?=$row->mobile;?><br />
                P : <?=$row->phone;?><br />
                F : <?=$row->fax;?><br />
            </td>
            <td class="left middle" style="padding:5px;font-weight:bold;">
                Convention :<br />
                <span id="lock_conv_<?=$row->id;?>" style="font-size:105%;color:<?=($row->conv_lock)?'blue':'red';?>"><?php print ($row->conv_lock == 1)?'Paid':'Unpaid'?></span><br />
                Short Courses :<br />
                <span id="lock_sc_<?=$row->id;?>" style="font-size:105%;color:<?=($row->sc_lock)?'blue':'red';?>"><?php print ($row->sc_lock == 1)?'Paid':'Unpaid'?></span><br />
                <script>
                    
                    $('#lock_conv_<?=$row->id;?>').eip('<?=site_url('user/lockconv/'.$row->id)?>',
                        {
                            form_type:'select',
                            select_options:{
                                0:'Unpaid',
                                1:'Paid'
                            }
                        }
                    );
                    
                    $('#lock_sc_<?=$row->id;?>').eip('<?=site_url('user/locksc/'.$row->id)?>',
                        {
                            form_type:'select',
                            select_options:{
                                0:'Unpaid',
                                1:'Paid'
                            }
                        }
                    );
                </script>
                Golf :<br />
                <span" style="font-size:105%;color:blue"><?php print ($row->golf > 0)?'Yes':'No'?><?php print ($row->golf > 0 && $row->golfwait > 0)?' [ Wait List # '.$row->golfwait.' ]':''; ?></span><br />
                
            </td>
            <td class="center middle" style="padding:5px;"><?php print $row->created;?></td>
            <td class="center middle"><?php print $row->last_visit;?></td>
            <td class="center middle">
                <?php print ($row->active == 1)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
<?php else : ?>
    <tbody>
        <tr>
            <td colspan="7">No Member Record Found</td>
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