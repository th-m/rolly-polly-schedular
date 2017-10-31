<?php
  include("functions.php"); 
  //NOTE: We capture the json post data, then we decode it so php can use it.
  $json = file_get_contents('php://input');
  $json = json_decode($json, true);
  
  //NOTE: Set our initial response.
  $response = array('response' => "notChanged");
  
  switch ($json['function']) {
   case 'db_post':
     $response['rowId'] =  update_sql($json['data']['data'], $json['data']['table']);
    // //NOTE: using double qoutes allows us to include variables without concatinating
    // //NOTE: using sinqle qoutes returns a literal string.
     break;
   case 'db_query':
     echo "string";
     break;
   case 'db_delete':
     sql_delete($json['data']['id'], $json['data']['table']);
     $response['rowId'] = $json['data']['id'];
     $response['response'] = "deleted" ;
    //  echo "string";
     break;
  
   case 'emailer':
        $response['response'] = "emailing valacano";
       // the message
      $msg = "First line of text\nSecond line of text";

      // use wordwrap() if lines are longer than 70 characters
      $msg = wordwrap($msg,70);

      // send email
      mail("valacano@yahoo.com","Rolly Polly Schedule",$msg);
     break;
  
  //  case 'db_delete':
  //    # code...
  //    break;
    
   case 'test_hi':
    $test_hi = test_hi();
    //NOTE: using double qoutes allows us to include variables without concatinating
    //NOTE: using sinqle qoutes returns a literal string.
    $response['response'] = "$test_hi";
    
     break;
   
  //  default:
  //    # code...
  //    break;
  }
  
  // $return = json_encode($response);
  // echo(json_encode($response));
  echo json_encode($response);
  // echo ($response);
  
?>