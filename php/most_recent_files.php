<?php
define('SKRIPTE_VZ', 'P:/www/php');

function get_most_recent_files($path, $number) {
	$realpath = realpath($path);

	$files = array();
	$filemtime = array();
	
	if (is_dir($realpath)) {
		if( ($handle = opendir($realpath)) !== FALSE) {
			while( ($file = readdir($handle)) !== FALSE ) {
				if (filetype($file) == 'file' && ( 
				    (substr($file, -4) == '.php') || //Dateitypen spezifizieren
						(substr($file, -4) == '.txt') ) ) {
					$files[] = realpath($file);
					$filemtime[] = filemtime($file); 
				}
			}
			closedir($handle);
		
		} else {
			//echo "<h2><u>Fehler: Konnte das Verzeichnis $path nicht öffnen!</u></h2>";
			die("<h2>Fehler: Konnte das Verzeichnis $path nicht öffnen!</h2>");
			return -1;
		}
	} else {
		//echo "<h2><u>Fehler: Verzeichnis $path existiert nicht!</u></h2>";
		die("<h2>Fehler: Verzeichnis $path existiert nicht!</h2>");
		return -1;	
	}
	
	array_multisort($filemtime, SORT_DESC, $files);
	
	//die $number zuletzt geänderten Dateien filtern:
	$i = 0;
	$l = count($files);
	$return = array();
	while($i < (float)$number && $i < $l) {
		$return[] = $files[$i];
		$i++;
	}
	
	return $return;
}
	
$files = get_most_recent_files(SKRIPTE_VZ, 15);
print '<pre>';
print_r($files);


	
?>
