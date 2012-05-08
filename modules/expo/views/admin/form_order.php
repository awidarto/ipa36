<script>


function getMedia(){
    var id = $('#username').val();
    $.post('<?=base_url();?>media/admin/order/getmedia/'+id, null,
      function(data){
            $('#mediaid').html(data);
      });
}

function hideMedia(){
    $('#mediacontainer').hide();
}

function showMedia(){
    $('#mediacontainer').show();
}

$().ready(function() {
    getMedia();
});

</script>
<h2><?=$header?></h2>
<?=form_open('auth/admin/members/form/'.$this->validation->id,array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <?=form_label('Client','clientid')?>
                <?=form_dropdown('clientid',$clients,$this->validation->clientid,'id="username" class="text" onChange="getMedia();"')?>
            </li>
            <li>
                <?=form_label('Order Name','ordername')?>
                <?=form_input('ordername',$this->validation->ordername,'id="ordername" class="text"')?>
            </li>
            <li>
                <?=form_label('Media Type','mediatype')?>
                <?=form_radio('mediatype','video',$this->validation->set_radio('mediatype','1'),'id="mediatype" onClick="showMedia();"')?>Video 
                <?=form_radio('mediatype','banner',$this->validation->set_radio('mediatype','0'),'onClick="showMedia();"')?>Banner 
                <?=form_radio('mediatype','text',$this->validation->set_radio('mediatype','0'),'onClick="hideMedia();"')?>Text 
            </li>
            <li>
                <?=form_label('Message / Descriptions','descriptions')?>
                <?=form_textarea('descriptions',$this->validation->descriptions,'id="descriptions" class="text" style="width:15em;height:10em"')?>
            </li>
            <li id="mediacontainer" >
                <?=form_label('File','mediaid')?>
                <?=form_dropdown('mediaid',$mediafiles,$this->validation->mediaid,'id="mediaid" style="width:35em;"')?>
            </li>
            <li class="submit">
                <?=form_hidden('id',$this->validation->id)?>
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?= $this->page->icon('disk');?>
	                	<?=$this->lang->line('general_save')?>
	                </button>
	                <a href="<?= site_url('auth/admin/members')?>" class="negative">
	                	<?= $this->page->icon('cross');?>
	                	<?=$this->lang->line('general_cancel')?>
	                </a>
	            </div>
            </li>
        </ol>
    </fieldset>
<?=form_close()?>