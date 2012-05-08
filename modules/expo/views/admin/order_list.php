<script>
$(document).ready(function() { 
    var currentid;

    $("a.preview").fancybox({ 
        'hideOnContentClick': true,
        'frameWidth' : 510,
        'frameHeight' : 410,
    }); 
    
    var dialogOpts = {
        modal: true,
        buttons: {
            "Ok": doDispatch,
            "Cancel":cancelDispatch
        },
        minheight: "350px",
        minwidth: "350px",
        autoOpen: false
    };
    
    $("#dispatch_form").dialog(dialogOpts);
    
	swfobject.registerObject("player","9.0.98","expressInstall.swf");
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
        <?= $this->page->icon('add');?>
        New Order
        </a>
    </div>
<?php endif;?>
<div class="clear"></div>
<table>
<?php if(isset($print)):?>
    <h2><?=$header;?></h2>
<?php endif;?>

<?=form_open('auth/admin/members/delete')?>
<table class="data_grid" cellspacing="0">
    <thead>
        <tr>
            <th width=5%>ID</th>
            <th>Order Name</th>
            <th>Client</th>
            <th>Media</th>
            <th>Media Type</th>
            <th>Start From</th>
            <th>End At</th>
            <th>Description</th>
            <th>Date Created</th>
            <th width=5% class="middle"><?=$this->lang->line('general_edit')?></th>
            <th width=10%><?=form_checkbox('all','select',FALSE)?><?=$this->lang->line('general_delete')?></th>        
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan=10>&nbsp;</td>
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
            <td><?=$row->ordername;?></td>
            <td><?=$row->clientid;?></td>
            <td><?=$row->mediaid;?></td>
            <td><?=$row->mediatype;?></td>
            <td><?=$row->monthstart."-".$row->yearstart;?></td>
            <td><?=$row->$row->monthend."-".$row->yearend;?></td>
            <td><?=$row->descriptions;?></td>
            <td><?=$row->datecreated;?></td>
            <td class="middle"><a href="<?=site_url('auth/admin/members/form/'.$row->id)?>"><?=img($this->config->item('shared_assets').'icons/pencil.png')?></a></td>
            <td><?=$delete?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php else : ?>
    	<tbody>
    	    <tr>
    	        <td colspan="11">No Files Found</td>
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

