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

// Module dev notes:
// not storing the pre-install value for srvlookup anywhere, wonder if we should so can restore when module is uninstalled


?>Installing URI Handling Module.<br>
Creating urihand Table.<br>
<?php
global $db;
global $amp_conf;

// create the module config table id will always = 1 
$sql = "CREATE TABLE IF NOT EXISTS urihand (
	id tinyint(1) PRIMARY KEY,
	name1 VARCHAR(100),
	name2 VARCHAR(100),
	name3 VARCHAR(100) 
	);";
$check = $db->query($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not create `urihand` table: " . $check->getMessage() .  "\n");
}

//  if table is empty set default values
$sql = "SELECT * FROM urihand Where id = 1";
$results = sql($sql,"getAll",DB_FETCHMODE_ASSOC);
if	($results[0]['id'] != 1)  {
	Print "Installing default values.<br>";
	$results = sql("
		REPLACE INTO urihand (id,            name1,                name2,       name3)
		             VALUES ('1', 'yourdomain.com', 'pbx.yourdomain.com', 'pbx.local')
		");
	}

?>Verifying / Inserting custom_urihand.conf reference in extensions_custom.conf.<br>
<?php
// define dialplan include and path to asterisk conf file
$filename = $amp_conf['ASTETCDIR'].'/extensions_custom.conf';   
$includecontent = "#include custom_urihand.conf\n";

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
<?php

// determine status of srvlookup and set to yes if necessary
$sip_settings = sipsettings_get();
if ($sip_settings['srvlookup'] != 'yes')  {
	$sip_settings['srvlookup'] = 'yes';
	sipsettings_edit($sip_settings);
	}

?>
