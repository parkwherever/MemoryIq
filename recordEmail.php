<?php

//This file records demographic information from user test, and returns the newly created user id to be used in the rest of the study
// Data = test detail results
$data = $_GET['data'];
if (is_null($data) || empty($data))
{
	echo "Error Recording Email";
}
else
{
	// Parse to create object
	$data = stripslashes($data);
    $data = substr($data,1,-1);
    $data = json_decode($data);
    // var_dump($data);
    $email = $data->email;
    $userid = $data->userid;
    $testNumber = $data->testNumber;
    $time = time();

    // $string = mysql_real_escape_string($string);	
	$string = "INSERT INTO `psych`.`email` (`userid`, `email`, `time`, `testNumber`) VALUES (".$userid.", '".$email."', '".$time."', '".$testNumber."');";
	// Problem because escape string escapes single quotes rendering sql invalid
	$dbh = new PDO('mysql:host=localhost;dbname=psych', 'root', 'root'); 
	// echo $string;
	$dbh->exec($string);
}
?>