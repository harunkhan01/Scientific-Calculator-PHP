<?php 

require __DIR__ . '/evaluator.php';

function parseString($str) {

  // associative array for O(1) lookup of legal tokens
  $legal_ops = array("+"=>true, "/"=>true, "-"=>true, "*"=>true, ")"=>true, "("=>true, "!"=>true, "^"=>true, "%"=>true);

  $token_arr = array();
  $tmp = "";

  $str = trimSpace($str);

  for ($i=0; $i < strlen($str); $i++){

    // check if negative number
    if ($str[$i] === '-' and ($i === 0 or array_key_exists($str[$i-1], $legal_ops))) {
      $tmp = $tmp . $str[$i];

    // check if character is an operator or parantheses
    } elseif (array_key_exists($str[$i], $legal_ops)) {
      // check if in associative array
      if ($tmp !== ""){
        $token_arr[] = $tmp;
        $tmp = "";
      }
      $token_arr[] = $str[$i];
    } else {
      $tmp = $tmp . $str[$i];
    }

  }

  if ($tmp !== ""){
    $token_arr[] = $tmp;
  }

  return postFix($token_arr);
}


function trimSpace($str) {
  $ret_str = "";

  for ($i=0; $i < strlen($str); $i++){
    if ($str[$i] === " "){
      continue;
    } else {
      $ret_str = $ret_str . $str[$i];
    }

  }

  return $ret_str;
}