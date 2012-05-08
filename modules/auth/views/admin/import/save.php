<h3><?php print $header?></h3>
<ul>
    <li><?=$inserts_count;?> new user registered</li>
    <li><?=$updates_count;?> user data updated</li>
</ul>
<style>
    label .email{
        color:maroon;
    }
</style>

<?php print form_open_multipart('auth/admin/import/upload',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
        <?php foreach($users as $user) :?>
            <li>
                <label for="picemail"><?=$user['firstname'].' '.$user['lastname'].'<br /> <span class="email">'.$user['email'].'</span>';?></label>
                <input type="file" name="userfile_<?php print $user['email'];?>" id="userfile_<?php print $user['email'];?>" size="32" class="text" />
                <input type="hidden" value="<?php print $user['email'];?>" name="email[]" id="email" size="32" class="text" />
            </li>
        <?php endforeach;?>
        
        <li class="submit">
        	<div class="buttons">
        		<a href="<?php print base_url() ?>auth/admin/import" class="negative" >
        			<?php print $this->bep_assets->icon('cross') ?>
        			<?php print $this->lang->line('general_cancel')?>
        		</a>
        		<button type="submit" class="positive" name="submit" value="submit" onClick="javascript:showUpload();">
        			<?php print $this->bep_assets->icon('user') ?>
    			    Upload File
        		</button>
        	</div>
        </li>
        
        
        </ol>
    </fieldset>
<?php print form_close()?>

<?php
//print_r($inserts);
//print_r($updates);
?>
<table border=1 width="100%">

<?php
/*
foreach($inserts as $in){
    print '<tr>';
        foreach($in as $key=>$val){
            print '<td>';
            print $key;
            print '</td>';    
        }
    print '</tr>';
    print '<tr>';
        foreach($in as $key=>$val){
            print '<td>';
            print $val;
            print '</td>';    
        }
    print '</tr>';
}
*/
?>
</table>