<?php
include $_SERVER['DOCUMENT_ROOT'].'/PH_scripts/connect_db_extra.php';

if(!empty($_POST['extern_ticket']))
	{
		$result = mysqli_query($Connection, "SELECT * FROM cis_ext_ticket WHERE ticket_nr_cis ='$ticket_nr_cis' ");

		if( mysqli_num_rows($result) > 0) 
			{
				mysqli_query($Connection, "UPDATE cis_ext_ticket SET ticket_nr_ext = '$ticket_nr_ext' WHERE ticket_nr_cis = \"$ticket_nr_cis\" ");
			}
		else
			{
				mysqli_query($Connection, "INSERT INTO `cis_ext_ticket` SET `ticket_nr_cis` = \"$ticket_nr_cis\", `ticket_nr_ext` = \"$ticket_nr_ext\"");
			}
	}
else
	{
		$cis_ext_ticket = mysqli_query($Connection, "SELECT * FROM cis_ext_ticket WHERE ticket_nr_cis=\"$TicketID\"")
		while($zaznam = mysqli_fetch_array($cis_ext_ticket))
			{
			 $ticket_nr_ext = $zaznam["ticket_nr_ext"]; 
			}
	}
?>