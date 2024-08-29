<?php

require __DIR__ . '/math.php';

function postFixEval($arr) {
  // this stack holds the operands
  $two_ops = array("+"=>"math_add", "/"=>"math_div", "-"=>"math_sub", "*"=>"math_mult", "^"=>"math_pow", "%"=>"math_mod");
  $one_op = array("sin"=>"math_sin", "cos"=>"math_cos", "tan"=>"math_tan", "log"=>"math_log", "ln"=>"math_ln", "sqrt"=>"math_sqrt", "!"=>"math_fact");
  $stack = array();
  $top = -1;

  for ($i=0; $i<count($arr); $i++){
    if ( array_key_exists($arr[$i], $two_ops) ) {
      $op1 = $stack[$top];
      $op2 = $stack[$top-1];

      $top--;
      // confusing syntax: $two_ops holds the function name mapped to the token key
      $stack[$top] = $two_ops[$arr[$i]]($op1, $op2);

    } elseif ( array_key_exists($arr[$i], $one_op) ) {
      $op1 = (float) $stack[$top];

      $stack[$top] = $one_op[$arr[$i]]($op1);

    } else {
      $top++;
      $stack[$top] = $arr[$i];
    }

  }

  return $stack[$top];

}


function postFix($arr) {
  $output = array();
  $stack = array();
  $top = -1;

  // operator tier list by PEMDAS
  $high_prio = array("/"=>true, "*"=>true, "%"=>true);
  $low_prio = array("-"=>true, "+"=>true);

  $word_ops = array("sin"=>"sin", "cos"=>"cos", "log"=>"log", "ln"=>"ln", "sqrt"=>"sqrt", "tan"=>"tan");
  $constants = array("pi"=>3.14159265358979323846);

  /* 
    Code checks for word ops/constants/high prio/low prio operators and places them in postfix notation
    Input is a collection of tokens which include operators and strings separated by operators
      --> future goal will be to detect illegal tokens
    Output will always be the postfix notation
  */

  $i = 0;

  while ($i < count($arr)){
    if ($arr[$i] === ')') {
      // this also supports word based operators (sin, cos, log, etc)
      while ($stack[$top] !== '(' and $top >= 0) {
        $output[] = $stack[$top];
        $top--;
      }
      $top--;
      if ($top >= 0 and (array_key_exists($stack[$top], $word_ops) or $stack[$top] === "^")){
        $output[] = $stack[$top];
        $top--;
      }

    } elseif ($arr[$i] === '(') {
      $stack[$top + 1] = '(';
      $top++;

    } elseif ($arr[$i] === '^'){
      // this section requires lookahead
      if ($arr[$i+1] !== "("){
        $output[] = $arr[$i+1];
        $output[] = $arr[$i];
        $i++;
      } else {
        // this requires the postfix evaluator to be applied to a range
        // add the ^ operator to the stack
        $stack[$top+1] = '^';
        $top++;
      }

    } elseif ($arr[$i] === '!') {
      $output[] = $arr[$i];

    } elseif (array_key_exists($arr[$i], $high_prio)) { 
      while ($top >= 0 and array_key_exists($stack[$top], $high_prio) ){
        $output[] = $stack[$top];
        $top--;
      }
      $stack[$top + 1] = $arr[$i];
      $top++;

    } elseif (array_key_exists($arr[$i], $low_prio)) {
      while ($top >= 0 and (array_key_exists($stack[$top], $high_prio) or array_key_exists($stack[$top], $low_prio)) ){
        $output[] = $stack[$top];
        $top--;
      }
      $stack[$top + 1] = $arr[$i];
      $top++;

    } elseif ( array_key_exists($arr[$i], $word_ops) ){
      $stack[$top+1] = $word_ops[$arr[$i]];
      $top++;

    } elseif ( array_key_exists($arr[$i], $constants) ) {
      $output[] = $constants[$arr[$i]];
      
    } else {
      $output[] = $arr[$i]; 
    }

    $i++;

  }

  for ($i=$top; $i >= 0; $i--) {
    $output[] = $stack[$i];
  }

  return postFixEval($output);

}