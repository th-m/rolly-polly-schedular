<?php
  include("functions.php"); 
   date_default_timezone_set("America/Denver");
   $sunday = strtotime('Sunday');
   $d = date('Y-m-d', $sunday);
  //NOTE: We capture the json post data, then we decode it so php can use it.
  $json = file_get_contents('php://input');
  $json = json_decode($json, true);
  
  //NOTE: Set our initial response.
  $response = array('response' => "notChanged");
  
  switch ($json['function']) {
   case 'db_post':
     $response['rowId'] =  update_sql($json['data']['data'], $json['data']['table']);
     break;
   case 'update_prep_json':
    
     $qry = "SELECT id FROM kids_next_week WHERE date = '$d'";
     //NOTE: we use Sundays as a dilimater to seperate weeks. 
     $prep_id= sql_query($qry);
     if(isset($prep_id[0]['id']) && $prep_id[0]['id'] != ""){
       $json['data']['id'] = $prep_id[0]['id'];
     }else{
       $qry = "INSERT INTO kids_next_week SET date = '$d'";
       $ins= sql_query($qry);
       $qry = "SELECT id FROM kids_next_week WHERE date = '$d'";
       $prep_id= sql_query($qry);
       $json['data']['id'] = $prep_id[0]['id'];      
     }
     $json['data']['json_blob'] = json_encode($json['data']['json_blob']);
     $response['rowId'] =  update_sql($json['data'], 'kids_next_week');
     break;
   case 'update_teacher_schedule_json':
    
     $json['data']['date'] = $d;
     $qry = "SELECT id FROM schedule_next_week WHERE date = '$d' AND dow = '{$json["data"]["dow"]}' AND staff_id = '{$json["data"]["staff_id"]}'; ";
     $prep_id= sql_query($qry);  
     if(isset($prep_id[0]['id']) && $prep_id[0]['id'] != ""){
       $json['data']['id'] = $prep_id[0]['id'];
     }
     $response['rowId'] =  update_sql($json['data'], 'schedule_next_week');
     
     break;
   case 'db_query':
     echo "string";
     break;
   case 'update_forms':
     // print_r($json);
     $table = $json['data']['table'];
     unset($json['data']['table']);
     // print_r($json['data']);
    $response['rowId'] =  update_sql($json['data'], $table);
   case 'db_delete':
     sql_delete($json['data']['id'], $json['data']['table']);
     $response['rowId'] = $json['data']['id'];
     $response['response'] = "deleted" ;
     break;
  
   case 'emailer':
      $response['response'] = "emailing valacano";
      $msg = "First line of text\nSecond line of text";
      $msg = wordwrap($msg,70);

      mail("valacano@yahoo.com","Rolly Polly Schedule",$msg);
     break;
    
  }
  
  echo json_encode($response);
  
?>