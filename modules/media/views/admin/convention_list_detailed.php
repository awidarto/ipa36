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

    
    $("#search_box").show();
    $("#search_toggle").html("Show Search");

    $("#summary_box").hide();
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

<div class="buttons">                
	<a href="<?php print  site_url('register/admin/register/user')?>">
    <?php print  $this->bep_assets->icon('add');?>
    New Convention Attendee
    </a>
</div><br/><br/>

<?=form_open('auth/admin/members/delete')?>
<table class="data_grid" cellspacing="0"  valign="middle" >
    <thead>
        <tr>
            <th class="middle top" >ID</th>
            <th class="sidepad top center">Company</th>
            <th class="sidepad top center">Photo</th>
            <th class="sidepad top center" style="width:200px;">Contacts</th>
            <th class="sidepad top center">Reg.<br />Date</th>
            <th class="sidepad top center" colspan="3">Sequences</th>
            <th class="sidepad top center">Convention</th>
            <th class="sidepad top center">Judge</th>
            <th class="sidepad top center" colspan="2">Golf</th>
            <th class="sidepad top center" colspan="2">Gala Dinner</th>
            <th class="sidepad top center" colspan="2">Fee</th>
            <th class="sidepad top center" colspan="2">Booth Assistants</th>
            <th class="sidepad top center" colspan="2">Fee</th>
            <th class="sidepad top center" colspan="2" >Exhibitor</th>
            <th class="sidepad top center" style="border-right:thin solid grey;">Media</th>
        </tr>
        <tr>
            <th class="sidepad">&nbsp;</th>
            <th class="sidepad" style="width:200px;">&nbsp;</th>
            <th class="sidepad" style="width:50px;">&nbsp;</th>
            <th class="sidepad">&nbsp;</th>
            <th class="sidepad">&nbsp;</th>
            <th class="sidepad">Conv</th>
            <th class="sidepad">SC</th>
            <th class="sidepad">Ex</th>
            <th class="sidepad">&nbsp;</th>
            <th class="sidepad">&nbsp;</th>
            <th class="sidepad">Attendance</th>
            <th class="sidepad">Wait List</th>
            <th class="sidepad">Main</th>
            <th class="sidepad">Additional</th>
            <th class="sidepad top center">IDR</th>
            <th class="sidepad top center">USD</th>
            <th class="sidepad">30</th>
            <th class="sidepad">150</th>
            <th class="sidepad top center">IDR</th>
            <th class="sidepad top center">USD</th>
            <th class="sidepad">Exhibitor</th>
            <th class="sidepad">Entitled</th>
            <th class="sidepad" style="border-right:thin solid grey;">&nbsp;</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="25"  style="border-right:thin solid grey;">* Click on <span style="color:red">red</span> colored property to edit</td>
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
            $picture = get_avatar($row->id,$this->config->item('public_folder').'avatar/');
            
            //print_r($row);
        ?>
        <tr class="left_align" id="<?=$row->id;?>">
            <td class="middle top"  style="padding: 5px 2px;"><?=$row->id;?></td>
            <td class="top" style="padding:5px;">
                <b><?=$row->company?></b><br />
                <?=$row->country?><br />
                <!--
                    P : <?=$row->phone;?><br />
                    F : <?=$row->fax;?><br />
                -->
            </td>
            <td class="top" style="padding:5px;">
                <img style="width:50px;height:70px;" src="<?php print base_url().'public/avatar/'.$picture.'?'.time();?>" />
            </td>
            <td class="middle top" style="padding:5px;width:200px;">
                <a class="preview" href="<?=site_url('/media/admin/media/contactlog/'.$row->id.'/'.time());?>">
                    <?=$row->firstname.' '.$row->lastname;?>
                </a><br />
                <?=$row->conv_id?><br />
                username :<br />
                <strong><?=$row->username?></strong><hr />
                <!--
                    <?=$row->email?><br />
                    M : <?=$row->mobile;?><br />
                -->
                <a class="uploadpic" href="<?=site_url('/media/admin/media/uploadpic/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('picture_add')?>Upload Photo
                </a><br />
                <a class="snappic" href="<?=site_url('/media/admin/media/snappic/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('camera')?>Take Photo
                </a><br />
                <a target="_blank" href="<?=site_url('/media/admin/media/printbadge/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('printer')?>Print Badge
                </a><br />

                <a class="invoice" href="<?=site_url('/media/admin/media/invoice/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('printer')?>Print Invoice
                </a><br />

                <a class="receipt" href="<?=site_url('/media/admin/media/receipt/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('printer')?>Print Receipt
                </a><br />
                
                <a class="updateinfo" href="<?=site_url('register/admin/register/user/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('pencil')?>Edit Profile
                </a><br />

                <a class="updateinfo" href="<?=site_url('/register/admin/register/convention/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('pencil')?>Change Convention Info
                </a><br />
            
                <a class="updateinfo" href="<?=site_url('/register/admin/register/shortcourses/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('pencil')?>Change Short Courses Info
                </a><br />

                <?php if(check('SuperQuad',NULL,FALSE)):?><br /><br /><span style="cursor:pointer;" onClick="javascript:delUser(<?=$row->id;?>);"><?php print $this->bep_assets->icon('bin')?>Delete</span><?php endif;?>

                <?php if(check('SuperQuad',NULL,FALSE)):?><br />
                <a class="changepass" href="<?=site_url('/user/admin/user/changepass/'.$row->id.'/'.time());?>">
                    <?php print $this->bep_assets->icon('pencil')?>Change Password
                </a>
                <?php endif;?>

            </td>
            <td class="middle top"  style="padding: 5px 2px;"><?=date('d-m-Y h:m:s',human_to_unix($row->created));?></td>
            <td class="middle top"  style="padding: 5px 2px;"><?=$row->conv_seq;?></td>
            <td class="middle top"  style="padding: 5px 2px;"><?=$row->sc_seq;?></td>
            <td class="middle top"  style="padding: 5px 2px;"><?=$row->ex_seq;?></td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print ($row->registertype > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?><br />
                <?php if($row->registertype > 0):?>
                    <?php  print $row->registrationtype;?><br />
                    <?php if($row->foc == 1):?>
                        <span style="font-size:105%;color:blue;" >Free of Charge</span>
                    <?php else:?>
                        <span id="lock_conv_<?=$row->id;?>" style="font-size:105%;color:<?=($row->conv_lock)?'blue':'red';?>">
                        <?php print ($row->conv_lock == 1)?'Paid':'Unpaid'?></span>
                    <?php endif;?>
                <?php endif;?>
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print ($row->judge == 'yes')?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="center middle" style="padding:5px;font-weight:bold;">
                <?php print ($row->golf > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
                <?php if($row->golf > 0) :?>
                <br />
                <span id="lock_sc_<?=$row->id;?>" style="font-size:105%;color:<?=($row->sc_lock)?'blue':'red';?>"><?php print ($row->sc_lock == 1)?'Paid':'Unpaid'?></span><br />
                <?php endif;?>
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
            </td>
            <td class="center middle orange" style="padding:5px;font-weight:bold;">
                <?php print ($row->golf > 0 && $row->golfwait > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
                <?php print ($row->golf > 0 && $row->golfwait > 0)?'<br /># '.$row->golfwait:''; ?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print ($row->galadinner > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="center middle orange" style="padding:5px;">
                <?php print ($row->galadinneraux > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="right center"  style="padding: 5px 2px;"><?=number_format($row->total_idr);?></td>
            <td class="right center"  style="padding: 5px 2px;"><?=number_format($row->total_usd);?></td>
            <td class="center middle orange" style="padding:5px;">
                <?php print ($row->ba30 > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="center middle" style="padding:5px;">
                <?php print ($row->ba150 > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="right center"  style="padding: 5px 2px;"><?=number_format($row->total_idr_sc);?></td>
            <td class="right center"  style="padding: 5px 2px;"><?=number_format($row->total_usd_sc);?></td>
            <td class="center middle" style="padding:5px;">
                <?php print ($row->exhibitor > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="center middle" style="padding:5px;">
                <?php print ($row->foc > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
            </td>
            <td class="center middle orange" style="padding:5px;border-right:thin solid grey;">
                <?php print ($row->media > 0)?$this->bep_assets->icon('tick'):$this->bep_assets->icon('cross');?>
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

