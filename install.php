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

// misc function replace text in a file
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

// determine status of srvlookup and set to yes if necessary
$sip_settings = sipsettings_get();
if ($sip_settings['srvlookup'] != 'yes')  {
	$sip_settings['srvlookup'] = 'yes';
	sipsettings_edit($sip_settings);
	}

?>Installing Default Values<br>
<?

$sql ="INSERT INTO urihand (parm1, parm2) ";
$sql .= "VALUES ('3','60')";

$check = $db->query($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not create default values in `urihand` table: " . $check->getMessage() .  "\n");
}

?>Set Defaults for Global Variables<br>
<?

urihand_saveglobalvar('yourdomain.com', 'URI_DOMAIN');
urihand_saveglobalvar('pbx.yourdomain.com', 'URI_FQDN1');
urihand_saveglobalvar('pbx.local', 'URI_FQDN2');

?>