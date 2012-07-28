<?php
// to be ran every five hours
// Sends emails 
$hourSpan = 5;

// Test values between now and hourSpan ago
$timeAgoMin = time();
$timAgoMax = $hourSpan * 60 * 60;
// end test values

// $timeAgoMin = time() - (24 * 60 * 60);
// $timAgoMax = time() - (($hourSpan + 24) * 60 * 60);

echo $earliestTime;

$select = "SELECT * FROM email WHERE time > ".$timAgoMax." AND time < ".$timeAgoMin;

$dbh = new PDO('mysql:host=localhost;dbname=psych', 'root', 'root'); 

foreach ($dbh->query($select) as $entry) 
{
	echo $entry['email'];
	
	$to      = $entry['email'];
	$message = "Thank you for your interest in participating in the second part of the study you completed yesterday.  Today, you will have the opportunity to obtain an estimate of a type of long-term face-name memory IQ.  This study is being conducted by cognitive scientists at Washington University in St Louis.  Your participation is completely voluntary and you are free to discontinue at any time.  Please click on the link below if you wish to participate.\n\n ";
	$message = $message."http://experiments.wustl.edu/day2.html?ln=".$entry['testNumber']."&ud=".$entry['userid'];
	$subject = 'Partcipate in Part 2 of your Face-Name Memory IQ Test';
	$headers = 'From: memdart@wustl.edu' . "\r\n" .
	    'Reply-To: webmaster@example.com' . "\r\n";

	print_r($message);
	mail($to, $subject, $message, $headers);
}


// Missing from and password
//http://php.net/manual/en/function.mail.php
// When sending mail, the mail must contain a From header. This can be set with the additional_headers parameter, or a default can be set in php.ini.

// Failing to do this will result in an error message similar to Warning: mail(): "sendmail_from" not set in php.ini or custom "From:" header missing. The From header sets also Return-Path under Windows.

?>