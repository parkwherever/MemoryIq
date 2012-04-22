<?
/*
,"Picture Name","NAME","Item type for test"
"Day 1: STUDY PHASE",
,"DU","Erin Craig",
"Day 1: Test Phase",
,"DU","Erin Craig","old"
,"AI","Jackie Wagner","new"
"Day 2: TEST PHASE",,,
,"DU","Erin Craig","old"
,"AI","Jackie Wagner","new"
,"EJ","Elyse Dawson","old - retest"

*/
class TestPhase
{
    const study = 0;
    const testDay1 = 1;
    const testDay2 = 2;
}

$testPhase = TestPhase::study;
// $testPhase = 0;

function setTestPhase($tl, $oldTestPhase){
	if ($tl == "Day 1: STUDY PHASE"){
		print("Changed to study phase \n");
		return TestPhase::study;
	}
	if ($tl == "Day 1: TEST PHASE"){
		print("Changed to test1 phase \n");
		return TestPhase::testDay1;
	}
	if ($tl == "Day 2: TEST PHASE"){
		print("Changed to test 2 phase \n");
		return TestPhase::testDay2;
	}
	// print("returing old testphase\n");
	return $oldTestPhase;
	
}
$file_handle = fopen("FaceNameMappingCond1.txt", "r");
while (!feof($file_handle)) {
   	$line = fgets($file_handle);
   	$entry = explode(",", $line);	
	$title = $entry[0];
	$abbr = $entry[1];
	$name = $entry[2];
	$testType = $entry[3];
 	// print_r($entry[0]);

	if (strlen($title)>0){
		print $title;
		//chop, or substring
		$compareStr = "Day 2: TEST PHASE";
		if ($title == $compareStr){
			print("Equals");
		}
		if(strcasecmp($title, $compareStr) ==0){
			print("Equals2");
		}
		print("</br>");
	}
	$abbr = $entry[1];	
	$name = $entry[2];
	$testPhase = setTestPhase($title, $testPhase);
	// printFormat($dict[$abbr]);
	
}
fclose($file_handle);

// // WRITE SQL Statements 
// $file_handle = fopen("worldcitiespop", "r");
// // $file_handle = fopen("testcities.txt", "r");//Read from list
// $output = "cities_sql.sql";
// $fh = fopen($output, 'w') or die("can't open file");//Write to list for sqlite
// $count = 0;//total number of entries
// if(!$fh){
// 	echo"No file for output</br>";
// }
// 
// $state = "AL";
// while (!feof($file_handle)) {
//    $line = fgets($file_handle);
//    $entry = explode(",", $line);
// 	if (checkLine($entry)){			
// 		/*** FOR City, State ****/
// 		// $state = $dict[$entry[3]];
// 		// 	$location = $entry[2].", ".$state;
// 		// 	// printFormat($location);
// 		// 	addEntry($location, $entry[5],$entry[6]);	
// 					//Latitude          Longitude	
// 		/*** FOR City, State Abbreviation ****/
// 			$location = $entry[2].", ".$entry[3];
// 		// 	// printFormat($location);
// 			addEntry($location, $entry[5],$entry[6]);	
// 					//Latitude          Longitude			
// 	}
// }
// fclose($file_handle);
// fclose($fh);
// echo "Count : ".$count."</br>";
// echo "<a href=\"cities_sql.sql\"> See File Here <a>";
// 	
// 	
// function addEntry($cityname, $lat,$long){
// 	$GLOBALS['count']= $GLOBALS['count']+1;
// 	$cityname = str_replace("'", "''", $cityname);
// 	// $cityname = mysql_real_escape_string($cityname);
// 	$string = "INSERT INTO  cities (name ,lat ,long)VALUES ( '$cityname',  $lat,  $long);\n";
// 	// $string = mysql_real_escape_string($string);
// 	global $fh;
// 	fwrite($fh, $string);
// 	// $dbh = new PDO('mysql:host=localhost;dbname=mappme', 'root', 'root'); 
// 	// $dbh->exec($string);
// }
// 
// 	function checkLine($line){
// 		return ($line[0] == "us");
// 	}
// 	function printFormat($info){
// 		$string = "<pre>".$info."</pre>";
// 		print_r($string);
// 	}
// // //DB::exec("");
// ?>