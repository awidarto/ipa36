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
            <strong>Quick Hand Held Scanner</strong>
        </td>
    </tr>
    <tr>
        <td>
            <input type="text" id="qrinput" value="" width="200" />
        </td>
        <td style="width:500px;">
            <button value="Check In" name="Check In" onClick="javascript:onScanResult('in')" >
                Check In
            </button>
        </td>
    </tr>
    <tr>
        <td>
            <textarea id="qrlist" style="width:150px;height:300px;"></textarea><br />
            <button value="Check In" name="Check In" onClick="javascript:clearList()" >
                Clear
            </button>
        </td>
        <td id="scanResult" style="background-color:white;vertical-align:top;">
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
    
    $('#qrinput').keyup(function(event) {
      if (event.keyCode == '13') {
          onScanResult('in');
         //event.preventDefault();
       }
       $('#qrlist').val($('#qrlist').val() + event.keyCode);
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
    var txtin = $("#qrinput").val();
    var station = $("#station").val();
    
    $.post("<?php print site_url('register/qcheckin'); ?>", 
        { 'txtin':txtin,'station':station, 'dir':dir },
        function(data){
            $("#scanResult").html(data.html);
            
            $("#qrinput").val("");
            $("#qrinput").focus("");
            $('#qrlist').val("");
            
        },'json'
    );
  }
  
  function clearList(){
      $("#qrinput").val("");
      $("textarea#qrlist").val("");
      $("textarea#qrinput").focus("");
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
                $("#scanResult").html(data.html);
                //alert(data.status +' | '+ data.result['url'] +' | '+ data.result['purl']);
                //$("a#userbox").attr('href',data.result['url']);
                //$("a#userbox").click();
            }else{
                alert(data.status +' | '+ data.result);
            }
        },'json'
    );
  }
  
</script>

