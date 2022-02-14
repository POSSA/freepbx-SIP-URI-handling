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
// module uninstalls with global variables still set - maybe a bit sloppy but should not cause any issues 
// module sets srvlookup to yes on install and remains set to yes on uninstall


?>URI Handling Module is being uninstalled.<br>
Removing custom_urihand.conf reference from extensions_custom.conf.<br>
<?php

// remove dialplan include from asterisk conf file
$filename = $amp_conf['ASTETCDIR'].'/extensions_custom.conf';
$includecontent = "#include custom_urihand.conf";

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
<?php
// drop the tables
$sql = "DROP TABLE IF EXISTS urihand";
$check = $db->query($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not delete `urihand` table: " . $check->getMessage() .  "\n");
}

?>
