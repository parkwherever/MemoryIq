
<?


	$string = "INSERT INTO `psych`.`detailTestLog` (`uid`, `testNumber`, `pairId`, `userAnswer`, `correctAnswer`, `timeUntilAnswer`) VALUES ('1', '2', '34', 'old', 'new', '2.31');";
	$string = mysql_real_escape_string($string);	
	$dbh = new PDO('mysql:host=localhost;dbname=mappme', 'root', 'root'); 
	$dbh->exec($string);


?>