<div style="width:700px;height:300px;">
    <table>
        <tr>
            <td style="width:50%">
            <!-- First, include the JPEGCam JavaScript Library -->
        	<script type="text/javascript" src="<?=base_url()?>assets/flash/webcam.js"></script>

        	<!-- Configure a few settings -->
        	<script language="JavaScript">
        		webcam.set_api_url( '<?php print site_url('media/receivephotovis/'.$id); ?>' );
        		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
        		webcam.set_shutter_sound( true ); // play shutter click sound
        	</script>

        	<!-- Next, write the movie to the page at 320x240 -->
        	<script language="JavaScript">
        		//document.write( webcam.get_html(320, 240) );
        	</script>

        	<embed id="webcam_movie" src="<?=base_url()?>assets/flash/webcam.swf" 
        	    loop="false" menu="false" quality="best" bgcolor="#ffffff" 
        	    name="webcam_movie" allowscriptaccess="always" allowfullscreen="false" 
        	    type="application/x-shockwave-flash" 
        	    pluginspage="http://www.macromedia.com/go/getflashplayer" 
        	    flashvars="shutter_enabled=1&amp;shutter_url=<?=base_url()?>assets/flash/shutter.mp3&amp;width=320&amp;height=240&amp;server_width=320&amp;server_height=240" 
            	    align="middle" height="240" width="320" />

        	<!-- Some buttons for controlling things -->
        	<br/>
        	<form>
            	<div class="buttons">
            		<button type="button" class="positive" name="config" value="submit" onClick="javascript:webcam.configure();">
            			<?php print $this->bep_assets->icon('cog') ?>
        			    Configure
            		</button>
            		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            		<button type="button" class="positive" name="snap" value="submit" onClick="javascript:take_snapshot();" style="float:right;">
            			<?php print $this->bep_assets->icon('camera') ?>
        			    Take Picture
            		</button>
            	</div>
            	<div class="clear">&nbsp;</div>
        	</form>

        	<!-- Code to handle the server response (see test.php) -->
        	<script language="JavaScript">
        		webcam.set_hook( 'onComplete', 'my_completion_handler' );

        		function take_snapshot() {
        			// take snapshot and upload to server
        			document.getElementById('upload_results').innerHTML = 'Uploading...';
        			webcam.snap();
        		}

        		function my_completion_handler(msg) {
        			// extract URL out of PHP output
        			if (msg.match(/(http\:\/\/\S+)/)) {
        				var image_url = RegExp.$1;
        				// show JPEG image in page
        				document.getElementById('upload_results').innerHTML = '<img src="' + image_url + '">';

        				// reset camera for another shot
        				webcam.reset();
        			}
        			else alert("PHP Error: " + msg);
        		}
        	</script>
            </td>
            <td style="width:50%;text-align:center;vertical-align:middle;" id="upload_results">
            </td>
        </tr>
    </table>


</div>
