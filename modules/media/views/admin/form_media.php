<script>

function collectVar(select){
    var x = new Array();
    var i = 0;
    jQuery(select+':checked').each(
        function(){
            x[i] = this.value;
            i++;
        }
    );

    return x;
}

function setCallDate(id){
    var newval = $(id).val();
    var calldate = newval.slice(5,7)+newval.slice(2,4);
    $('#doc_call_date').val(calldate);
    $('#generating').show();
    $.post('<?=base_url();?>documents/callseq/'+calldate, { callmain:'calldate' },
      function(data){
        $('#doc_call_seq').val(data.callseq);
        $('#generating').hide();
      }, "json");
}

function formatItem(row) {
	return row[0] + " (<strong>id: " + row[1] + "</strong>)";
}

function formatItemSingle(row) {
	return row[0];
}

function formatResult(row) {
	return row[0].replace(/(<.+?>)/gi, '');
}

$().ready(function() {
    $("#doc_route").autocomplete('<?=base_url()?>documents/searchusers', {
    	width: 300,
    	multiple: true,
    	matchContains: true,
    	formatItem: formatItemSingle,
    	formatResult: formatResult
    });

    $("#doc_custody").autocomplete('<?=base_url()?>documents/searchusers', {
    	width: 300,
    	multiple: true,
    	matchContains: true,
    	formatItem: formatItemSingle,
    	formatResult: formatResult
    });

    $("#doc_keyword").autocomplete('<?=base_url()?>documents/searchkeywords', {
    	width: 300,
    	multiple: true,
    	matchContains: true,
    	formatItem: formatItemSingle,
    	formatResult: formatResult
    });

    $("#doc_loc_folder").autocomplete('<?=base_url()?>documents/searchfolders', {
    	width: 300,
    	multiple: true,
    	matchContains: true,
    	formatItem: formatItemSingle,
    	formatResult: formatResult
    });

});

</script>

<?=form_open_multipart('documents/form/'.$this->validation->id); ?>
<!--<fieldset>-->
<table width="100%">
    <tr valign="top">
    <td style="width:50%">
        <input type="hidden" name="doc_id" value="<?=$this->validation->doc_id;?>" />
        <input type="hidden" name="doc_date_create" value="<?=$this->validation->doc_date_create;?>" />
        <p>
            <?=form_label('Doc. Number','doc_number')?>
            <?=form_input('doc_number',$this->validation->doc_number,'id="doc_number" class="text"')?>
        </p>
        <p>
            <?=form_label('Doc. Date','doc_date')?>
            <?=form_input('doc_date',$this->validation->doc_date,'id="doc_date" class="text" onChange="setCallDate(\'#doc_date\');"')?>
            <script>
                $('#doc_date').datepicker({
                    dateFormat: 'yy-mm-dd'
                    });
            </script>
        </p>
        <p>
            <?=form_label('Subject','doc_subject')?>
            <?=form_input('doc_subject',$this->validation->doc_subject,'id="doc_subject" class="text"')?>
        </p>
        <p>
            <?=form_label('Originator','doc_originator')?>
            <?=form_input('doc_originator',$this->validation->doc_originator,'id="doc_originator" class="text"')?>
        </p>
        <p>
            <?=form_label('Addressee','doc_addressee')?>
            <?=form_input('doc_addressee',$this->validation->doc_addressee,'id="doc_addressee" class="text"')?>
        </p>
        <p>
            <?=form_label('Attention','doc_attention')?>
            <?=form_input('doc_attention',$this->validation->doc_attention,'id="doc_attention" class="text"')?>
        </p>
<!--        <p>
            <span id="chooseUser" onClick="javascript:openUserDialog('doc_route');" style="cursor:pointer">Choose User &raquo;</span>
            <ol id="user_doc_route" style="margin-top:-12px">
            </ol>
        </p>
-->
        <p>
            <?=form_label('Copy & Distribution','doc_route')?>
            <?=form_input('doc_route',$this->validation->doc_route,'id="doc_route" class="text"')?>
        </p>
        <p>
            <?=form_label('Doc. Group','doc_group')?>
        	<?=form_dropdown('doc_group', $this->config->item('documents_groups'),$this->validation->doc_group,'id="doc_group" class="text"')?>        	
        </p>
        <p>
            <?=form_label('Call Number','doc_call_main')?>
    	    <?=form_dropdown('doc_call_main',$callnumbers, $this->validation->doc_call_main,'id="doc_call_main" class="text"')?>        	
        </p>
    </td>
    <td style="width:50%">
        <p>	
            <?=form_label('Company','doc_call_company')?>
	        <?=form_dropdown('doc_call_company',$companies, $this->validation->doc_call_company,'id="doc_call_company" class="text"')?>        	
        </p>
        <p>
            <?=form_label('Call Sequence','doc_call_seq')?>
            <?=form_input('doc_call_date',$this->validation->doc_call_date,'id="doc_call_date" class="text" style="width:60px"')?>
            -
            <?=form_input('doc_call_seq',$this->validation->doc_call_seq,'id="doc_call_seq" class="text" style="width:45px"')?>
            <span id="generating" style="display:none">Generating...</span>
        </p>
        <p>
            <?=form_label('Keyword','doc_keyword')?>
            <?=form_input('doc_keyword',$this->validation->doc_keyword,'id="doc_keyword" class="text"')?>
        </p>
        <p>
            <?=form_label('Classification','doc_classification')?>
        	<?=form_dropdown('doc_classification',  $this->config->item('documents_classifications'),$this->validation->doc_classification);?>        	
        </p>
        <p>
            <?=form_label('Doc. Type','doc_type')?>
        	<?=form_dropdown('doc_type', $this->config->item('documents_types'),$this->validation->doc_type,'id="doc_type" class="text"');?>        	
        </p>
        <p>
            <?=form_label('Doc. Location','doc_type')?>
        	<?=form_dropdown('doc_loc_main', $locations,$this->validation->doc_loc_main,'id="doc_loc_main" class="text"');?>        	
        </p>
        <p>
            <?=form_label('Doc. Folder','doc_loc_folder')?>
            <?=form_input('doc_loc_folder',$this->validation->doc_loc_folder,'id="doc_loc_folder" class="text"')?>
        </p>
        <p>
            <?=form_label('Original Custody','doc_custody')?>
            <?=form_input('doc_custody',$this->validation->doc_custody,'id="doc_custody" class="text"')?>
            <!--
                <span id="chooseUser" onClick="javascript:openUserDialog('doc_custody');" style="cursor:pointer">Choose User &raquo;</span>
                <ol id="user_doc_custody" style="margin-top:-12px">
                </ol>
            -->
        </p>
        <p>
            <?=form_label('Retention Limit','doc_retention')?>
            <?=form_input('doc_retention',$this->validation->doc_retention,'id="doc_retention" class="text"')?>
            <script>
                $('#doc_retention').datepicker({
                    dateFormat: 'yy-mm-dd'
                    });
            </script>
        </p>
        <p><label for="userfile1">Digital Document Upload</label>
        	<input type="file" name="userfile1" size="20" />
        </p>
    </td>
    </tr>
    <tr>
        <td colspan="2">
        <div class="buttons">
            <button type="submit" class="positive" name="submit" value="submit">
            	<?= $this->page->icon('disk');?>
            	<?=$this->lang->line('general_save')?>
            </button>

            <a href="<?= site_url($controller)?>" class="negative">
            	<?= $this->page->icon('cross');?>
            	<?=$this->lang->line('general_cancel')?>
            </a>
        </div>
        </td>
    </tr>
</table>
<!--<?=form_fieldset_close()?>-->
</form>
