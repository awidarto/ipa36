<script>
$(document).ready(function() { 
    var currentid;

    $("a.preview").fancybox({ 
        'hideOnContentClick': true,
        'frameWidth' : 700,
        'frameHeight' : 500,
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

}); 

function openDispatch(id){
    currentid = id;
    $("#dispatch_form").dialog("open");
}

function doDispatch(){
    $("#dispatch_form_table").hide();
    $("#dispatch_progress").show();
    $.post("<?=base_url()?>documents/dispatch/"+currentid, 
        { 
            doc_loc_warehouse: $("#dispatch_loc").val(),
            doc_loc_warehouse_box: $("#dispatch_box").val()
        },
      function(data){
          if(data.result == "ok"){
              $("#dispatch_progress").hide();
              $("#dispatch_form_table").show();
              $("#dispatch_form").dialog("close");

              $("#dispatch_"+currentid).html(data.warehouse+" - "+data.box);
              $("#dispatch_trigger_"+currentid).hide();
              $("#undispatch_trigger_"+currentid).show();
          }else{
              alert("Dispatch failed");
          }
      }, "json");
    
}

function cancelDispatch(){
    $("#dispatch_form_table").show();
    $("#dispatch_progress").hide();
    $("#dispatch_form").dialog("close");
}

function doUnDispatch(id){
    $.post("<?=base_url()?>documents/undispatch/"+id, 
        { 
            doc_loc_warehouse: $("#dispatch_loc").val(),
            doc_loc_warehouse_box: $("#dispatch_box").val()
        },
      function(data){
        if(data.result == "ok"){
            $("#dispatch_"+id).html("");
            $("#undispatch_trigger_"+id).hide();
            $("#dispatch_trigger_"+id).show();
        }
      }, "json");
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
<?php endif;?>

<?php if(isset($documents)): ?>
<table>
<?php if(isset($print)):?>
    <h2><?=$header;?></h2>
<?php else:?>
    <tr>
        <td colspan="4"  style="height:45px">
        <div class="buttons">                
        	<a href="<?= site_url($controller.'/form')?>">
            <?= $this->page->icon('add');?>
            New Document
            </a>
        </div>
        </td>
    </tr>
    <tr>
        <td colspan="4"  style="height:45px">
        <?=$exportlink; ?>
        </td>
    </tr>
<?php endif;?>
    
    <?php foreach($documents as $d) : ?>
    		<tr><td width="120">Doc. Number</td><td><?=$d->doc_number?></td>
	            <td width="120">Call Number</td><td><?=$d->doc_callnumber; ?></td></tr>
    	    <tr><td>Date</td><td><?=$d->doc_date; ?></td>
    		    <td>Keyword</td><td><?=$d->doc_keyword; ?></td></tr>
    		<tr><td>Subject</td><td><?=$d->doc_subject; ?></td>
    		    <td>Company</td><td><?=$d->doc_call_company;?></td></tr>
    		<tr><td>Originator</td><td><?=$d->doc_originator?></td>
    		    <td>Classification</td><td><?=$d->doc_classification?></td></tr>
    		<tr><td>Addressee</td><td><?=$d->doc_addressee?></td>
    		    <td>Retention Limit</td><td><?=$d->doc_retention?></td></tr>
    		<tr><td>Attention</td><td><?=$d->doc_attention?></td>
    		    <td>Original Custody</td><td><?=($d->doc_loc_warehouse =='')?$d->doc_custody:''?></td></tr>
    		<tr><td>Copy & Distribution</td><td><?=$d->doc_route?></td>
    		    <td>Location</td><td><?=($d->doc_loc_warehouse =='')?$d->doc_loc_main:'';?></td></tr>
    		<tr><td>Doc. Group</td><td><?=$d->doc_group?></td>
    		    <td>Folder</td><td><?=($d->doc_loc_warehouse =='')?$d->doc_loc_folder:'';?></td></tr>
            <tr><td>Doc. Type</td><td><?=$d->doc_type?></td>
    		    <td>Dispatch</td><td id="dispatch_<?=$d->id; ?>"><?=$d->doc_loc_warehouse.'-'.$d->doc_loc_warehouse_box; ?></td></tr>
    		    
	    <?php if(!isset($print)):?>
            <tr><td >&nbsp;</td>
                <td colspan = "3" style="text-align:right;align:right">
            		<?=anchor('documents/form/'.$d->id, 'Edit',array('class'=>'edit'));?>
            		<?//=($d->doc_loc_warehouse =='')?anchor('docs/dispatch/'.$d->doc_id, 'Dispatch'):anchor('docs/undispatch/'.$d->doc_id, 'Retrieve from Dispatch Loc.', array('onClick'=>"return confirm('Do you want to restore document to previous location ?');"));?>
            		
            		<?php
            		    if($d->doc_loc_warehouse !=""){
            		        $dispatch_button = '<span id="dispatch_trigger_'.$d->id.'" style="cursor:pointer;display:none;"  class="edit"  onClick="openDispatch('.$d->id.');">Dispatch</span><span id="undispatch_trigger_'.$d->id.'" style="cursor:pointer;" class="edit" onClick="doUnDispatch('.$d->id.');">Undispatch</span>';
            		    }else{
            		        $dispatch_button = '<span id="dispatch_trigger_'.$d->id.'" style="cursor:pointer;"  class="edit"  onClick="openDispatch('.$d->id.');">Dispatch</span><span id="undispatch_trigger_'.$d->id.'" style="cursor:pointer;display:none;" class="edit" onClick="doUnDispatch('.$d->id.');">Undispatch</span>';
            		    }
            		?>
            		<?=$dispatch_button;?>
            		<?//=($d->doc_loc_warehouse =='')?'<span id="dispatch_trigger_'.$d->id.'" style="cursor:pointer;"  class="edit"  onClick="openDispatch('.$d->id.');">Dispatch</span>':'<span id="dispatch_trigger_'.$d->id.'" style="cursor:pointer;" class="edit" onClick="doUnDispatch('.$d->id.');">Undispatch</span>';?>
            		<?=anchor('documents/delete/'.$d->id, 'Delete', array('onClick'=>"return confirm('Are you sure you want to delete this document ?');",'class'=>'delete'));?>
            		<?php if($d->doc_file_id != 'no_file'): ?>
            		    <?php
            		        if(isset($d->active_preview_files) && $d->active_preview_files != false){
                		        $fc = 0;
            		            foreach($d->active_preview_files as $af){
                		                $style = ($fc != 0)?'style="display:none"':'';
                		            ?>
                                        <a href="<?=base_url()?>public/storage/<?=$d->doc_file_id."/".$d->preview_path."/".$af ?>" alt="<?=$af;?>" rel="<?=$d->preview_path?>" class="edit preview" <?=$style;?> >Preview Digital Doc</a>
                		            <?php
                		            $fc++;
            		            }
            		        }else if($d->active_file && $d->active_file->is_image){
            		            ?>
                                        <a href="<?=base_url()?>public/storage/<?=$d->doc_file_id."/".$d->active_file->file_name ?>" alt="<?=$d->active_file->file_name;?>" class="edit preview" >Preview Digital Doc</a>
            		            <?
            		        }
            		    ?>
            		    <?=anchor('documents/stream/'.$d->doc_file_id, 'Download Digital Doc','class="edit"');?>
            		<?php endif;?>
                </td>
            </tr>
        <?php endif;?>
            <tr><td colspan = "4" style="border-top:thin solid grey;" >&nbsp;</td></tr>
    <?php endforeach;?>
</table>
<?php else : ?>
	No Files Found
<?php endif; ?>
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
<?php
/*
    <tr>
        <td>&nbsp;</td>
        <td>
        <div class="buttons"> 
            <button type="submit" class="positive" name="submit" value="submit"  onClick="javascript:doDispatch()">
            	<?= $this->page->icon('disk');?>
            	<?=$this->lang->line('general_save')?>
            </button>

            <a href="<?= site_url($controller)?>" class="negative"  onClick="javascript:cancelDispatch()">
            	<?= $this->page->icon('cross');?>
            	<?=$this->lang->line('general_cancel')?>
            </a>
        </div>
    </tr>
*/

?>