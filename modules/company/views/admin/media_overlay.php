<div style="width:800px;height:500px;padding:0px;margin:0px;">
    <div style="width:390px;float:left;padding:5px;margin:0px">
        <object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="388" height="245">
        	<param name="movie" value="<?= base_url(); ?>public/mediaplayer/player.swf" />
        	<param name="allowfullscreen" value="true" />
        	<param name="allowscriptaccess" value="always" />
        	<param name="flashvars" value="file=<?php print $url?>&image=preview.jpg&width=388&height=245" />
        	<object type="application/x-shockwave-flash" data="<?= base_url(); ?>public/mediaplayer/player.swf" width="388" height="245">
        		<param name="movie" value="player.swf" />
        		<param name="allowfullscreen" value="true" />
        		<param name="allowscriptaccess" value="always" />
        		<param name="flashvars" value="file=<?php print $url?>&image=preview.jpg&width=388&height=245" />
        		<p><a href="http://get.adobe.com/flashplayer">Get Flash</a> to see this player.</p>
        	</object>
        </object>
        <div id="commentbox" class="grid_6" >
            <input type="hidden" name="mid" id="mid" value="<?php print $uid ?>" />
            <textarea id="commentmessage" name="commentmessage" style="height:100px;width:400px;cursor:pointer;"></textarea><br />
            <span onClick="javascript:sendComment()" style="cursor:pointer;" >Send Comment</span>
            <span id="sendcomment" style="display:none;">sending...</span>
            <span onClick="javascript:lockUser()" style="cursor:pointer;" >Lock This User</span>
            
        </div>
    </div>
    <div id="komentarlist" style="width:300px">
    </div>
</div>

<script>
    function sendComment(){
        $('#sendcomment').show();
        
        $.post("<?php print site_url('user/comment/add'); ?>", 
            { 'uid':'<?php print $uid ?>','commentmessage' : $('#commentmessage').val() },
            function(data){
                loadComment();
            }
        );
        
        $('#sendcomment').hide();
    }
    
    function loadComment(){
        $.post("<?php print site_url('user/comment/get'); ?>", 
            { 'uid':'<?php print $uid ?>'},
            function(data){
                $('#komentarlist').html(data);
            }
        );
    }
    
    function lockUser(){
        $.post("<?php print site_url('user/lock'); ?>", 
            { 'uid':'<?php print $uid ?>'},
            function(data){
                alert(data.result);
            },'json'
        );
    }
</script>

