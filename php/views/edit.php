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
.editContainer {
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


#editMain {
  background: aliceblue;
 -ms-flex: 1;
 -webkit-box-flex: 1;
 -moz-box-flex: 1;
 -ms-box-flex: 1;
 box-flex: 1;  
}
#editMain form{
  width: 100%;
}
</style>
<script type="text/javascript">
  formData = {}
  // formData.cols = <?=$columns?>;
  formData.table = '<?=$_POST['table']?>';
  $('#editMain').load('./php/views/components/form.php', formData);
  // let drawerLinks = document.querySelectorAll('.drawer ul li');
  document.querySelectorAll('.drawer ul li').forEach(lnk =>{
    lnk.addEventListener('click', function(){ 
      showFormData(lnk.dataset);
    }, false);
  })
  
  function showFormData(data) {
    formData.rowId = data.rowid;
    $('#editMain').load('./php/views/components/form.php', formData);
  }
</script>
<!-- <pre>
  <?php print_r($columns);  ?>
</pre> -->
<div class="editContainer">
  <div class="drawer" >
    <ul>
      <?php foreach ($table_info as $row) { 
        // NOTE:teacher_id, id should be in hidden inputs
        //  role_id ties to events, so lets show a drop down of roles.
        ?>
          <li data-table"<?=$v['table']?>" data-rowid="<?=$row['id']?>"><?=$row['title']?></li>
      <?php } ?>
    </ul>
  </div>
  <div id="editMain">
  </div>
</div>