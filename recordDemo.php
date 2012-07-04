
<?php

//This file records demographic information from user test, and returns the newly created user id to be used in the rest of the study
// Data = test detail results
	$data = $_GET['data'];
	if (is_null($data) || empty($data))
	{
		echo "Error Calculating IQ";
	}
	else
	{
		// Parse to create object
		$data = stripslashes($data);
	    $data = substr($data,1,-1);
	    $data = json_decode($data);
	    // var_dump($data);
	    $resident = $data->resident;
        $age = $data->age;
        $sex = $data->sex;
        $hand = $data->hand;
        $lang = $data->lang;
        $edu = $data->edu;
        $alert = $data->alert;
        $race = $data->race;
        $latino = $data->latino;


		$string = "INSERT INTO `psych`.`demo` (`uid`, `country`, `age`, `gender`, `hand`, `natLanguage`, `edu`, `alert`, `race`, `isLatino`) VALUES (NULL, '".$resident."', '".$age."', '".$sex."', '".$hand."', '".$lang."', '".$edu."', '".$alert."', '".$race."','".$latino."');";
		// $string = mysql_real_escape_string($string);	
		// Problem because escape string escapes single quotes rendering sql invalid
		$dbh = new PDO('mysql:host=localhost;dbname=psych', 'root', 'root'); 
		// echo $string;
		$dbh->exec($string);

		//Get newly created user id
		$uid = $dbh->lastInsertId('uid');
		$result = '{"userid":'.$uid.'}';
		echo $result;
    }
?>