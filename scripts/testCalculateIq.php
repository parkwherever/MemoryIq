<?php
	// already in record test result
	$performance = 50;
    $dbh = new PDO('mysql:host=localhost;dbname=psych', 'root', 'root'); 
	$select = "SELECT * FROM  testOverviewShortTerm";
	// end 

    // Calculate user stdev
    foreach ($dbh->query($select) as $entry) {
    	$count++;
    	$sum += $entry['performance'];
    	if ((int)$entry['performance'] < (int)$performance)
    	{
    		$better++;
    	}
    }
    $mean = $sum/$count;
    echo "mean: ".$mean;
    echo "</br>";
    // Calculate the sum of (each person's score - mean )^2
    $sumOfSquares = 0;
    foreach ($dbh->query($select) as $entry) {
    	$sumOfSquares += (($entry['performance'] - $mean) * ($entry['performance'] - $mean));
    }
    echo "sum of squares:".$sumOfSquares."</br>";
    $avgMinus1 = (floatval($sumOfSquares) / floatval($count-1));
    echo "avg - 1:".$avgMinus1."</br>";
    $stdev = sqrt($avgMinus1);
    echo "sqrt(avg - 1): stdev: ".$stdev."</br>";

    $dif = floatval(($mean - $performance)/$stdev);
    echo "dif: ".$stdev."</br>";
    $iq = 100 - 16*$dif;
    echo "iq: ".$iq."</br>";
    
?>

