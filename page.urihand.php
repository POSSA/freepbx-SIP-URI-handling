<?php

if(count($_POST)){
	urihand_saveconfig();
}
$date = urihand_getconfig();


// check to see if id is already defined and if not insert default values not setting global vars with these default values.
if ($date['id'] != 1)  {
	$sql ="INSERT INTO urihand ( id,            name1,                name2,      name3   ) ";
	$sql .= "VALUES            ('1', 'yourdomain.com', 'pbx.yourdomain.com', 'pbx.local'  )";
	$check = $db->query($sql);
	if (DB::IsError($check)) {
        die_freepbx( "Can not create default values in `urihand` table: " . $check->getMessage() .  "\n");
		}
	}

// test for presence of custom contexts module
if ($active_modules[customcontexts] ){
	$ccmodule = '<b>WARNING:</b> The Custom Contexts Module is enabled on this system, and may be incompatible with this module.<br><br>';
	}

?>
<large><b>SIP URI Handling </large></b>
<hr>
This module adds the ability to dial SIP URI's from this PBX.<br>
To enable a user to make SIP URI based outgoing calls from their extention, select it from the list.<br><br>
<?php  print $ccmodule; ?>
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
This module was created by Luke Hamburg.<br>