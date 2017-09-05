<?php
  require("sql.php"); 
 
  function test_hi(){
    return "eh?";
  }
  
  function selectBoxOptionHelper($column, $row_id = Null, $parent_table){
    $associate_column = str_replace("_id","s",$column);
    $qry = "SELECT id, title FROM $associate_column";
    $assoc_table_info = sql_query($qry);
    
    //NOTE: get selected values
    $selected_ids = "hello";
    if($row_id != Null){
      $qry = "SELECT room_id FROM $parent_table WHERE id = $row_id";
      $selected_ids = sql_query($qry);
    }
    
    foreach ($assoc_table_info as $info) {
      $id = $info['id'];
      $title = $info['title'];
      // $selected = (($row_id != Null && $row_id == $id) ? 'selected': '');
      // echo "<option id='$id' value='$id'> $title $selected_ids[0] </option>";
      echo print_r($selected_ids);
    }
    
  }
 ?>