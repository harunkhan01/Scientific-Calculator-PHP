<?php
/*
Future Goals
  - Displays History
    - Figure out how to right justify '= ans'
  - Add some quality of life
    - switching from radian to degrees
  - Program algorithms for mathematical operations
    - software algorithm for log/ln
    - software implementation for generic root implementation
  - Implement Syntax Error Detection
    - Detect division by zero
*/

require __DIR__ . '/parser.php';
require __DIR__ . '/html_helper.php';

try {

  $num1 = htmlspecialchars($_POST['numbers']);

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['numbers'])){

      $ans = parseString($num1);

      $output .= createDisabledInputTag($num1, $ans);

      if (array_key_exists("prevAns", $_SESSION)){
        $_SESSION['prevAns'][] = $ans;
        $_SESSION['prevInp'][] = $num1; 
        for ($i=count($_SESSION['prevAns'])-2; $i >= 0; $i--){
          $output .= createDisabledInputTag($_SESSION['prevInp'][$i], $_SESSION['prevAns'][$i]);
        }
      } else {
        $_SESSION["prevAns"] = array();
        $_SESSION["prevInp"] = array();
        $_SESSION["prevAns"][] = $ans;
        $_SESSION["prevInp"][] = $num1;
      }

      if ( count($_SESSION['prevAns']) < 5 ) {
        for ($i=0; $i < 5 -count($_SESSION['prevAns']); $i++ ){
          $output .= createEmptyInputTag();
        }
      }

      echo $output;

    } elseif (isset($_POST['clearAll'])) {
      $_SESSION["prevAns"] = array();
      $_SESSION['prevInp'] = array();
    } 
  }

  if (!array_key_exists("prevAns", $_SESSION)){
    for ($i=0; $i < 5; $i++){
      $output .= createEmptyInputTag();
    }

    echo $output;
  }

} catch (Exception $e) {
  echo $e->getMessage();
}