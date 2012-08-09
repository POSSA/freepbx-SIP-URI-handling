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
// Add dialplan include to asterisk conf file
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

// First we need to look for existing occurances of the include line from past install and remove them
replace_file($filename, $includecontent, '');

// Now add back include line
if (is_writable($filename)) {
 
    if (!$handle = fopen($filename, 'a')) {
         echo "Cannot open file ($filename)";
         exit;
    }
    // Write $somecontent to our opened file.
    if (fwrite($handle, $includecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }
    echo "<br>Success, wrote ($includecontent)<br> to file ($filename)<br><br>";

    fclose($handle);

} else {
    echo "The file $filename is not writable";
}

?>Verifying / Setting srvlookup=yes in sip.conf.<br>
<?

// need to add a check here for srvlookup - not sure how to do this at present

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