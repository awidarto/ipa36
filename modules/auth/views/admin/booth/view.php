<h2><?php print $header?></h2>

<style>
    .closed{
        padding:3px 5px;
        color:white;
        background-color:red;
        display:block;
    }
    
    .booked{
        padding:3px 5px;
        color:yellow;
        background-color:maroon;
        display:block;
    }

    .preassigned{
        padding:3px 5px;
        color:white;
        background-color:blue;
        display:block;
    }

    .sold{
        padding:3px 5px;
        color:maroon;
        background-color:yellow;
        display:block;
    }
    
    .open{
        padding:3px 5px;
        color:black;
        background-color:#eee;
        display:block;
    }
    
    .data_grid th{
        padding:3px 5px;
    }

    .data_grid td{
        text-align:center;
    }
    
    .red{
        color:red;
        font-weight:bold;
    }

</style>

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

<!--
<div class="buttons">                
	<a href="<?php print  site_url('auth/admin/booth/form')?>">
    <?php print  $this->bep_assets->icon('add');?>
    Add Booth
    </a>
</div><br/><br/>
-->
<div id="summary" style="font-weight:bold;font-size:18px;color:maroon;">
    Total Sold : USD <?=number_format($total_sold_rev);?><br /> 
    Total Booking Worth : USD <?=number_format($total_rev);?><br /> 
    Booth Sold <?=$total_sold;?> units of <?=$total_booth;?> (<?=floor(($total_sold/$total_booth)*100);?>%)<br />
    Booth Reserved <?=$total_book;?> units of <?=$total_booth;?> (<?=floor(($total_book/$total_booth)*100);?>%)<br />
    Area Sold <?=$total_sold_area;?> square meters of <?=$total_area;?> square meters (<?=floor(($total_sold_area/$total_area)*100);?>%)<br />
    Area Reserved <?=$total_book_area;?> square meters of <?=$total_area;?> square meters (<?=floor(($total_book_area/$total_area)*100);?>%)
</div>

<?php print form_open('auth/admin/members/delete')?>
<table class="data_grid" cellspacing="0">
    <thead>
        <tr>
            <th width=5%><?php print $this->lang->line('general_id')?></th>
            <th>Booth</th>
            <th>Dimension</th>
            <th>Area</th>
            <th>Type</th>
            <th>Position</th>
            <th>Price / Sq meter</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Company</th>
            <th>Last Update</th>
            <th width=5% class="middle"><?php print $this->lang->line('general_edit')?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan=13>&nbsp;</td>
            <td><?php //print form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('userlib_delete_user_confirm').'\');"')?></td>
        </tr>
    </tfoot>
    <tbody>
        <?php 
            $total_rev = 0;
            foreach($members->result_array() as $row):
        ?>
        <tr id="<?=$row['booth_number'];?>">
            <td><?php print $row['id']?></td>
            <td><?php print $row['booth_number']?></td>
            <td><?php print $row['width'].' m x '.$row['length']?> m</td>
            <td><?php print $row['area']?> sqm</td>
            <td><?php print $row['type']?></td>
            <td><?php print $row['hall']?></td>
            <td>USD <?php print number_format($row['price_sqm'])?></td>
            <td>USD <?php print number_format($row['price_total'])?></td>
            <td class="<?php print $row['orderstatus']?>" ><?php print $row['orderstatus']?></td>
            <td><?php print $row['orderby']?></td>
            <?php 
                if((time() - strtotime($row['ordertimestamp'])) > (7*24*60*60)){
                    $class = 'class="red"';
                }else{
                    $class = '';
                } ?>
            <td <?php print $class; ?> ><?php print $row['ordertimestamp']?></td>
            <td class="middle">
                <?php if($row['orderstatus'] == 'preassigned'):?>
                <a href="<?php print site_url('auth/admin/booth/form/'.$row['id'])?>"><?php print $this->bep_assets->icon('pencil');?></a>
                <?php elseif($row['orderstatus'] == 'booked'): ?>
                    <span style="cursor:pointer;" onClick="javascript:ajaxSold('<?=$row['booth_number']?>')"><?php print $this->bep_assets->icon('key');?></span>
                    &nbsp;
                <?php endif;?>
                <?php if($row['orderstatus'] == 'booked' || $row['orderstatus'] == 'sold'): ?>
                    <span style="cursor:pointer;" onClick="javascript:ajaxRelease('<?=$row['booth_number']?>')"><?php print $this->bep_assets->icon('arrow_refresh');?></span>
                <?php endif;?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php print form_close()?>
<div id="process" style="display:none;padding:5px;font-weight:bold;color:white;background-color:red;position:absolute;right:0px;top:0px;">
    Processing...
</div>