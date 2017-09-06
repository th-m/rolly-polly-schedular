<?php
  require("cons.php"); 

  function sql_format_helper($data, $table, $is_select = Null){
    global $link;
    $count = 0;
    $fields = "";
    $get_table_columns = mysqli_query($link,"SELECT * FROM $table LIMIT 1;");
    $table_columns = ($get_table_columns?mysqli_fetch_all($get_table_columns,MYSQLI_ASSOC):"");
    $iterator = ($is_select?" && ":",");
    foreach($data as $col => $val) {
      // Empty strings break queries, and ID's are used differently
      if($col != 'id' && $col != ""){
        // Check if column is in table to avoid breaking cloud-storage
        if (array_key_exists($col, $table_columns[0])) {

          if ($count++ != 0) $fields .= "$iterator" ;
          $val = ($val != "" ? "'".$val."'" : 'null');
          $fields .= "$col = $val";
       }
     }
    }
    // echo $fields;
    return $fields;
  }

  function sql_check_id($id, $table){
    global $link;
    $query = "SELECT id FROM $table WHERE id = $id;";
    $truthy = mysqli_query($link, $query);
    $truthy = ($truthy->num_rows !== 0?True:False);
    return $truthy;
  }
  // add provider

  function update_sql($data, $table){
    global $link;
    $exists = False;
    // return "$data, $table";
    if(isset($data['id']) && $data['id'] != ""){
      // $id = $data['id'];
      $exists = sql_check_id($data['id'], $table);
    }
    $fields = sql_format_helper($data, $table);
    if($exists){
      $query = "UPDATE $table SET $fields WHERE id = {$data['id']};";
      mysqli_query($link, $query);
      return $query;
    }else{
      if (isset($data['id']) && $data['id'] != ""){
          $fields .= ',id = '. $data['id'];
      }
      mysqli_query($link, "INSERT INTO $table SET $fields;");
      // echo "INSERT INTO $table SET $fields;";
      return mysqli_insert_id($link);
      // return "INSERT INTO $table SET $fields;";
    }
  }

  function sql_delete($id, $table){
    global $link;
    if(gettype($id)=="array"){
        $ids = $id;
        foreach ($ids as $id) {
          $query = "DELETE FROM $table WHERE id = $id;";
          mysqli_query($link, $query);
        }
    }else{
      $query = "DELETE FROM $table WHERE id = $id;";
      mysqli_query($link, $query);
    }
  }

  function sql_query($sql){
    global $link;
    $qry = mysqli_query($link, $sql);
    $obj = ($qry?mysqli_fetch_all($qry,MYSQLI_ASSOC):"");
    // echo "$obj";

    return $obj;
  }
  
  function insert_id() {
    global $link;
    return mysqli_insert_id($link);
  }
  // function sql_update_each($ro, $table, $check = Null){
  //   // Get a lit of all from the database.
  //   if($check){
  //     $check_obj = sql_query("SELECT * FROM $table WHERE ".$check['column']."=".$check['value'].";");
  //     $removables = [];
  //     foreach ($check_obj as $obj) {
  //       array_push($removables,$obj['id']);
  //     }
  //   }
  //   // loop through each object to update.
  //   foreach ($ro as $o) {
  //     $formated_sql = sql_format_helper($o , $table, True);
  //     $exists = sql_query("SELECT * FROM $table WHERE $formated_sql");
  // 
  //     // If the object does not exist, we will update it.
  //     if(!$exists[0]){
  //       update_sql($o, $table);
  //     }else{
  //       // If object exists in post and in db we can remove it from the removable list.
  //       if($check){
  //         if (($key = array_search($exists[0]['id'], $removables)) !== false) {
  //             unset($removables[$key]);
  //         }
  //       }
  //     }
  //   }
  //   // This is everything left in the db that was not included int he post, we will delete it.
  //   foreach($removables as $removable){
  //     sql_delete($removable, $table);
  //   }
  // }

  // function q($sql){
  //   global $link;
  //   $var = mysqli_query($link, $sql);
  //   return $var;
  // }
  //
  // function fetchAll($sql = '', $stripslashes = true) {
  //   if($sql)
  //     $query = q($sql);
  //
  //   if($query) {
  //     $var = array();
  //     while($row = mysqli_fetch_assoc($query)) {
  //
  //       // If there are only single values in each $row, just get the values and ignore the keys
  //       if(count($row) === 1) {
  //         $key = reset($row);
  //         array_push($var, $key);
  //       }
  //       else {
  //         $var[] = $row;
  //       }
  //     } //end while($row = mysqli_fetch_assoc($query))
  //
  //     if(is_array($var)) {
  //       return $var;
  //     }
  //   }
  //   else {
  //     return false;
  //   }
  //
  // }


?>


