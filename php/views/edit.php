<?php
    include("../functions.php"); 
    $qry = "SELECT * FROM {$_POST['table']}";
    if(isset($_POST['assoctables'])){
      $_POST['assoctables'] = explode(",", $_POST['assoctables']);
    }
    $table_info = sql_query($qry);
    $columns = json_encode(array_keys($table_info[0]));
?>

<script type="text/javascript">
  formData = JSON.parse('<?=json_encode($_POST)?>'); // We do this to capture arrays.
  $('#editMain').load('./php/views/components/form.php', formData);

  document.querySelectorAll('.drawer ul li').forEach(lnk =>{
    lnk.addEventListener('click', function(){ 
      showFormData(lnk.dataset);
    }, false);
  })
  
  function showFormData(data) {
    console.log("hello");
    formData.rowId = data.rowid;
    $('#editMain').load('./php/views/components/form.php', formData);
  }
</script>
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