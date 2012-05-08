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

    $("a.printview").fancybox({ 
        'hideOnContentClick': false,
        'showCloseButton': true,
        'frameWidth' : 800,
        'frameHeight' : 500,
    }); 

    $("a.invoice").fancybox({ 
        'hideOnContentClick': false,
        'showCloseButton': true,
        'frameWidth' : 800,
        'frameHeight' : 500,
    }); 

    $("a.receipt").fancybox({ 
        'hideOnContentClick': false,
        'showCloseButton': true,
        'frameWidth' : 800,
        'frameHeight' : 500,
    }); 


    $("a.uploadpic").fancybox({ 
        'hideOnContentClick': false,
        'autoDimensions': true,
        'showCloseButton': true,
        'width' : 350,
        'height' : 250,
        'scrolling': 'no',
        'type': 'iframe'
    }); 

    $("a.changepass").fancybox({ 
        'hideOnContentClick': false,
        'autoDimensions': true,
        'showCloseButton': true,
        'width' : 350,
        'height' : 250,
        'scrolling': 'no',
        'type': 'iframe'
    }); 

    $("a.updateinfo").fancybox({ 
        'hideOnContentClick': false,
        'autoDimensions': true,
        'showCloseButton': true,
        'width' : 800,
        'height' : 600,
        'scrolling': 'yes',
        'type': 'iframe'
    }); 


    $("a.snappic").fancybox({ 
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

function delUser(id){
    var del_ok = confirm("Sure to delete user " + id + " ?");
	if (del_ok){
		$.post("<?php print site_url('media/admin/media/delusr'); ?>", 
            { 'userid':id },
            function(data){
                alert(data.msg);
                if(data.id == id){
                    $("#"+id).hide();
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
            padding:3px;
        }
        
        .toggle_tab{
            border-top:thin solid grey;
            border-left:thin solid grey;
            border-right:thin solid grey;
            padding:5px;
            width:150px;
            text-align:left;
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
        
        table a {
            text-decoration:none;
        }
        
        table a img{
            padding-right:3px;
        }
        
    </style>

    <?php if(isset($summary_list)):?>
    <div class="toggle_bar" ><div class="toggle_tab"><?php print $this->bep_assets->icon('application_view_detail');?><span id="summary_toggle" onClick="javascript:toggleSummary();" style="cursor:pointer;">Show Summary</span></div></div>
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
    <div class="toggle_bar" ><div class="toggle_tab"><?php print $this->bep_assets->icon('zoom');?><span id="search_toggle" onClick="javascript:toggleSearch();" style="cursor:pointer;">Show Search</span></div></div>
    <div class="box">
        <div id="search_box">
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
            <th class="sidepad top center" style="width:50px;">Time In</th>
            <th class="sidepad top center" style="width:50px;border-right:thin solid grey;">Time Out</th>
            <th class="middle top"  style="width:5%;" >ID</th>
            <th class="sidepad top center" style="width:5%;">Check Point</th>
            <th class="sidepad top center" style="width:50px;">Photo</th>
            <th class="sidepad top center" style="width:200px;">Person</th>
        </tr>                                     
    </thead>
    <tfoot>
        <tr>
            <td colspan="6"  style="border-right:thin solid grey;">* Click on <span style="color:red">red</span> colored property to edit</td>
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
            $picture = get_avatar($row->user_id,$this->config->item('public_folder').'avatar/','.jpg','','_vis_sm');
            
            //print_r($row);
        ?>
        <tr class="left_align" id="<?=$row->id;?>">
            <td class="middle center"  style="padding: 5px 2px;"><?=($row->is_in == 1)?date('d-m-Y h:m:s',human_to_unix($row->check_datetime)):'-';?></td>
            <td class="middle center"  style="padding: 5px 2px;border-right:thin solid grey;"><?=($row->is_out == 1)?date('d-m-Y h:m:s',human_to_unix($row->check_datetime)):'-';?></td>
            <td class="top center"  style="padding: 5px 2px;"><?=$row->user_id;?></td>
            <td class="top center" style="padding:5px;">
                <b><?=$row->checkpoint?></b>
            </td>
            <td class="top" style="padding:5px;">
                <img style="width:50px;height:70px;" src="<?php print base_url().'public/avatar/'.$picture.'?'.time();?>" />
            </td>
            <td class="middle" style="padding:5px;width:200px;">
                <a class="preview" href="<?=site_url('/media/admin/media/contactlogvis/'.$row->user_id.'/'.time());?>">
                    <?=$row->firstname.' '.$row->lastname;?>
                </a><br />
                <?=$row->conv_id?><br />
                <?=$row->registrationtype;?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
<?php else : ?>
    <tbody>
        <tr>
            <td colspan="9">No Member Record Found</td>
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

