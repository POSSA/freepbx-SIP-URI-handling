<?php

// not sure this function is necessary, it is not referenced in the module, does it run automatically?
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


function urihand_editconfig($foo) {
	global $db;
	$id = 1;    // always will be 1 to ensure only a single record in the table
	$name1 = $db->escapeSimple($foo['name1']);
	$name2 = $db->escapeSimple($foo['name2']);
	$name3 = $db->escapeSimple($foo['name3']);

	$results = sql("
		UPDATE urihand 
		SET 
			name1 = '$name1', 
			name2 = '$name2', 
			name3 = '$name3'			
		WHERE id = '1'");

	// now define global variables with the name vars and force reload
	urihand_saveglobalvar($name1, 'URI_NAME1');
	urihand_saveglobalvar($name2, 'URI_NAME2');
	urihand_saveglobalvar($name3, 'URI_NAME3');
	needreload ();  
		
	}

function urihand_saveglobalvar($value, $variable)  {
	$check = sql("REPLACE INTO globals (value,variable) VALUES ('$value', '$variable')");
	}

function urihand_getconfig() {
	$sql = "SELECT * FROM urihand Where id = 1";
	$results = sql($sql,"getAll",DB_FETCHMODE_ASSOC);
	return is_array($results)?$results:array();
	}

function uri_getextensions() {
	$list = core_devices_list(); //returns 2d array of system devices 
	
	}
// compare version numbers of local module.xml and remote module.xml 
// returns true if a new version is available
function urihand_vercheck() {
	$newver = false;
	if ( function_exists(xml2array)){
		$module_local = xml2array("modules/urihand/module.xml");
		$module_remote = xml2array("https://raw.github.com/POSSA/freepbx-SIP-URI-handling/master/module.xml");
		if ( $module_remote[module][version] > $module_local[module][version])
			{
			$newver = true;
			}
		return ($newver);
		}
	}
