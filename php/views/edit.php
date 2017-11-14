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
  .drawer {
    /*background: hotpink;*/
    width: 27%;
    -ms-flex: 0 100px;
    -webkit-box-flex:  0;
    -moz-box-flex:  0;
    -ms-box-flex:  0;
    box-flex:  0;  
  }
  .drawer ul{
    list-style-type: none;
    margin-left: 0;
    padding-left: 0;
  }
  .drawer ul li{
    text-align: center;
    margin-bottom: 4px;
    padding:7px;
    border: 1px solid #dedede;
    /*border-color: #dedede;*/
    border-radius: 7px;
  }
  .drawer ul li:hover{
    background-color: #dedede;
  }
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

  #editMain {
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
  formData = JSON.parse('<?=json_encode($_POST)?>');
  $('#editMain').load('./php/views/components/form.php', formData);
  
  function showFormData(data) {
    formData.rowId = data.rowid;
    $('#editMain').load('./php/views/components/form.php', formData);
  }
  
  document.querySelectorAll('.drawer ul .row_info').forEach(lnk =>{
    lnk.addEventListener('click', function(){ 
      showFormData(lnk.dataset);
    }, false);
  })
  
  document.querySelector('.save_row button').addEventListener('click', function(){
    input = document.querySelector('.save_row input');
    document.querySelector('.add_row').classList.remove("hidden");
    this.parentElement.classList.add('hidden');
    routerPost('db_post', {data:{title:input.value}, table:'<?=$_POST['table']?>'}, function(data){
      tempData = {
        view: "edit",
        table: "<?=$_POST['table']?>",
        rowId: data.rowId
      }
      renderView(tempData.view, tempData);
    });
  });
  
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