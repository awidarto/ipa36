<script language="JavaScript" type="text/javascript">
<!--
// -----------------------------------------------------------------------------
// Globals
// Major version of Flash required
var requiredMajorVersion = 10;
// Minor version of Flash required
var requiredMinorVersion = 0;
// Minor version of Flash required
var requiredRevision = 0;
// -----------------------------------------------------------------------------
// -->
</script>
<script type="text/javascript" src="<?=base_url();?>assets/flash/scanner/AC_OETags.js"></script>


<script language="JavaScript" type="text/javascript">
<!--
// Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
var hasProductInstall = DetectFlashVer(6, 0, 65);

// Version check based upon the values defined in globals
var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);

if ( hasProductInstall && !hasRequestedVersion ) {
	// DO NOT MODIFY THE FOLLOWING FOUR LINES
	// Location visited after installation is complete if installation is required
	var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
	var MMredirectURL = window.location;
    document.title = document.title.slice(0, 47) + " - Flash Player Installation";
    var MMdoctitle = document.title;

	AC_FL_RunContent(
		"src", "playerProductInstall",
		"FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
		"width", "700",
		"height", "450",
		"align", "middle",
		"id", "scanner",
		"quality", "high",
		"bgcolor", "white",
		"name", "QReadr.swf",
		"allowScriptAccess","sameDomain",
		"type", "application/x-shockwave-flash",
		"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
} else if (hasRequestedVersion) {
	// if we've detected an acceptable version
	// embed the Flash Content SWF when all tests are passed
	AC_FL_RunContent(
			"src", "<?=base_url();?>assets/flash/scanner/QReadr.swf",
			"width", "700",
			"height", "450",
			"align", "middle",
			"id", "scanner",
			"quality", "high",
			"bgcolor", "white",
			"name", "QReadr.swf",
			"allowScriptAccess","sameDomain",
			"type", "application/x-shockwave-flash",
			"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
  } else {  // flash is too old or we can't detect the plugin
    var alternateContent = 'Alternate HTML content should be placed here. '
  	+ 'This content requires the Adobe Flash Player. '
   	+ '<a href=http://www.adobe.com/go/getflash/>Get Flash</a>';
    document.write(alternateContent);  // insert non-flash content
  }
// -->
</script>
<noscript>
  	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="scanner" width="700" height="450"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="<?=base_url();?>assets/flash/scanner/QReadr.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="white" />
			<param name="allowScriptAccess" value="sameDomain" />
			<embed src="<?=base_url();?>assets/flash/scanner/QReadr.swf" quality="high" bgcolor="white"
				width="700" height="450" name="scanner" align="middle"
				play="true"
				loop="false"
				quality="high"
				allowScriptAccess="sameDomain"
				type="application/x-shockwave-flash"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
	</object>
</noscript>
<style>
    table#checkin td{
        padding:5px 10px;
        border:none;
    }
    
    table#checkin{
        margin-top:20px;
    }
</style>

    <table id="checkin">
        <tr>
            <td>
                <strong>Check Point #</strong>
            </td>
            <td colspan="4">
                <select id="station">
                    <?php for($i = 1;$i < 30;$i++):?>
                        <option value="<?=$i?>"><?=$i?></option>
                    <?php endfor;?>
                </select>
            </td>
        </tr>
    </table>

<table id="checkin">
    <tr>
        <td colspan="2">
            <strong>Hand Held Scanner</strong>
        </td>
    </tr>
    <tr>
        <td>
            <textarea id="qrinput"></textarea>
        </td>
        <td>
            <button value="Check In" name="Check In" onClick="javascript:onScanResult('in')" >
                Check In
            </button>
        </td>
        <td>
            <button value="Check Out" name="Check Out" onClick="javascript:onScanResult('out')" >
                Check Out
            </button>
        </td>
    </tr>
</table>

<table id="checkin">
    <tr>
        <td colspan="5">
            <strong>Manual Check In</strong>
        </td>
    </tr>
    <tr>
        <td>    
            <select id="regtype">
                <option value="Visitor">Visitor</option>
                <option value="Attendee">Convention Attendee</option>
                <option value="Official">Official</option>
            </select>
        </td>
        <td>
            <input type="text" id="regnumber" value="" />
        </td>
        <td>
            <button value="Check In" name="Check In" onClick="javascript:manualCheckIn('in')" >
                Check In
            </button>
        </td>
        <td>
            <button value="Check Out" name="Check Out" onClick="javascript:manualCheckIn('out')">
                Check Out
            </button>
        </td>
        <td>
            <span id="loader" style="display:none;">Checking In...</span>
        </td>
    </tr>
</table>
<a href="#" id="userbox" style="display:none;">_</a>
<script>
    $("a#userbox").fancybox({ 
        'hideOnContentClick': false,
        'showCloseButton': true,
        'frameWidth' : 800,
        'frameHeight' : 500,
    });
    
  function checkScanResult(txtin){
    var station = $("#station").val();
    $.post("<?php print site_url('register/checkin'); ?>", 
        { 'txtin':txtin,'station':station },
        function(data){
            if(data.status == 'OK'){
                //alert(data.status +' | '+ data.result['url'] +' | '+ data.result['purl']);
                $("a#userbox").attr('href',data.result['url']);
                $("a#userbox").click();
            }else{
                alert(data.status +' | '+ data.result);
            }
        },'json'
    );
  }

  function onScanResult(dir){
    var txtin = $("textarea#qrinput").val();
    var station = $("#station").val();
    
    $.post("<?php print site_url('register/hcheckin'); ?>", 
        { 'txtin':txtin,'station':station, 'dir':dir },
        function(data){
            if(data.status == 'OK'){
                //alert(data.status +' | '+ data.result['url'] +' | '+ data.result['purl']);
                $("a#userbox").attr('href',data.result['url']);
                $("a#userbox").click();
            }else{
                alert(data.status +' | '+ data.result);
            }
            
            $("textarea#qrinput").val("");
            $("textarea#qrinput").focus("");
        },'json'
    );
  }

  function manualCheckIn(dir){
      var regtype = $("#regtype").val();
      var regnumber = $("#regnumber").val();
      var station = $("#station").val();
      //alert(regtype + ' ' + regnumber + ' ' + station + ' ' +isprint);
      $("#loader").show();
      
    $.post("<?php print site_url('register/manualcheckin'); ?>", 
        { 'regtype':regtype,'regnumber':regnumber,'station':station, 'dir':dir },
        function(data){
            $("#loader").hide();
            if(data.status == 'OK'){
                //alert(data.status +' | '+ data.result['url'] +' | '+ data.result['purl']);
                $("a#userbox").attr('href',data.result['url']);
                $("a#userbox").click();
            }else{
                alert(data.status +' | '+ data.result);
            }
        },'json'
    );
  }
  
</script>

