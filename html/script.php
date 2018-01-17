<?php

	//ini_set('display_errors', 1);
	
	set_time_limit(60 * 60);                    // Dura 1 ora

	include 'hextest.php';

	error_reporting(E_ALL);
	$IFILE = "chiavepub.pem";
	$OFILE = "risultatoyafu.log";
	$RFILE = "privata.pem";	
	$FFILE = "chiavePrivata.pem";	
	
	$chiave = file_get_contents($IFILE);
	$pattern = '~Modulus: (.*) ~';
	$pattern2 = '~Modulus=(.*)\n~';

	$match;
	$match2;

	preg_match($pattern, $chiave, $match);
	preg_match($pattern2, $chiave, $match2);	

	$modulo = $match[1];
	$modulo2 = $match2[1];


	if (preg_match("/[1-9][0-9]*$/", $modulo) > 0){
		//echo "Il modulo è stato trovato! \n \n";
		exec("echo 'factor($modulo)' | ./yafu > $OFILE");
		//echo "Mi trovo nel then \n \n";	
	}
	
	else {
		$input_ex = bchexdec($modulo2);
		//echo "Il modulo è stato trovato! \n \n $input_ex";
		exec("echo 'factor($input_ex)' | ./yafu > $OFILE");
		//echo "Inizio fattorizzazione.. \n \n";
	}
	

	if(!file_exists($OFILE))
		die("error");
	
	$yafu = file_get_contents($OFILE);
	//echo "Fattori trovati! Calcolo chiave privata... \n \n";
	$out_yafu = str_replace("\n", ' ', $yafu);

		
	//print_r($out_yafu);
	
	$match_result;
	$pattern3 =  '~factors (.*)~';
	preg_match($pattern3, $out_yafu, $match_result);
	//print_r($match_result);

	//echo $out_yafu;
	$pattern4 = '~= \d*~';
	$match_last;
	
	preg_match_all($pattern4, $match_result[1], $match_last, PREG_PATTERN_ORDER);
	//print_r($match_last);
	
	$factors = [];
	foreach ($match_last[0] as $value){
		array_push($factors, substr($value,2));
	}

	//echo "<br> Output: <br>";
	//print_r($factors);
	rsort($factors);
	$p = $factors[0];
	$q = $factors[1];
	echo "p = $p <br>";
	echo "q = $q <br>"; 
	//echo "sto per eseguire \n" . $factors[0] . "  " . $factors[1]; 
	
	exec("python2 genPriv.py ". $factors[0] . " " . $factors[1] . " 65537"); 	
	
	exec("openssl rsa -in privata.pem -text > chiavePrivata.pem");

	$privata_precedente = file_get_contents($RFILE);			
	$privata = file_get_contents($FFILE);
 	//echo "$privata_precedente <br> $privata";

	//echo 'Current user: ' . get_current_user();
	unlink($OFILE);
	unlink($RFILE);
	//unlink($FFILE);	
	unlink($IFILE);

	echo "<br>Successo! Premi Download per scaricare";

	//function getmicrotime() {
	//	list($usec, $sec) = explode(" ", microtime());
	//	return (int)(((float)$usec + (float)$sec)*1000);
	//}
?>
