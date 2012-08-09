SIP URI Handling is being uninstalled.<br>
<?php
?>Removing custom_sipuri.conf reference from extensions_custom.conf.<br>
<?
?>Removing Table urihand.<br>
<?
// drop the tables
$sql = "DROP TABLE IF EXISTS urihand";
$check = $db->query($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not delete `urihand` table: " . $check->getMessage() .  "\n");
}
//needreload();
?>