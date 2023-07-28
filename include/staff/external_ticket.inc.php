<?php
if(!defined('OSTADMININC') || !$thisstaff || !$thisstaff->isAdmin()) die('Access Denied');


if(isset($_POST['submit']))
{
	$cis_external = mysqli_query($spojeni, "UPDATE `cis_staff_settings` SET `ext_ticket` = REPLACE(`ext_ticket`, '1', '0')");
	foreach($_POST as $key => $value)
	{
		//$key=Filterdata($key); $value=Filterdata($value);
		if (str_contains($key, 'checkbox'))
		{
			$eID=str_replace('checkbox', '', $key);
			
			$cis_external = mysqli_query									($spojeni, "SELECT * FROM `cis_staff_settings` WHERE `staff_id` = $eID");
			if($cis_external->num_rows == 0) { $cis_external = mysqli_query ($spojeni, "INSERT INTO `cis_staff_settings`(`staff_id`, `ext_ticket`) VALUES($eID, '1')"); }
			else 							 { $cis_external = mysqli_query ($spojeni, "UPDATE `cis_staff_settings` SET `ext_ticket` = '1' WHERE `cis_staff_settings`.`staff_id` = $eID;"); }
		}
	}
	unset($eID);
} ?>

<form action="external_ticket_settings.php" method="POST">
	<?php csrf_token(); ?>
	<input type="hidden" name="t" value="system" >
	<table class="form_table settings_table" width="940" border="0" cellspacing="0" cellpadding="2">
		<div style="padding-left:2px;">
			<tbody>
				<tr>
					<th colspan="2">
						<em><b><?php echo __('Enable or disable field display'); ?></b></em>
					</th>
				</tr> <?php
							
				$cis_name = mysqli_query($spojeni_ost, "SELECT * FROM `ost_staff`");
				while ($zaznam_name = mysqli_fetch_array ($cis_name))
				{
					$eName	= $zaznam_name["username"];
					$eID	= $zaznam_name["staff_id"];
					
					$cis_external = mysqli_query($spojeni, "SELECT * FROM `cis_staff_settings` WHERE `staff_id` = $eID");
					while ($zaznam_external = mysqli_fetch_array ($cis_external)) 
					{
						$eSett = $zaznam_external["ext_ticket"];
					} ?>
					
					<tr>
						<td width="300"><?php echo $eName;?></td>
						<td>
							<input type="checkbox" name="<?php echo 'checkbox'.$eID;?>" value="1" <?php if($eSett=="1"){echo 'checked="checked"';} ?>>
						</td>
					</tr> <?php
					unset($eName, $eID, $eSett);
				} ?>
			</tbody>
		</div>
	</table>
	<p style="text-align:center;">
		<input class="button" type="submit" name="submit" value="<?php echo __('Save Changes');?>">
		<input class="button" type="reset" name="reset" value="<?php echo __('Reset Changes');?>">
	</p>
</form>