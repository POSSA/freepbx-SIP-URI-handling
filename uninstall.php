SIP URI Handling is being uninstalled.<br>
<?php
?>Removing custom_sipuri.conf reference from extensions_custom.conf.<br>
<?

// dialplan include to asterisk conf file
$filename = '/etc/asterisk/extensions_custom.conf';
$includecontent = "#include custom_sipuri.conf\n";

// Stock function for file edits
function replace_file($path, $string, $replace)
{
    set_time_limit(0);
    if (is_file($path) === true)
    {
        $file = fopen($path, 'r');
        $temp = tempnam('./', 'tmp');
        if (is_resource($file) === true)
        {
            while (feof($file) === false)
            {
                file_put_contents($temp, str_replace($string, $replace, fgets($file)), FILE_APPEND);
            }
            fclose($file);
        }
        unlink($path);
    }
    return rename($temp, $path);
}

// look for existing occurances of the include line and remove them
replace_file($filename, $includecontent, '');

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