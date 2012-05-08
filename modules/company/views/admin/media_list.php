<script>
$(document).ready(function() { 
    var currentid;

    $("a.preview").fancybox({ 
        'hideOnContentClick': true,
        'frameWidth' : 510,
        'frameHeight' : 410,
    }); 
    
	//swfobject.registerObject("player","9.0.98","expressInstall.swf");
}); 


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
    <div class="buttons">                
    	<a href="<?= site_url($controller.'/form')?>">
        <?= $this->bep_assets->icon('add');?>
        Upload Media File
        </a>
    </div>
<?php endif;?>

<table>
<?php if(isset($print)):?>
    <h2><?=$header;?></h2>
<?php endif;?>

<?=form_open('auth/admin/members/delete')?>
<table class="data_grid" cellspacing="0">
    <thead>
        <tr>
            <th width=5%>ID</th>
            <th>Datecreated</th>
            <th>Mediatype</th>
            <th>Ownerid</th>
            <th>Owner Name</th>
            <th width=5% class="middle"><?=$this->lang->line('general_edit')?></th>
            <th width=10%><?=form_checkbox('all','select',FALSE)?><?=$this->lang->line('general_delete')?></th>        
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan=7>&nbsp;</td>
            <td><?=form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('userlib_delete_user_confirm').'\');"')?></td>
        </tr>
    </tfoot>
<?php if(isset($documents)): ?>
    <tbody>
        <?php foreach($documents as $row):
            // Check if this user account belongs to the person logged in
            // if so don't allow them to delete it
            $delete  = ($row->id == $this->session->userdata('id')?'&nbsp;':form_checkbox('select[]',$row->id,FALSE)); 
            
            if($row->thumbnail == ""){
                if($row->mediatype == "audio"){
                    $thumb = base_url().'public/images/audio.png';
                }else if($row->mediatype == "image"){
                    $thumb = base_url().'public/images/picture.png';
                }else if($row->mediatype == "video"){
                    $thumb = base_url().'public/images/video.png';
                }else{
                    $thumb = base_url().'public/images/document.png';
                }
            }else{
                $thumb = base_url().'public/media/'.$row->mediatype.'/thumb/'.$row->thumbnail;
            }
                       
        ?>
        <tr>
            <td><?=$row->id;?></td>
            <!--
            <td style="text-align:center;">
                <a class="preview" href="<?=base_url().'media/admin/media/preview/'.$row->id.'/'.$row->uid;?>"><img style="vertical-align:center;" src="<?=$thumb;?>" alt="<?=$row->thumbnail?>"></a>
            </td>
            -->
            <td><?=$row->datecreated;?></td>
            <td><?=$row->title;?></td>
            <td><?=$row->uid;?></td>
            <td><?=$row->fullname;?></td>
            <td class="middle"><a href="<?=site_url('auth/admin/members/form/'.$row->id)?>"><?=img($this->config->item('shared_assets').'icons/pencil.png')?></a></td>
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