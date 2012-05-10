<script>
    function confirmCommit(){
        /*
        var ans = "";
        if(ans){
            alert(ans);
            return true;
        }else{
            alert(ans);
            return false;
        }
        */
        return confirm("You are about to register new members into database, are you sure everything is correct ?");
    }
</script>
    <?php print form_open_multipart('auth/admin/import/save/'.$file,array('class'=>'horizontal','onSubmit'=>'return confirm(\'You are about to register new members into database, are you sure everything is correct ?\');'))?>
        <fieldset>
            <ol>
                <li>
                    <label for="picemail">Person in Charge email :</label>
                    <?=($pic === '')?'Not specified':$pic;?>
                    <input type="hidden" value="<?=$pic;?>" name="picemail">
                </li>
                <li>
                    <label for="picname">Person in Charge name :</label>
                    <?=($picname === '')?'Not specified':$picname;?>
                    <input type="hidden" value="<?=$picname;?>" name="picname">
                </li>
                <li>
                    <label for="mobilephone">Mobile Phone :</label>
                    <?=($mobilephone === '')?'Not specified':$mobilephone;?>
                    <input type="hidden" value="<?=$mobilephone;?>" name="mobilephone">
                </li>
                <li>
                    <label for="company">Company :</label>
                    <?=($company === '')?'Not specified':$company;?>
                    <input type="hidden" value="<?=$company;?>" name="company">
                </li>
                <li>
                    <label for="companyaddress">Company Address :</label>
                    <?=($companyaddress === '')?'Not specified':$companyaddress;?>
                    <input type="hidden" value="<?=$companyaddress;?>" name="address">
                </li>
                <li>
                    <label for="companyphone">Company Phone :</label>
                    <?=($companyphone === '')?'Not specified':$companyphone;?>
                    <input type="hidden" value="<?=$companyphone;?>" name="phone">
                </li>
                <li>
                    <label for="companynpwp">NPWP :</label>
                    <?=($companynpwp === '')?'Not specified':$companynpwp;?>
                    <input type="hidden" value="<?=$companynpwp;?>" name="npwp">
                </li>
                <li>
                    <label for="tax">Apply VAT :</label>
                    <input type="radio" value="yes" name="tax" id="tax" checked="checked"/>Yes
                    <input type="radio" value="no" name="tax" id="tax" />No
                </li>                

                <li>
                    <label for="importasgroup">Import as :</label>
                    <input type="radio" value="yes" name="importasgroup" id="importasgroup" checked="checked"/>Group
                    <input type="radio" value="no" name="importasgroup" id="tax" />Individual
                </li>                

                <li>
                    <label for="dupaction">Duplicate data :</label>
                    <input type="radio" name="dupaction" value="ignore" id="dupeaction" />Discard
                    <input type="radio" name="dupaction" value="update" id="dupeaction" checked="checked" />Update<br />
                </li>
                <li>
                    <label for="sendmember">Send Notifications to Member :</label>
                    <input type="radio" value="yes" name="sendmember" id="sendmember" />Yes
                    <input type="radio" value="no" name="sendmember" id="sendmember" checked="checked"/>No
                </li>
                <li>
                    <label for="sendpass">Send Notification to PIC :</label>
                    <input type="radio" value="yes" name="sendpic" id="sendpic" checked="checked" />Yes
                    <input type="radio" value="no" name="sendpic" id="sendpic" />No
                </li>                
                <li>
                    <label for="sendpass">Send User Information Detail to PIC :</label>
                    <input type="radio" value="yes" name="sendpass" id="sendpass" checked="checked" />Yes
                    <input type="radio" value="no" name="sendpass" id="sendpass" />No
                </li>                
                <li>
                    <label for="forceupdate">Force Update Username and Password :</label>
                    <input type="radio" value="yes" name="forceupdate" id="forceupdate" checked="checked"/>Yes
                    <input type="radio" value="no" name="forceupdate" id="forceupdate" />No
                </li>                                
                <?php
                /*
                <li>
                    <label for="affect">Data update affecting :</label>
                    <input type="radio" name="affect" value="all" id="affectall" checked="checked" />All data
                    <input type="radio" name="affect" value="conv" id="affectsc" />Convention related data only
                    <input type="radio" name="affect" value="sc" id="affectsc" />Short Course related data only
                    <input type="radio" name="affect" value="ex" id="affectsc" />Exhibitor related data only
                </li>
                */
                ?>
                <li>
                    <div class="buttons">
                		<a href="<?php print base_url() ?>auth/admin/import" class="negative" >
                			<?php print $this->bep_assets->icon('cross') ?>
                			<?php print $this->lang->line('general_cancel')?>
                		</a>
                		<button type="submit" class="positive" name="submit" value="submit" <?=($email_col == 0 || $pic === '')?'disabled="disabled"':'';?>>
                			<?php print $this->bep_assets->icon('user') ?>
                		    Save Imported Data to Database
                		</button>
                	</div>
                	<div class="clear"></div>
                </li>
            </ol>
        </fieldset>
    <?php print form_close()?>            
<br />

<style>

.legend{
    padding:5px;
    margin: 0 3px;
}

table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:12px;
	margin-top:10px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align:bottom;
}
table.excel tbody th {
	text-align:center;
	width:20px;
}
table.excel tbody td {
	vertical-align:bottom;
}
table.excel tbody td {
    padding: 0 3px;
	border: 1px solid #EEEEEE;
}
table.excel tbody td.email{
    font-weight:bold;
    color:maroon;
    background-color:orange;
    padding: 3px;
	border: 1px solid #EEEEEE;
}

table.excel tbody td.duplicate_email{
    font-weight:bold;
    color:maroon;
    background-color:yellow;
    padding: 3px;
	border: 1px solid #EEEEEE;
}

table.excel tbody td.duplicate_username{
    font-weight:bold;
    color:maroon;
    background-color:yellow;
    padding: 3px;
	border: 1px solid #EEEEEE;
}

table.excel tbody td.valid{
    font-weight:bold;
    color:white;
    background-color:blue;
    padding: 3px;
	border: 1px solid #EEEEEE;
}

table.excel tbody td.invalid{
    font-weight:bold;
    color:white;
    background-color:red;
    padding: 3px;
	border: 1px solid #EEEEEE;
}

table.excel tbody td.sc{
    font-weight:bold;
    color:white;
    background-color:green;
    padding: 3px;
	border: 1px solid #EEEEEE;
}

table.excel tbody td.conv{
    font-weight:bold;
    color:white;
    background-color:grey;
    padding: 3px;
	border: 1px solid #EEEEEE;
}

table.excel tbody td.ex{
    font-weight:bold;
    color:white;
    background-color:black;
    padding: 3px;
	border: 1px solid #EEEEEE;
}



</style>
<div class="clear"></div>
<div>
<p>
<strong>Validation Result :</strong><br />
<?php
    if(count($invalids > 0) || $email_col == 0 || $dup_email > 0){
        foreach($invalids as $i){
            printf('column %s contains "%s" which does not conform to any valid headers & will be ignored<br />',$i['col'],$i['val']);
        }
        if($email_col == 0){
            print 'required email column does not exist<br />';
        }
        if($dup_email > 0){
            print $dup_email.' email(s) already registered<br />';
        }
        if($dup_user > 0){
            print $dup_user.' username(s) already exist<br />';
        }
    }else{
        print 'No error found';
    }
?>
</p>
</div>

<table class="excel" cellspacing=3>
    <tr>
        <td class="valid legend">valid header</td>
        <td class="invalid legend">invalid header</td>
        <td class="email legend">email header</td>
        <td class="duplicate_email legend">duplicate email</td>
        <td class="duplicate_username legend">duplicate username</td>
        <td class="sc legend">short course related column</td>
        <td class="conv legend">connvention related column</td>
        <td class="ex legend">exhibitor related column</td>
    </tr>
</table>

<table class="excel" cellspacing=0>
    <thead>
    	<tr>
    		<th>&nbsp</th>
    		<?php
        		for ($j = 1; $j <= $xlsdata['numCols']; $j++) {
            		print "<th>".$j."</th>\r\n";
        		}
    		?>
    	</tr>
    </thead>
    <?php
        $validator = array_merge($this->config->item('import_valid_column'),$this->config->item('sc_valid'),$this->config->item('conv_valid'),$this->config->item('ex_valid'));

        for ($i = 1; $i <= $xlsdata['numRows']; $i++) {
            print "<tr style=\"height:21.3333333333px;\">\r\n";
            print "	<th>".$i."</th>";
            		for ($j = 1; $j <= $xlsdata['numCols']; $j++) {
        		        $class = 'normal';
            		    if($i == 1){
                		    if(!in_array($xlsdata['cells'][$i][$j],$validator)){
                		        $class = 'invalid';
                		    }else{
                		        $class = 'valid';
                		    }
                	        if($xlsdata['cells'][$i][$j] == 'email'){
                	            $class = 'email';
                	        }
                	        if($xlsdata['cells'][$i][$j] == 'username'){
                	            $user_col = $j;
                	        }

                	        if(in_array($xlsdata['cells'][$i][$j],$this->config->item('sc_valid'))){
                		        $class = 'sc';
                	        }

                	        if(in_array($xlsdata['cells'][$i][$j],$this->config->item('conv_valid'))){
                		        $class = 'conv';
                	        }

                	        if(in_array($xlsdata['cells'][$i][$j],$this->config->item('ex_valid'))){
                		        $class = 'ex';
                	        }
                	        
            		    }else if($j == $email_col && $i > 1){
                		    if($this->validation->spare_email($xlsdata['cells'][$i][$j])){
                		        $class = 'normal';
                		    }else{
                    	        $class = 'duplicate_email';
                		    }
            		    }else if($j == $user_col && $i > 1){
                		    if($this->validation->spare_username($xlsdata['cells'][$i][$j])){
                		        $class = 'normal';
                		    }else{
                    	        $class = 'duplicate_username';
                		    }
            		    }
            		    
                		print "<td class=\"".$class."\"><nobr>".$xlsdata['cells'][$i][$j]."</nobr></td>\r\n";
            		}
            print "</tr>";
        }

	?>
</table>
	


