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

<?=form_open('auth/admin/members/delete')?>
<table class="data_grid" cellspacing="0"  valign="middle" >
    <thead>
        <tr>
            <th width=5%>ID</th>
            <th width=10%>&nbsp;</th>
            <th >Fullname</th>
            <th width=100>Reg. Date</th>
            <th >Reg. From</th>
            <th width=200>&nbsp;</th>
            <th width=10%>&nbsp;</th>
            <th >Active</th>
            <th width=5% class="middle"><?=$this->lang->line('general_edit')?></th>
            <th width=10%><?=form_checkbox('all','select',FALSE)?><?=$this->lang->line('general_delete')?></th>        
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan=9>&nbsp;</td>
            <td><?=form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('userlib_delete_user_confirm').'\');"')?></td>
        </tr>
    </tfoot>
<?php if(isset($documents)): ?>
    <tbody>
        <?php foreach($documents as $row):
            // Check if this user account belongs to the person logged in
            // if so don't allow them to delete it
            $delete  = ($row->id == $this->session->userdata('id')?'&nbsp;':form_checkbox('select[]',$row->id,FALSE)); 
            if(count($row->videos) > 0 && is_array($row->videos)){
                $video_count = $this->bep_assets->icon('film','title').' '.count($row->videos).' Video';
                $video_list = array();
                foreach($row->videos as $v){
                    $video_list[] = '<span id="'.$v['filename'].'">'.$v['filename'].' ['.$v['size'].']</span>&nbsp;&nbsp;&nbsp;<span style="cursor:pointer;" onclick="delFile(\''.$v['filename'].'\')">[ delete ]</span>';
                }
                $video_list = implode('<br />',$video_list);
            }else{
                $video_count = $this->bep_assets->icon('film_error').' No Video';
                $video_list = '';
            }           
                       
        ?>
        <tr>
            <td class="middle"><?=$row->id;?></td>
            <td class="middle"><a class="preview" href="<?=site_url('/media/admin/media/overlay/'.$row->id.'?'.time());?>"><img src="<?php print base_url().'public/avatar/'.get_avatar($row->id,null,'_sm');?>" alt="<?php print $row->username;?>" /></a></td>
            <?php 
                $rev = '<span class="revd">reviewed</span>'; 
                $flag = '<span class="flagged">flagged</span>'; 
                $flagthis = '<span class="flagthis" onClick="javascript:flagthis('.$row->id.');">flag this !</span>'; 
                /*<td class="center"><?php print ($row->flagged)?$flag:$flagthis; ?></td>*/
            ?>
            <td class="center"><a class="preview" href="<?=site_url('/media/admin/media/overlay/'.$row->id.'?'.time());?>"><?=$row->fullname;?></a><br /><?=$row->email?></td>
            <td class="center"><?=$row->fcreated;?></td>
            <td class="center"><?=($row->mobreg)?'SMS':'Web';?></td>
            <td class="center"><?php print $video_count.'<br />'.$video_list ?></td>
            <td class="center"><?php print ($row->reviewed)?$rev:'' ?></td>
            <td class="center">
            <?php print ($row->active == 1)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="center"><a href="<?=site_url('auth/admin/members/form/'.$row->id)?>"><?=img($this->config->item('shared_assets').'icons/pencil.png')?></a></td>
            <td><?=$delete?></td>
        </tr>

        <?php endforeach; ?>
    </tbody>
<?php else : ?>
    <tbody>
        <tr>
            <td colspan="7">No Files Found</td>
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