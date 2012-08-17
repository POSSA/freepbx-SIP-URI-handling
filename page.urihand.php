<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
//This file is part of FreePBX.
//
//    This is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 2 of the License, or
//    (at your option) any later version.
//
//    This module is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    see <http://www.gnu.org/licenses/>.
//

if(count($_POST)){

	$foo = array(
		name1 => $_POST['name1'],
		name2 => $_POST['name2'],
		name3 => $_POST['name3']
		);

	urihand_editconfig($foo);
	}

// get module config 
$date = urihand_getconfig();

// test for presence of custom contexts module
if ($active_modules[customcontexts] ){
	$ccmodule = '<b>WARNING:</b> The Custom Contexts Module is enabled on this system, and may be incompatible with this module.<br><br>';
	}

?>
<h1><font face="Arial">URI Handling Module</font></h1>
		<hr>

This module adds the ability to dial SIP URI's from this PBX.<br><br>
<?php  print $ccmodule; ?>
<form name= "config" method="POST" action=""><a href="javascript: return false;" class="info">

Establish the configurtion items below to enable SIP URI Dialing on this platform.<br><br>
<br><hr>
The following three fields are used to set LAN/WAN IP addresses or FQDN names for LAN/WAN of the PBX.  Any dialed URIs with these domains will be routed locally.
	<table border="0" width="32%" id="table1">
		<tr>
			<td width="115">MYDOMAIN</td>
			<td><input type="text" name="name1" size="27" value="<?php print $date[0]['name1']; ?>"><a href="javascript: return false;" class="info"></td>
		</tr>
		<tr>
			<td width="115">MYFQDN1</td>
			<td>
			<input type="text" name="name2" size="27" value="<?php print $date[0]['name2']; ?>"><a href="javascript: return false;" class="info"></td>			
		</tr>
		<tr>
			<td width="115">MYFQDN2</td>
			<td><input type="text" name="name3" size="27" value="<?php print $date[0]['name3']; ?>"><a href="javascript: return false;" class="info"></td>
		</tr>
	</table>
<br>
<input type="submit" value="update" name="update">
<br><hr>
<?php
echo "<br><h2><b>Configured Extensions:</b></h2>\n";
echo "For extensions to dial a SIP URI, they must be manually set to a context of 'enable-sipuri-dialing' (without quotes).  The following table lists the system extensions that are using that context.<br>";
echo "<TABLE cellSpacing=1 cellPadding=1 width=900 border=1 >\n" ;
echo "<TD>Ext#</TD><TD>Description</TD><TD>Context</TD></TR>\n" ;


$list = core_devices_list(); //returns 2d array of system devices
$listcount = count($list);
$count = 0;
while ($count < $listcount) {

	$device = core_devices_get($list[$count]['id']);
//	print $device['id']."--".$count."---".$device['context']."---<br>";
	If ($device['context'] == "enable-sipuri-dialing")
	{
		echo "<TR><TD><FONT face=verdana,sans-serif>" . $device['id'] . "</TD><TD>".$device['description']."</TD><TD>" .$device['context'] ."</TD>\n";

	}
	$count++;
	}
		
echo "</TABLE></FORM>\n";
?>
<br><hr><br><center>This module was started by the community at colsolgrp based on scripts originally created by Luke Hamburg.<br>
This module is now maintained by the PBX Open Source Software Alliance (POSSA)<br><br></center>