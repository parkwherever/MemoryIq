<?php
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

	    // $data = '{"listNumber":1,"numWrong":2,"numRight":2,"questions":[{"personName":"Olivia Wells","personId":1234,"userAnswer":"old","correctAnswer":"old","timeTilAnswer":null,"didTimeout":"false"},{"personName":"Emma Tucker","personId":1234,"userAnswer":"new","correctAnswer":"old","timeTilAnswer":79,"didTimeout":"false"},{"personName":"Elyse Dawson","personId":1234,"userAnswer":"old","correctAnswer":"old","timeTilAnswer":792,"didTimeout":"false"},{"personName":"Erin Craig","personId":1234,"userAnswer":"new","correctAnswer":"old","timeTilAnswer":59,"didTimeout":"false"}],"time":1338777648307}';
	    $data = json_decode($data);
	    $listNumber = $data->listNumber;
	    // Num Wrong and Right sent
	    $totalNumWrong = $data->numWrong;
	    $totalNumRight = $data->numRight;

	    $testDay = $_GET['testDay'];
	    $testDay = substr(stripslashes($testDay), 1, -1);

	    // Total correct identifications of old names
	    $rightId = $_GET['rightId'];
	   	$rightId = substr(stripslashes($rightId), 1, -1);

	   	// Total old questions
	    $oldTotal = $_GET['oldTotal'];
	    $oldTotal = substr(stripslashes($oldTotal), 1, -1);
	    $oldHitRate = $rightId / $oldTotal;

	    // Total correct rejections of new names
	    $wrongRej = $_GET['wrongRej'];
	    $wrongRej = substr(stripslashes($wrongRej), 1, -1);

	    // Total new questions asked
		$newTotal = $_GET['newTotal'];
	    $newTotal = substr(stripslashes($newTotal), 1, -1);
	    $newHitRate = $wrongRej / $newTotal;

	    $performance = $totalNumRight-$totalNumWrong;
	    $time = time();
	    $userId = "123";
	    // echo $data[0]
	    $dbh = new PDO('mysql:host=localhost;dbname=psych', 'root', 'root'); 

	    // Record overall performance for test
	    $testSummary = ""; 
	    if ((int)$testDay == 1)
	    {
	    	// Record short term test
	    	$testSummary = "INSERT INTO `psych`.`testOverviewShortTerm` (`uid`, `hits`, `falseAlarms`, `performance`, `oldHitRate`, `newHitRate`, `date`, `testNumber`) VALUES (".$userId.", ".$totalNumRight." , ".$totalNumWrong.", ".$performance." ,".$oldHitRate.", ".$newHitRate.", ".$time.", ".$listNumber.");";
	    }
	    else
	    {
	    	// Record long term test result
	    	$testSummary = "INSERT INTO `psych`.`testOverviewLongTerm` (`uid`, `hits`, `falseAlarms`, `performance`, `oldHitRate`, `newHitRate`, `timeSinceFirstTest`, `testNumber`) VALUES (".$userId.", ".$totalNumRight." , ".$totalNumWrong.", ".$performance." , ".$oldHitRate.", ".$newHitRate.", ".$timeSinceFirstTest.", ".$listNumber.");";
	    }
	    // print_r( $testSummary);
	    $dbh->exec($testSummary);

	    // Record test result details per question
	    foreach ($data->questions as $questionSet)
	    {
		    $userAnswer = $questionSet->userAnswer;
		    $correctAnswer = $questionSet->correctAnswer;
		    $pairId = $questionSet->personId;
		    $timeUntilAnswer = $questionSet->timeTilAnswer;
		    if (is_null($timeUntilAnswer))
		    {
		    	$timeUntilAnswer = 'NULL';
		    }
		   
		    $string = "INSERT INTO `psych`.`detailTestLog` (`id`, `uid`, `testNumber`, `pairId`, `userAnswer`, `correctAnswer`, `timeUntilAnswer`,`testDay`) VALUES ('NULL', ".$userId.", ".$listNumber.", ".$pairId.",'".$userAnswer."' , '".$correctAnswer."', ".$timeUntilAnswer." , ".$testDay.");";	
		    // $string = "INSERT INTO `psych`.`detailTestLog` (`uid`, `testNumber`, `pairId`, `userAnswer`, `correctAnswer`, `timeUntilAnswer`) VALUES (".$userId.", ".$listNumber.", ".$pairId.",'".$userAnswer."' , '".$correctAnswer."', ".$timeUntilAnswer.");";	
			// echo $string;
			// echo"</br>";
			$dbh->exec($string);
	    }

	    // Calculate and return memory iq
	    $count = 0;
	    $sum = 0;

	    // [sum(sample mean - subj mean)^2] /total num over all subjects
		// add or subtract std * 16 from 100
		$better = 0;
	    $select = "SELECT * FROM  testOverviewShortTerm";
	    foreach ($dbh->query($select) as $entry) {
	    	$count++;
	    	$sum += ($entry['performance'] - $performance);
	    	if ((int)$entry['performance'] < (int)$performance)
	    	{
	    		$better++;
	    	}
	    }
	    // echo "user preformance:  ".$performance;
	    // echo "</br>count: ".$count."   ";
	    // echo "</br>sum:".$sum;
	    $level = (int)(100*$better/$count);
	    $std = ($sum * $sum) / $count;
	    // echo "std:  ".$std;
	    $score = 100 - (16 * $std);
	    $result = '{"score":'.$score.',"level":'.$level.'}';
	   	echo $result;
	}
	
  
?>