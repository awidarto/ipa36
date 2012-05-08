<h3><?php print $header?></h3>
<?php print form_open_multipart('user/changepic',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <label for="videofile">Upload picture (.jpg file only)</label>
                <input type="file" name="videofile" id="videofile" size="32" class="text" />
                <input type="hidden" name="doupload" id="doupload" value="true" />
                <div id="uploadfile" style="vertical-align:middle;height:25px;display:none;font-size:10px;">
                    <img src="<?=base_url()?>assets/images/ajax-loader.gif" style="margin-left:165px;" />Uploading...
                </div>
            </li>
            <li>
                <span>&nbsp;</span>
            </li>
            <li class="submit">
            	<div class="buttons">
            		<a href="<?php print base_url() ?>user/profile" class="negative" >
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>
            		<button type="submit" class="positive" name="submit" value="submit" onClick="javascript:showUpload();">
            			<?php print $this->bep_assets->icon('user') ?>
        			    Upload Picture
            		</button>
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>

<script>
    function showUpload(){
        $('#uploadfile').show();
    }
</script>