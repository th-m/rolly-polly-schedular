<?php
  require("cons.php"); 

  function sql_format_helper($data, $table, $is_select = Null){
    global $link;
    // echo $table;
    $count = 0;
    $fields = "";
    $get_table_columns = mysqli_query($link,"SELECT * FROM $table LIMIT 1;");
    
    // if($get_table_columns){      
    //   while ($row = $get_table_columns->fetch_assoc()) {
    //       print_r($row);
    //       $obj[] = $row;
    //   }
    // }
    $table_columns = ($get_table_columns?mysqli_fetch_all($get_table_columns,MYSQLI_ASSOC):"");
    // print_r($table_columns);
    // print_r($obj);
    $iterator = ($is_select?" && ":",");
    foreach($data as $col => $val) {
      //NOTE: Empty strings break queries, and ID's are used differently
      if($col != 'id' && $col != ""){
        //NOTE: Check if column is in table to avoid a breaking statement.
        if (array_key_exists($col, $table_columns[0])) {

          if ($count++ != 0) $fields .= "$iterator" ;
          if(gettype($val) == "array") $val = json_encode($val);
          $val = ($val != "" ? "'".$val."'" : 'null');
          $fields .= "$col = $val";
       }
     }
    }
    return $fields;
  }

  function sql_check_id($id, $table){
    global $link;
    $query = "SELECT id FROM $table WHERE id = $id;";
    $truthy = mysqli_query($link, $query);
    $truthy = ($truthy->num_rows !== 0?True:False);
    return $truthy;
  }

  function update_sql($data, $table){
    global $link;
    $exists = False;
    if(isset($data['id']) && $data['id'] != ""){
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
      return mysqli_insert_id($link);
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
    return true;
  }

  function sql_query($sql){
    global $link;
    $qry = mysqli_query($link, $sql);
    $data = [];
    if($qry){      
      while ($row = $qry->fetch_assoc()) {
          $obj[] = $row;
      }
      return $obj;
    }
  }
  
  function insert_id() {
    global $link;
    return mysqli_insert_id($link);
  }



?>


