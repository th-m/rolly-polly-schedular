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
  
  function getImgIconsforTeacher($teacherId){
    $qry = "SELECT rooms_list FROM staff_members WHERE id = $teacherId";
    $rooms_list = sql_query($qry);  
    if(substr($rooms_list[0]['rooms_list'], 0,1) == "[" && substr($rooms_list[0]['rooms_list'],-1) == "]"){
      $rooms = json_decode($rooms_list[0]['rooms_list']);
    }
    else{
      $rooms[] = $rooms_list[0]['rooms_list'];
    }
    $qry = "SELECT title, img FROM rooms;";
    $rooms_title = sql_query($qry);
    // echo $qry;
    // print_r($rooms_title);
    foreach ($rooms as $room) {
      $room = str_replace(" ","_",$room);
      foreach ($rooms_title as $key => $value) {
        if(in_array($room,$value)){
          // print_r($rooms_title[$key]);
          $img_title = $rooms_title[$key]['title'];
          $img_source = $rooms_title[$key]['img'];
          $link = "http://schedular.xyz/imgs/$img_source";
          echo "<img data-name='$img_title' style='width:10px; filter:invert(100%);' src='$link'/> &nbsp;";
          
        }
      }
  
    }
      
  }
 ?>