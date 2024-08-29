<?php

function math_add($op1, $op2){
	return (float) $op2 + (float) $op1;
}

function math_sub($op1, $op2){
	return (float) $op2 - (float) $op1; 
}

function math_div($op1, $op2){
	$op1 = (float) $op1;
	$op2 = (float) $op2;
	
	return $op2 / $op1;
}

function math_mult($op1, $op2){
	return (float) $op2 * (float) $op1;
}

function math_pow($op1, $op2){
	if ($op2 === "e") {
		return math_e((float)$op1);
	}

	return pow((float)$op2, (float)$op1);
}

function math_mod($op1, $op2){
	return (float) $op2 % (float) $op1;
}

/*
Single Operator Functions

*/

// implementation not as precise as could be
function math_sin($op1){
	return sin($op1);
	/* Taylor Series Implementation results in rounding errors
	$accuracy = 0.0000000000001;
	$prev = $op1;
	$ans = $op1;

	// on even turns the number is negative
	$even = true;
	$round = 3;

	do {
		$prev = $ans;

		$tmp = math_pow($round, $op1) / math_fact($round);

		if ($even){
			$ans -= $tmp;
		} else {
			$ans += $tmp;
		}

		$even = !$even;
		$round += 2;
		
	} while (abs($ans-$prev) > $accuracy);

	return $ans;
	*/ 
}

// implementation not as precise as could be
function math_cos($op1){ 
	return cos($op1); 
	/* 
	Implement via Taylor Series results in rounding errors

	$accuracy = .0001;
	$prev = 1;
	$ans = 1;

	// on even turns the number is negative
	$even = true;
	$round = 2;

	while (1) {
		$prev = $ans;

		$tmp = math_pow($round, $op1) / math_fact($round);


		if ($even) {
			$ans -= $tmp;
		} else {
			$ans += $tmp;
		}

		if ( abs($prev - $ans) < $accuracy ) {
			break;
		}

		$even = !$even;
		$round += 2;

	}

	return $ans;
	*/ 
}


function math_tan($op1){
	return sin($op1) / cos($op1);
}

function math_log($op1){
	return log($op1, 10);
}

function math_ln($op1){
	return log($op1);
}

function math_sqrt($op1){
	// implement Newton's Method
	$accuracy = .000000001;
	$x = $op1;

	while(1){
		$root = 0.5 * ($x + ($op1 / $x));

		// update between prev and curr is less than required accuracy we can exit
		if (abs($x - $root) < $accuracy){
			break;
		}

		$x = $root;
	}

	return $root;
}

function math_fact($op1){
	if ($op1 <= 0) {
		return 1;
	}

	return math_fact($op1-1) * $op1;
}

function math_e($op1){

	$accuracy = 0.000001;
	$prev = 1; 
	$ans = 1;
	$round = 1;

	do {
		$prev = $ans;

		$ans += math_pow($round, $op1) / math_fact($round);

		$round++;

	} while (abs($ans-$prev) > $accuracy);


	return $ans;
}