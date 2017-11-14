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
      $selected = (($selected_ids[0]['room_id'] != Null && $selected_ids[0]['room_id'] == $id) ? 'selected': '');
      echo "<option id='$id' value='$id' $selected> $title </option>";
    }
    
  }
  
  function multiSelectBoxHelper($column, $row_id = Null, $parent_table){
    $associate_column = str_replace("_list","",$column);
    $selectors = "id, title";
    $selectors .= ($column == "rooms_list" ? " ,img":"");
    $qry = "SELECT $selectors FROM $associate_column";
    $assoc_table_info = sql_query($qry);
    
    if($row_id != Null){
      $qry = "SELECT $column FROM $parent_table WHERE id = $row_id";
      $selected = sql_query($qry);
    }
    
    foreach ($assoc_table_info as $info) {
      $id = $info['id'];
      $title = str_replace("_"," ",$info['title']);
      $img = $info['img'];
      if(substr($selected[0][$column], 0,1) == "[" && substr($selected[0][$column],-1) == "]"){
        $isSelected = (in_array($title, json_decode($selected[0][$column]))?"selected":"");
      }else{
        $isSelected = ($title == $selected[0][$column]?"selected":"");
      }
      if($column == "rooms_list"){
        echo " <option id='$id' ".$isSelected." data-content=\"<img style='width:20px; filter: invert(100%);'src='http://schedular.xyz/imgs/$img'><span>$title</span>\">$title</option>";
      }else{
        echo " <option id='$id'  ".$isSelected." >$title</option>";
      }
    }
  }
 ?>