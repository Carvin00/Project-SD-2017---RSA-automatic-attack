

<?php 

	$a = ' fac: factoring 835355472980089 fac: using pretesting plan: normal fac: no tune info: using qs/gnfs crossover of 95 digits div: primes less than 10000 rho: x^2 + 3, starting 1000 iterations on C15 rho: x^2 + 2, starting 1000 iterations on C15 Total factoring time = 0.0026 seconds ***factors found*** P8 = 26503073 P8 = 31519193 ans = 1';
	
	echo $a;

	$match1;
	$pattern1 = '~factors found(.*)~';
	preg_match($pattern1, $a, $match1);
	print_r($match1);
	
	$pattern2 = '~= \d*~';

	$match2;
	preg_match_all($pattern2, $match1[1], $match2, PREG_PATTERN_ORDER);
	print_r($match2);

	$fac = [];

	foreach ($match2[0] as $value){	
		array_push($fac, substr($value,2));
	}

	print_r($fac);


?>
