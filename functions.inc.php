<?php

//  don't think this function is used at all
function urihand_get_config($engine) {
	$modulename = 'urihand';
	
	// This generates the dialplan
	global $ext;  
	global $asterisk_conf;
	switch($engine) {
		case "asterisk":
			if (is_array($featurelist = featurecodes_getModuleFeatures($modulename))) {
				foreach($featurelist as $item) {
					$featurename = $item['featurename'];
					$fname = $modulename.'_'.$featurename;
					if (function_exists($fname)) {
						$fcc = new featurecode($modulename, $featurename);
						$fc = $fcc->getCodeActive();
						unset($fcc);
						
						if ($fc != '')
							$fname($fc);
					} else {
						$ext->add('from-internal-additional', 'debug', '', new ext_noop($modulename.": No func $fname"));
					}	
				}
			}
		break;
	}
}


function urihand_saveconfig($foo) {


	}

function urihand_saveglobalvar($value, $variable)  {
	$sql ="REPLACE INTO globals (value,variable) VALUES ($value, $variable) ";
	$check = $db->query($sql);
	if (DB::IsError($check)) {
		die_freepbx( "Can not set global variable $variable" . $check->getMessage() .  "\n");
		}
	}

function urihand_getglobalvar($variable)  {
	$sql ="REPLACE INTO globals (value,variable) VALUES ($value, $variable) ";
	$check = $db->query($sql);
	if (DB::IsError($check)) {
		die_freepbx( "Can not set global variable $variable" . $check->getMessage() .  "\n");
		}
	}

	}

function urihand_getconfig() {
	$sql = "SELECT * FROM urihand LIMIT 1";
	$results= sql($sql, "getAll");
	return $results;
}
