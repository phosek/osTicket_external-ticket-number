<?php
$spojeni = mysqli_connect(DBHOST,DBUSER,DBPASS, "cis_extra"); // Převzato ze souboru \include\ost-config.php

$StaffID = $thisstaff->getId();
$TicketID = $ticket->getId();
$ext_ticket = 0;

$result = mysqli_query($spojeni, "SELECT * FROM cis_staff_settings WHERE id=\"$StaffID\"");
while($cis_staff_settings = mysqli_fetch_array($result)) { $ext_ticket = $cis_staff_settings["ext_ticket"]; }
//mysqli_close($spojeni);

if($ext_ticket == "1")
{ 
	$cis_ext_ticket = mysqli_query($spojeni, "SELECT * FROM cis_ext_ticket WHERE ticket_nr_cis=\"$TicketID\"");
	while($zaznam = mysqli_fetch_array($cis_ext_ticket)) { $ticket_nr_ext = $zaznam["ticket_nr_ext"];  } ?>
		
	<tr>
		<td>
			<label><?php echo __('External ticket number');?>:</label>
		</td>
		<td>
				<input type="text" name="extern_ticket" 
				value="<?php echo $ticket_nr_ext;?>" />
		</td>
	</tr> <?php 
	
	if(!empty($_POST['extern_ticket']))
	{
		$result = mysqli_query($spojeni, "SELECT * FROM cis_ext_ticket WHERE ticket_nr_cis ='$ticket_nr_cis'");
		if( mysqli_num_rows($result) > 0) {mysqli_query($spojeni, "UPDATE cis_ext_ticket SET ticket_nr_ext = '$ticket_nr_ext' WHERE ticket_nr_cis = \"$ticket_nr_cis\" ");}
		else 							  {mysqli_query($spojeni, "INSERT INTO `cis_ext_ticket` SET `ticket_nr_cis` = \"$ticket_nr_cis\", `ticket_nr_ext` = \"$ticket_nr_ext\"");}
		//echo "ticket_nr_cis: ".$ticket_nr_cis;
		//echo "ticket_nr_ext: ".$ticket_nr_ext;
	}
} ?>