			<tbody>
<?php
	$total_galadinner = 0;
	$total_con_idr = 0;
	$total_con_usd = 0;
	$total_con_ba = 0;
	$total_golf = 0;
?>
<?php foreach($recapdata as $p):?>
	<?php
		//print_r($p);

		$total_golf += $p['golf'];
		$galadinner = $p['galadinner'] + $p['galadinneraux'] + $p['galadinneraux2'];
		$total_galadinner += $galadinner; 

		if($p['registrationtype'] == 'Professional Domestic' || $p['registrationtype'] == 'Student Domestic'){
			$conv_fee = 'IDR '.number_format($p['registertype'],2,',','.');
			$total_con_idr +=($p['foc'] == 0)?$p['registertype']:0;
		}else if($p['registrationtype'] == 'Professional Overseas' || $p['registrationtype'] == 'Student Overseas'){
			$conv_fee = 'USD '.number_format($p['registertype'],2,',','.');
			$total_con_usd +=($p['foc'] == 0)?$p['registertype']:0;
		}else if($p['registrationtype'] == 'Booth Assistant'){
			$conv_fee = '-';
			$total_con_ba +=$p['registertype'];
		}

	?>	
				<tr>
					<td><?php print $p['fullname'];?></td>
					<td><?php print $p['conv_id'];?></td>
					<td><?php print $p['company'];?></td>
					<td><?php print $p['judge'];?></td>
					<td><?php print $conv_fee;?></td>
					<td><?php print ($p['exhibitor'] == 0)?'no':'yes';?></td>
					<td><?php 
						if($p['ba30'] > 0 || $p['ba150'] > 0){
							print 'IDR '.number_format($p['registertype'],2,',','.');
						}else{
							print '-';
						}
					?></td>
					<td><?php print number_format($p['golf'],2,',','.');?></td>
					<td><?php print number_format($galadinner,2,',','.');?></td>
				</tr>
<?php endforeach;?>
				<tr>
					<td rowspan="2" colspan="4">GRAND TOTAL</td>
					<td><?php print ($total_con_idr > 0)?'IDR '.number_format($total_con_idr,2,',','.'):'-';?></td>
					<td>-</td>
					<td><?php print 'IDR '.number_format($total_con_ba,2,',','.');?></td>
					<td><?php print number_format($total_golf,2,',','.');?></td>
					<td><?php print number_format($total_galadinner,2,',','.');?></td>
				</tr>
				<tr>
					<td><?php print ($total_con_usd > 0)?'USD '.number_format($total_con_usd,2,',','.'):'-';?></td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>
			</tbody>
