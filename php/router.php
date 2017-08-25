<?php
  include("functions.php"); 
  //NOTE: We capture the json post data, then we decode it so php can use it.
  $json = file_get_contents('php://input');
  $json = json_decode($json, true);
  
  //NOTE: Set our initial response.
  $reponse = array('response' => "notChanged");
  
  switch ($json['function']) {
  //  case 'db_post':
  //    # code...
  //    break;
  //  
  //  case 'db_query':
  //    # code...
  //    break;
  
  //  case 'db_delete':
  //    # code...
  //    break;
    
   case 'test_hi':
    $test_hi = test_hi();
    //NOTE: using double qoutes allows us to include variables without concatinating
    //NOTE: using sinqle qoutes returns a literal string.
    $reponse['response'] = "$test_hi";
    
     break;
   
  //  default:
  //    # code...
  //    break;
  }
  
  $return = json_encode($reponse);
    //  print_r($return);
  echo json_encode($return);
  
?>