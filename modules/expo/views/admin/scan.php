<?=form_open_multipart($this->controller.'/process'); ?>
<table>
<?php
    foreach($files as $key=>$val){
        if($key == 'video'){
            $ficon = $this->page->icon('film');
            $addlink = anchor('portal/admin/usermedia/add/'.$key,$this->page->icon('film_add'),'title="add video"');
        }else if($key == 'image'){
            $ficon = $this->page->icon('image');
            $addlink = anchor('portal/admin/usermedia/add/'.$key,$this->page->icon('image_add'),'title="add image"');
        }else if($key == 'audio'){
            $ficon = $this->page->icon('sounds/sound');
            $addlink = anchor('portal/admin/usermedia/add/'.$key,$this->page->icon('sounds/sound_add'),'title="add audio"');
        }else{
            $ficon = $this->page->icon('folder/folder');
            $addlink = anchor('portal/admin/usermedia/add/'.$key,$this->page->icon('page_add'),'title="add file"');
        }
?>
    <tr><td colspan="2"><?=$ficon;?>&nbsp;<?=$key;?></td><td>&nbsp;</td></tr>
    <?php
    foreach($val as $file){
        if($key == 'video'){
            $plink = anchor('portal/admin/usermedia/process/'.$key.'/'.$file,$this->page->icon('film_go'),'title="process video"');
            $link = 'portal/admin/usermedia/view/'.$key.'/'.$file['name'];
            $icon = anchor($link,$this->page->icon('film'),array("rel"=>"facebox","title"=>$file['name']));
            $dellink = anchor('portal/admin/usermedia/del/'.$key.'/'.$file['name'],$this->page->icon('film_delete'),array('title'=>'delete '.$key));
        }else if($key == 'image'){
            $plink = anchor('portal/admin/usermedia/process/'.$key.'/'.$file,$this->page->icon('pictures/picture_go'),'title="process image"');
            $icon = anchor($userurl.'/'.$key.'/'.$file['name'],$this->page->icon('image'),array("rel"=>"facebox","title"=>$file['name']));
            $dellink = anchor('portal/admin/usermedia/del/'.$key.'/'.$file,$this->page->icon('image_delete'),array('title'=>'delete '.$key));
        }else if($key == 'audio'){
            $plink = anchor('portal/admin/usermedia/process/'.$key.'/'.$file['name'],$this->page->icon('sounds/sound_go'),'title="process audio"');
            $link = 'portal/admin/usermedia/view/'.$key.'/'.$file['name'];
            $icon = anchor($link,$this->page->icon('sounds/sound'),array("rel"=>"facebox","title"=>$file['name']));
            $dellink = anchor('portal/admin/usermedia/del/'.$key.'/'.$file['name'],$this->page->icon('sounds/sound_delete',array('title'=>'delete '.$key)));
        }else if($key == 'other'){
            $plink = anchor('portal/admin/usermedia/process/'.$key.'/'.$file['name'],$this->page->icon('page_go'),'title="process file"');
            $link = 'portal/admin/usermedia/view/'.$key.'/'.$file['name'];
            $icon = anchor($link,$this->page->icon('page'),array("rel"=>"facebox","title"=>$file['name']));
            $dellink = anchor('portal/admin/usermedia/del/'.$key.'/'.$file['name'],$this->page->icon('page_delete'),array('title'=>'delete file'));
        }
        /*
            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?=$icon;?><?=$file;?></td><td>&nbsp;&nbsp;<?=$plink;?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$dellink?></td></tr>
        */
      ?>
          <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?=$icon;?><?=$file['name'];?></td><td>&nbsp;&nbsp;
            <?=$file['duration'];?> [ <?=$file['seconds'];?> sec. ]
            <input type="hidden" name="filename[]" value="<?=$file['name'];?>">
            <input type="hidden" name="duration[]" value="<?=$file['duration'];?>">
            <input type="hidden" name="seconds[]" value="<?=$file['seconds'];?>">
            <input type="hidden" name="type[]" value="<?=$key;?>">
          &nbsp;&nbsp;&nbsp;&nbsp;
            Title <input type="text" name="title[]" value="">
            Owner <select name="owner[]">
            <?php
                foreach($owners as $own){
                    print '<option value="'.$own['id'].':'.$own['username'].'" >'.$own['firstname'].' '.$own['lastname'].' [ '.$own['username'].' - '.$own['initial'].' ]</option>';
                }
            ?>
          </td></tr>
      <?  
    }
    ?>
<?php
    }
?>
</table>
<div class="buttons">
    <button type="submit" class="positive" name="submit" value="submit">
    	<?= $this->page->icon('disk');?>
    	<?=$this->lang->line('general_save')?>
    </button>
</div>
<?=form_close(); ?>