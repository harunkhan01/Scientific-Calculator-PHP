<?php

function createDisabledInputTag($prevInput, $prevOutput){
	try {
		// need to implement styling within value of input type
		$answer = $prevInput . " = " . $prevOutput;
		return "<input type='text' id='numbers' name='numbers' value='{$answer}' disabled/><br>";
	} catch (Exception $e) {
		return $e->getMessage();
	}
}


function createEmptyInputTag(){
	try{
		return "<input type='text' id='numbers' name='numbers' disabled/><br>";
	} catch (Exception $e) {
		return $e->getMessage();
	}
}