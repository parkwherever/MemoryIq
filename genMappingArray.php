<?php

// REads mapping file and creates a mapping array from user abbreviations to master ids

// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
$mapping =  array();

$file_handle = fopen("scripts/personIds.csv", "r");
if(is_null($file_handle))
{
	throw new Exception("mapping file from person abbr to id doesn't exist");
}
while (!feof($file_handle)) {	
   	$line = fgets($file_handle);
   	$entry = explode(",", $line);	
	$id = $entry[0];
	$abbr = $entry[1];
	$name = $entry[2];

	if (!is_null($abbr) && !is_null($name))
	{
    	$mapping[$abbr] = $id;
    }
}
fclose($file_handle);


// echo $mapping["AB"];


?>