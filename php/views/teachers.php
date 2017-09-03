<?php
    include("../functions.php"); 
    // print_r($_POST);
    // print_r(json_decode($_POST),true);
    
    // if($v['table'] == "teachers"){ // TODO: think this threw. Run tables through loop, join on main_id???
    //   $qry = "SELECT teachers.* , roles.* , teachers.id as main_id
    //         FROM teachers
    //         RIGHT JOIN roles on teachers.id = roles.teacher_id;";
    // }else{
    $qry = "SELECT * FROM {$_POST['table']}";
    // }
    if(isset($_POST['assoctables'])){
      $_POST['assoctables'] = explode(",", $_POST['assoctables']);
      // print_r($_POST['assoctables']);
    }
    $table_info = sql_query($qry);
    $columns = json_encode(array_keys($table_info[0]));
    
    
?>

<script type="text/javascript">
  formData = JSON.parse('<?=json_encode($_POST)?>');
  console.log(formData);
  // formData.cols = <?=$columns?>;
  // formData.table = '<?=$_POST['table']?>';
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
  <?php print_r($_POST);  ?>
</pre> -->
<div class="editContainer">
  <div class="drawer" >
    <ul>
      <?php foreach ($table_info as $row) { ?>
          <li data-table"<?=$v['table']?>" data-rowid="<?=$row['id']?>"><?=$row['title']?></li>
      <?php } ?>
        <li data-table"<?=$v['table']?>" data-rowadd=>+</li>
    </ul>
  </div>
  <div id="editMain">
  </div>
</div>