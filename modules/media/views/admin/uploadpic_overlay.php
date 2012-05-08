<?php print $this->bep_assets->get_header_assets();?>
<?php print $this->bep_site->get_js_blocks();?>

<div style="width:300px;height:200px;">

    <h3>Upload Photo for <?=$user['firstname'].' '.$user['lastname'];?></h3>
    <?php print form_open_multipart('media/admin/media/changepic/'.$id,array('class'=>'horizontal'))?>
        <fieldset>
            <ol>
                <li>
                    <label for="videofile">Upload picture (.jpg file only)</label>
                    <input type="file" name="videofile" id="videofile" size="32" class="text" />
                    <input type="hidden" name="doupload" id="doupload" value="true" />
                    <div id="uploadfile" style="vertical-align:left;height:25px;display:none;font-size:10px;">
                        <img src="<?=base_url()?>assets/images/ajax-loader.gif" style="margin-left:10px;" />Uploading...
                    </div>
                </li>
                <li>
                    <span>&nbsp;</span>
                </li>
                <li class="submit">
                	<div class="buttons">
                		<button type="submit" class="positive" name="submit" value="submit" onClick="javascript:showUpload();">
                			<?php print $this->bep_assets->icon('user') ?>
            			    Upload Picture
                		</button>
                	</div>
                </li>
            </ol>
        </fieldset>
    <?php print form_close()?>
    
</div>

<script>
    function showUpload(){
        $('#uploadfile').show();
    }
</script>