<?php
    include("../functions.php"); 
    // print_r($_POST);
    // if($v['table'] == "teachers"){ // TODO: think this threw. Run tables through loop, join on main_id???
    //   $qry = "SELECT teachers.* , roles.* , teachers.id as main_id
    //         FROM teachers
    //         RIGHT JOIN roles on teachers.id = roles.teacher_id;";
    // }else{
    $qry = "SELECT * FROM {$_POST['table']}";
    // }
    $table_info = sql_query($qry);
    $columns = json_encode(array_keys($table_info[0]));
    
    
?>
<style media="screen">
.container {
  height: 100%;
  display: -ms-flexbox;
  display: -webkit-box;
  display: -moz-box;
  display: -ms-box;
  display: box;
  
  -ms-flex-direction: row;
  -webkit-box-orient: horizontal;
  -moz-box-orient: horizontal;
  -ms-box-orient: horizontal;
  box-orient: horizontal;
}

.drawer {
  background: hotpink;
  width: 20%;
  -ms-flex: 0 100px;
  -webkit-box-flex:  0;
  -moz-box-flex:  0;
  -ms-box-flex:  0;
  box-flex:  0;  
}


.editMain {
  background: aliceblue;
 -ms-flex: 1;
 -webkit-box-flex: 1;
 -moz-box-flex: 1;
 -ms-box-flex: 1;
 box-flex: 1;  
}
</style>
<script type="text/javascript">
  formData = {}
  formData.cols = <?=$columns?>;
  $('#editMain').load('./php/views/components/form.php', formData);
  
</script>
<!-- <pre>
  <?php print_r($columns);  ?>
</pre> -->
<div class="container">
  <div class="drawer" >
    <ul>
      
      <?php foreach ($table_info as $row) { 
        // NOTE:teacher_id, id should be in hidden inputs
        //  role_id ties to events, so lets show a drop down of roles.
        ?>
          <li data-table"<?=$v['table']?>" data-rowId="<?=$row['id']?>"><?=$row['title']?></li>
      <?php } ?>
    </ul>
  </div>
  <div id="editMain" >
    <!-- <form class="" action="" >
      <?php foreach ($columns as $column) { 
        // NOTE: we can pregmatch(_id) and replace with s, run through a qry and pull lists
        // NOTE: if id we need to hide it.
        ?>
        <input type="text" name="<?=$column?>" value="" placeholder="<?=$column?>">
      <?php } ?>
    </form> -->
  </div>
</div>