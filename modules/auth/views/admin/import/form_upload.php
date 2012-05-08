<h3><?php print $header?></h3>
<?php print form_open_multipart('auth/admin/import',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <label for="picemail">Person In Charge Email*</label>
                <input type="text" name="picemail" id="picemail" size="32" class="text" />
            </li>
            <li>
                <label for="picemail">Person In Charge Full Name*</label>
                <input type="text" name="picname" id="picname" size="32" class="text" />
            </li>
            <li>
                <label for="mobilephone">Mobile Phone</label>
                <input type="text" name="mobilephone" id="mobilephone" size="32" class="text" />
            </li>
            <li>
                <label for="picemail">Company*</label>
                <input type="text" name="company" id="company" size="32" class="text" />
            </li>
            <li>
                <label for="picemail">NPWP ( Indonesian Company Only )</label>
                <input type="text" name="companynpwp" id="companynpwp" size="32" class="text" />
            </li>
            <li>
                <label for="picemail">Company Address*</label>
                <input type="text" name="companyaddress" id="companyaddress" size="32" class="text" />
            </li>
            <li>
                <label for="picemail">Company Phone</label>
                <input type="text" name="companyphone" id="companyphone" size="32" class="text" />
            </li>
            <li>
                <label for="excelfile">Upload Excel File (.xls MsExcel97 format or less )</label>
                <input type="file" name="excelfile" id="excelfile" size="32" class="text" />
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

<script>
    function showUpload(){
        $('#uploadfile').show();
    }
</script>