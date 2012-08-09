Installing SIP URI Handling.<br>
<?php
global $db;
global $amp_conf;

// create the tables
$sql = "CREATE TABLE IF NOT EXISTS urihand (
	parm1 VARCHAR(5),
	parm2 VARCHAR(5)
);";

$check = $db->query($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not create `urihand` table: " . $check->getMessage() .  "\n");
}
?>Verifying / Inserting custom_sipuri.conf reference in extensions_custom.conf.<br>
<?
?>Verifying / Setting srvlookup=yes in sip.conf.<br>
<?
?>Installing Default Values<br>
<?
# the easy why to debug your SQL Q its missing a value or something do let me do this :P
# is  that telling yo how yur puting it upp you dont need to have them in a serten order as long as the value ar in teh same place
$sql ="INSERT INTO urihand (parm1, parm2) ";
$sql .= "VALUES ('3','60')";

$check = $db->query($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not create default values in `urihand` table: " . $check->getMessage() .  "\n");
}


// Register FeatureCode - SIP URI Handling;
//$fcc = new featurecode('urihand', 'urihand');
//$fcc->setDescription('SIP URI Handling');
//$fcc->setDefault('*874');
//$fcc->update();
//unset($fcc);
//needreload();
?>