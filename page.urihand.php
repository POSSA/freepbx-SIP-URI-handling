<?php
// SIP URI Handling for FreePBX by 
// FreePBX Module work by T. SHiffer 12/24/2010
//
if(count($_POST)){
	urihand_saveconfig();
}
$date = urihand_getconfig();

$module_info = xml2array("modules/urihand/module.xml");
?>
<large><b>SIP URI Handling </large></b>
<hr>
This module adds the ability to dial SIP URI's from this PBX.<br>
To enable a user to make SIP URI based outgoing calls from their extention, select it from the list.<br><br>

<form method="POST" action="">
<large><bold><u>Administrator Functions</u></large></bold><br>
<small>Establish the configurtion items below to enable SIP URI Dialing on this platform.</small><br><br>
<medium><bold>Identity</medium></bold><br><small><hr></small>
<small>Replace the examples with your real information. Use whatever you're using for externhost= or your real domain, etc.</small>
	<table border="0" width="32%" id="table1">
		<tr>
			<td width="115">MYDOMAIN</td>
			<td><input type="text" name="domain" size="27" value="yourdomain.com"></td>
		</tr>
		<tr>
			<td width="115">MYFQDN1</td>
			<td>
			<input type="text" name="fqdn1" size="27" value="pbx.yourdomain.com"></td>
		</tr>
		<tr>
			<td width="115">MYFQDN2</td>
			<td><input type="text" name="fqdn2" size="27" value="pbx.local"></td>
		</tr>
	</table>
<br><br>
<center><input type="button" value="Update" name="update"></center>
<?php
print '<p align="center" style="font-size:11px;">This module was created by Luke Hamburg.<br>
The module is maintained by the developer community at <a target="_blank" href="http://projects.colsolgrp.net/projects/show/urihand"> CSG Software Project Management</a><br><strong>Module version '.$module_info['module']['version'].'</strong></p>';
?>