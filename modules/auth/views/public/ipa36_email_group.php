<html>
<head>
	<title>Notification Letter for Group</title>
	<style type="text/css">
		.liner{
			border-top:thin double black;
		}

		.right{
			text-align: right;
			padding-right:10px;
		}

		table{
			width:450px;
			border:0px;
			font: 100% "Lucida Grande", "Trebuchet MS", Verdana, sans-serif;
		}
		strong{
			text-decoration: underline;
			font-weight:bold;
		}
		body{
			font: 75% "Lucida Grande", "Trebuchet MS", Verdana, sans-serif;
		}

		.pagebreak{
			page-break-after: always;
		}
		
	</style>
</head>
<body>
	<p>
		Jakarta, {reg_date}<br />
		Subject	: Notification Letter for <?php print ($importasgroup)?'Group':'Grouped Individuals'?>
	</p>
	<p>
		For the attention of:<br />
		{picname}<br />
		{picemail}<br />
		{company}<br />
		NPWP : {companynpwp}<br />
		{companyaddress}<br />
		{companyphone}<br />
		{picmobile}<br />
	</p>
	<p>
		Dear Sir / Madam
		Please find below summary of your registration:
	</p>
	<p>
		<table border="0">
			<tbody>
				<tr>
					<td>1</td><td>Professional Domestic</td><td>{total_pd}</td>
				</tr>
				<tr>
					<td>2</td><td>Professional Overseas</td><td>{total_po}</td>
				</tr>
				<tr>
					<td>3</td><td>Student Domestic</td><td>{total_sd}</td>
				</tr>
				<tr>
					<td>4</td><td>Student Overseas</td><td>{total_so}</td>
				</tr>
				<tr>
					<td>5</td><td>Golf</td><td>{total_golf}</td>
				</tr>
				<tr>
					<td>6</td><td>Gala Dinner</td><td>{total_galadinner}</td>
				</tr>
				<tr>
					<td>7</td><td>Judge</td><td>{total_judge_count}</td>
				</tr>
				<tr>
					<td>8</td><td>Booth Assistant</td><td>{total_ba}</td>
				</tr>
				<tr>
					<td colspan="3" class="liner"></td>
				</tr>
				<tr>
					<td  colspan="2" class="right"><strong>TOTAL AMOUNT</strong></td><td></td>
				</tr>
				<tr>
					<td  colspan="2" class="right">IDR </td><td class="right">{total_idr}</td>
				</tr>
				<tr>
					<td  colspan="2" class="right">VAT 10%</td><td class="right">{vat_idr}</td>
				</tr>
				<tr>
					<td  colspan="2" class="right">USD </td><td class="right">{total_usd}</td>
				</tr>
				<tr>
					<td  colspan="2" class="right">VAT 10%</td><td class="right">{vat_usd}</td>
				</tr>
				<tr>
					<td  colspan="2" class="right"><strong>GRAND TOTAL</strong></td><td></td>
				</tr>
				<tr>
					<td  colspan="2" class="right">IDR </td><td class="right">{grand_idr}</td>
				</tr>
				<tr>
					<td  colspan="2" class="right">USD </td><td class="right">{grand_usd}</td>
				</tr>
			</tbody>
		</table>
	</p>
	<p>
		<hr></hr>
		<strong>CANCELLATION POLICIES</strong><br />
		<ul>
			<li>Full refunds will be granted to requests for cancellation received in writing by <strong>8 May 2012 at the latest</strong>.</li>
			<li><strong>No refunds</strong> will be granted <strong>after 15 May 2012</strong>.</li>
			<li>Telephone cancellation is not accepted.</li>
			<li>If a delegate is unable to attend, substitution will be accepted.</li>
			<li>Substitution should be informed in writing.</li>
			<li>Non attendance (No Show) of registered participants will still be charged the full amount due.</li>
		</ul>
		<hr></hr>
		<ul>
			<li>By returning the Commitment Letter attached, you have agreed to the terms and conditions and shall ensure settlement of payment of the amount due above.</li>
			<li>Please return the attached Commitment Letter within 7 (seven) days after receipt of this Notification Letter.</li>
		</ul>
		<hr></hr>
	</p>
	<p>
		Thank you for your participation.<br /><br />
		<strong>Quad MICE Management</strong><br />
		Co-Organizer of the 36th IPA Convention & Exhibition
	</p>

<?php if($importasgroup):?>

	<p class="pagebreak"></p>
	<style type="text/css">
		.liner{
			border-top:thin double black;
		}

		.right{
			text-align: right;
			padding-right:10px;
		}

		table{
			border-top:thin solid black;
			border-right:thin solid black;
			font: 100% "Lucida Grande", "Trebuchet MS", Verdana, sans-serif;
			vertical-align: top;
			width: 100%;

		}

		#summary th,#summary td{
			vertical-align: top;
			padding:2px 4px;
			border-left:thin solid black;
			border-bottom:thin solid black;
			margin: 0px;
		}

		strong{
			text-decoration: underline;
			font-weight:bold;
		}
		body{
			font: 75% "Lucida Grande", "Trebuchet MS", Verdana, sans-serif;
		}
	</style>
	<p>
		Jakarta, {reg_date}<br />
		Subject	: Commitment Letter
	</p>
	<p>
		<strong>SUMMARY OF PARTICIPANTS</strong><br />
		PIC NAME : {picname}<br />
		COMPANY NAME : {company}<br />
		PHONE NUMBER : {companyphone}<br />
		COMPANY ADDRESS	: {companyaddress}<br />
	</p>
	<p>
		<table border="0" cellspacing="0" id="summary">
			<thead>
				<tr>
					<th rowspan="2">Name</th>
					<th rowspan="2">Reg. No</th>
					<th rowspan="2">Company Name</th>
					<th rowspan="2">Judge</th>
					<th>Convention</th>
					<th colspan="2">Exhibition</th>
					<th colspan="2">Special Event</th>
				</tr>
				<tr>
					<th>PD/PO/SD/SO</th>
					<th>Exhibitor</th>
					<th>BA</th>
					<th>Golf</th>
					<th>Gala Dinner</th>
				</tr>
			</thead>
			{summary_detail}
		</table>
	</p>
	<p>
		Please return this Commitment Letter by email to:<br />
		<strong>convention.group@ipaconvex.com</strong><br />
		or<br />facsimile to <strong>+6221-7191422</strong>
	</p>
	<p>
		<hr></hr>
		On behalf of the company, I agree with the summary of registration and shall ensure settlement of payment of the amount due above.<br />
		<br />
		Date		: <br />
		PIC Signature	:
	</p>
<?php endif;?>

</body>
</html>