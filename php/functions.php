<?php
  require("sql.php"); 
 
  function test_hi(){
    return "eh?";
  }
  
  function selectBoxOptionHelper($column){
    $associate_column = str_replace("_id","s",$column);
    $qry = "SELECT id, title FROM $associate_column";
    $assoc_table_info = sql_query($qry);
    foreach ($assoc_table_info as $info) {
      $id = $info['id'];
      $title = $info['title'];
      echo "<option id='$id' value='$id'> $title </option>";
    }
  }
 ?>