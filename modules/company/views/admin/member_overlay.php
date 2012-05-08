<div style="width:800px;height:500px;margin:0px;overflow:hidden">
    
<?php

//print_r($user);

?>
<div id="videobox" style="width:450px;height:495px;border:1px solid #ddd;float:left;">
    <div id="player_box"
        style="display:block;height:250px;width:450px"
        class="shadow"
    >
        <embed
          flashvars="id=player&bufferlength=0.2&usefullscreen=false&controlbar=over&playlist=right&playlistsize=130&autostart=false&provider=video&image=<?php print base_url(); ?>public/player/preview.jpg&playlistfile=<?php print site_url('user/upl/'.$user['id'].'/rss');?>&skin=<?php print base_url(); ?>public/player/skins/stormtrooper.zip"

          allowfullscreen="false"
          allowscripaccess="always"
          id="player"
          name="player"
          src="<?php print base_url(); ?>public/player/player.swf"

          width="450"
          height="250"
        />
    </div>
    
	<script>

        var cuid = <?php print $user['id'];?>;
        var vlist;
        getList();

        var videoid = vlist[0];
        $('#curr_video').html(videoid.toString());
        
        //alert(videoid);
    
        var player;
        function playerReady(object) {
          //alert('the player is ready');
          player = document.getElementById(object.id);
          player.addControllerListener("play","playTracker");
          //player.addModelListener("loaded","loadTracker");
          player.addControllerListener("item","loadTracker");
          getList();
          var videoid = vlist[0];
          $('#curr_video').html(videoid.toString());
          loadComment();
        };
    
        function playTracker(obj) {
           //alert('playback detected '+ obj.toString());
           //addHit();
           //getHit();
        };

        function loadTracker(obj) {
            videoid = vlist[obj.index];
            //alert('video loading detected ' + videoid);
            $('#curr_video').html(videoid.toString());
            loadComment();
            //addHit();
            //getHit();
        };

    	function loadVideo(vname,vid){
    	    player.sendEvent('load','<?php print base_url(); ?>public/video/'+vname+'.flv');
    	    videoid = vid;
    	    loadLikes();
    	    getHit();
    	}

    	function getHit(){
            $.post("<?php print site_url('user/hit'); ?>", 
                { 'mid': videoid },
                function(data){
                    $('#hitcounts').html(data.hit);
                    if(data.rev == 1){
                        $('#revd').show();
                    }else{
                        $('#revd').hide();
                    }
                },'json'
            );
    	}

    	function addHit(){
            $.post("<?php print site_url('user/hit/add'); ?>", 
                { 'mid': videoid },
                function(data){
                    $('#hitcounts').html(data.hit);
                    if(data.rev == 1){
                        $('#revd').show();
                    }else{
                        $('#revd').hide();
                    }
                },'json'
            );
    	}



        function getList(){
            $.post("<?php print site_url('user/upl/'.$user['id'].'/json');?>", 
                { 'mid': videoid },
                function(data){
                    vlist = data;
                },'json'
            );
        }


        function like(){
		    $('#sendindicator').show();
            $('#sendcomment').hide();

            $.post("<?php print site_url('user/like/add'); ?>", 
                { 'mid': videoid, 'id':cuid },
                function(data){
                    loadLikes();
                /*
                    $('#likecount').html(data.num);
                    $('#likecounts').html(data.num); 
                */
                },'json'
            );

            $('#sendindicator').hide();
            $('#sendcomment').show();
		}

        function unlike(){
		    $('#sendindicator').show();
            $('#sendcomment').hide();

            $.post("<?php print site_url('user/like/unlike'); ?>", 
                { 'mid': videoid },
                function(data){
                    loadLikes();
                /*
                    $('#likecount').html(data.num);
                    $('#likecounts').html(data.num); 
                */
                },'json'
            );

            $('#sendindicator').hide();
            $('#sendcomment').show();
		}


		function loadLikes(){
            $.post("<?php print site_url('user/like'); ?>", 
                { 'mid': videoid, 'id': cuid  },
                function(data){
                    
                    $('#likecount').html(data.num);
                    $('#likecounts').html(data.num);
                    if(data.islike){
                        $('#like_container').hide();
                        $('#islike_container').show();
                    }else{
                        $('#like_container').show();
                        $('#islike_container').hide();
                    }
                },'json'
            );
        }


        function loadComment(){
            $.post("<?php print site_url('user/comment/get'); ?>", 
                { 'mid': videoid },
                function(data){
                    $('#prevcomment').html(data);
                    
                }
            );
        }

        function sendComment(){
            $('#sendcomment').show();
            
            $.post("<?php print site_url('user/comment/add'); ?>", 
                { 'mid': videoid ,'commentmessage' : $('#comment_text').val() },
                function(data){
                    loadComment();
                    $('#sendcomment').hide();
                    $('#comment_text').val('');
                }
            );
        }

    </script>
        <br />
        <table style="width:100%;border:0px 1px solid #ccc">
            <tr>
                <td class="title label">Member Status</td>
                <td><?php print ($user['active'])?'Active':'Inactive'?></td>
            </tr>
            <tr>
                <td class="title label">Member Level</td>
                <td><?php 
                $m = $this->config->item('contestlevels');
                print $m[$user['levelincontest']];
                ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Comment <span id="sendcomment" style="display:none">Sending...</span></strong><br />
                    <blockquote id="prevcomment"></blockquote><br />
                    <textarea id="comment_text" style="width:85%;height:60px"></textarea>
                </td>
            </tr>
            <tr>
                <td class="title label">Current Video : <span id="curr_video" style="font-weight:bold;" ></span></td>
                <td>
                    <span id="sendComment" style="text-decoration:underline;cursor:pointer;" onClick="javascript:sendComment();">Save Comment</span>
                </td>
            </tr>
        </table>
        
</div>
<div id="info_box" style="width:340px;height:495px;border:1px solid #ccc;float:right;">
    <?php
    /*
    [id] => 60 [username] => jokokendil2 
    [password] => 2c8997a41de8836d95d1d78fff07111e3eba5821 
    [email] => andy@neseapl.com 
    [active] => 1 
    [group] => 1 
    [activation_key] => CPAvuO7AgSovrgs8StZoB1HjuEuYRZN0 
    [last_visit] => 2010-08-12 12:41:15 
    [created] => 2010-08-09 16:15:08 
    [modified] => 2010-08-12 12:41:02 
    [fullname] => joni bago 
    [sex] => M 
    [pob] => Jakarta 
    [dob] => 1977-00-00 [idnum] => 0897097974987489 [parentidnum] => [parentname] => 
    [street] => Bogor 1/2 
    [city] => Bogor 
    [zip] => 798687678 
    [hearfrom] => twitter 
    [hearfromtext] => dari Koran 
    [mobile] => 086756453453 
    [phone] => 0217897896 [favactor] => Muni Cader [joinreason] => Mau kaya doongg 
    [picture] => 
    [levelincontest] => 0 
    [reviewed] => 0 
    [flagged] => 0 ) 
    */
    
    $this->load->helper('date');
    
    ?>
    <table class="data_grid">
        <tr>
            <td class="title label">ID</td>
            <td><?php print $user['id']?></td>
        </tr>
        <tr>
            <td class="center"><img src="<?php print base_url().'public/avatar/'.get_avatar($user['id'],null);?>" alt="<?php print $user['username']?>" /></td>
            <td style="font-weight:bold">
                <span style="font-size:125%">
                <?php print $user['fullname']?>
                </span>
                <?php print ($user['flagged'])?$this->bep_assets->icon('exclamation','Flagged').'<span style="color:red">Flagged</span>':'';?>
                <br />
                <span id="levelincontest"><?php 
                $m = $this->config->item('contestlevels');
                print $m[$user['levelincontest']];
                ?></span>
                <br />
                <span id="useractive" style="font-size:135%;color:<?=($user['active'])?'blue':'red';?>"><?php print ($user['active'] == 1)?'Active':'Inactive'?></span>
                <script>
                    $('#useractive').eip('<?=site_url('user/savemod/'.$user['id'])?>',
                        {
                            form_type:'select',
                            select_options:{
                                2:'Inactive',
                                1:'Active'
                            }
                        }
                    );
                    $('#levelincontest').eip('<?=site_url('user/savelev/'.$user['id'])?>',
                        {
                            form_type:'select',
                            select_options:{
                                0:'Penonton',
                                1:'Kontestan',
                                2:'Finalis'
                            }
                        }
                    );
                </script>
            </td>
        </tr>
        <tr>
            <td class="title label">Username</td>
            <td ><?php print $user['username']?></td>
        </tr>
        <tr>
            <td class="title label">Email</td>
            <td><?php print $user['email']?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center">
                <?php print ($user['reviewed'])?$this->bep_assets->icon('tick','Reviewed'):$this->bep_assets->icon('cross','Reviewed');?> Reviewed &nbsp;
            </td>
        </tr>
        <tr>
            <td class="title label">Sex</td>
            <td><?php print $user['sex']?></td>
        </tr>
        <tr>
            <td class="title label">Place & Date of Birth</td>
            <td><?php print $user['pob'].' / '.date('d M Y',mysql_to_unix($user['dob']));?></td>
        </tr>
        <tr>
            <td class="title label">Address</td>
            <td><?php print $user['street']?></td>
        </tr>
        <tr>
            <td class="title label">Mobile</td>
            <td><?php print $user['mobile']?></td>
        </tr>
        <tr>
            <td class="title label">Phone</td>
            <td><?php print $user['phone']?></td>
        </tr>
        <tr>
            <td class="title label">Registered</td>
            <td><?php print $user['created']?></td>
        </tr>
        <tr>
            <td class="title label">Registered From</td>
            <td><?php print ($user['mobreg'])?'SMS':'Web / Mobile Web';?></td>
        </tr>
        <tr>
            <td class="title label">Last Update</td>
            <td><?php print $user['modified']?></td>
        </tr>
    </table>
</div>
</div>