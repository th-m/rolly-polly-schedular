<?php
    include("../functions.php"); 
    $qry = "SELECT * FROM {$_POST['table']}";
    if(isset($_POST['assoctables'])){
      $_POST['assoctables'] = explode(",", $_POST['assoctables']);
    }
    $table_info = sql_query($qry);
    $columns = json_encode(array_keys($table_info[0]));
?>
<style media="screen">
  .hidden{
    display: none;
  }
</style>
<script type="text/javascript">
  formData = JSON.parse('<?=json_encode($_POST)?>'); // We do this to capture arrays.
  $('#editMain').load('./php/views/components/form.php', formData);

  document.querySelectorAll('.drawer ul .row_info').forEach(lnk =>{
    lnk.addEventListener('click', function(){ 
      showFormData(lnk.dataset);
    }, false);
  })
  function showFormData(data) {
    console.log("hello");
    formData.rowId = data.rowid;
    $('#editMain').load('./php/views/components/form.php', formData);
  }
  
  document.querySelector('.save_row button').addEventListener('click', function(){
    input = document.querySelector('.save_row input');
    // console.log(input.value);
    document.querySelector('.add_row').classList.remove("hidden");
    this.parentElement.classList.add('hidden');
    // $('#editMain').load('./php/views/components/form.php', formData);
    routerPost('db_post', {data:{title:input.title}, table:'<?=$_POST['table']?>'});
    routerPost('db_post');
    routerPost('test_hi');
  });
  function pressedKeys(){
    console.log("gotcha");
  }
  
  document.querySelector('.add_row').addEventListener('click', function(){
      this.classList.add('hidden');
      document.querySelector('.save_row').classList.remove("hidden");
  });
</script>
<div class="editContainer">
  <div class="drawer" >
    <ul>
      <?php foreach ($table_info as $row) { ?>
          <li class="row_info" data-table"<?=$v['table']?>" data-rowid="<?=$row['id']?>"><?=$row['title']?></li>
      <?php } ?>
        <li class="add_row" data-table"<?=$v['table']?>" data-rowadd=>+</li>
        <li class="save_row hidden">
          <input type="text" name="" value="" placeholder="Add title">
          <button type="button" name="button">Submit</button>
        </li>
    </ul>
  </div>
  <div id="editMain">
  </div>
</div>