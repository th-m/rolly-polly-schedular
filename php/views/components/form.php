<?php 
  include("../../functions.php"); 
  $qry = "SELECT id FROM {$_POST['table']} ORDER BY id ASC LIMIT 1";  
  $first_id = sql_query($qry);
  $rowId = isset($_POST['rowId']) ? $_POST['rowId']: $first_id[0]['id'];
  
  $qry = "SELECT * FROM {$_POST['table']} WHERE id = $rowId";  
  $table_info = sql_query($qry);
  $dontShowColumns = ['id', 'company_id'];
  $columns = array_diff(array_keys($table_info[0]), $dontShowColumns);
?>
<script type="text/javascript">
$(function() {
  document.querySelector('form').addEventListener('submit', function(){
    let data = $(this).serializeObject();
    data['table'] = '<?=$_POST['table']?>';
    routerPost('update_forms',data, function(){
      console.log("success");
    });
  });
  document.querySelector('#delete').addEventListener('click', function(){
    routerPost('db_delete', {id:this.dataset.row, table:this.dataset.table}, function(data){
      tempData = {
        view: "edit",
        table: "<?=$_POST['table']?>",
        // rowId: data.rowId
      }
      renderView(tempData.view, tempData);
    });
  });
  $('.selectpicker').selectpicker();
});
</script>

<!-- <link rel="stylesheet" href="/css/master.css"> -->
<form  action="javascript:void(0);" data-table="<?=$_POST['table']?>" data-row="<?=$rowId?>" >
  <input type="hidden" name="id" value="<?=$rowId?>">
  <?php foreach ($columns as $column) { 
    if(strpos($column, '_id')){  ?>
    <label for="<?=$column?>"><?=str_replace("_id","",$column);?></label><br>
    <select id="<?=$column?>" name="<?=$column?>" class="selectpicker" data-width="100%">
      <?php selectBoxOptionHelper($column, $_POST['rowId'], $_POST['table']); ?>
    </select>   
  <?php } elseif(strpos($column, '_list')) {  ?>
    <label for="<?=$column?>"><?=str_replace("_list","",$column);?></label><br>
    <select id="<?=$column?>" multiple  name="<?=$column?>" class="selectpicker" data-width="100%">
      <?php multiSelectBoxHelper($column, $_POST['rowId'], $_POST['table']); ?>
    </select>   
  <?php } elseif($column != "is_active") { ?>
    <div class="form-group">
      <label for="<?=$column?>"><?=str_replace("_"," ",$column);?></label><br>
      <input type="text" class="form-control" name="<?=$column?>" value="<?=$table_info[0][$column]?>" placeholder="<?=$column?>">
    </div>
  <?php }
    }  ?>
    <input type="submit" value="save">
    <input id="delete" data-table="<?=$_POST['table']?>" data-row="<?=$rowId?>" type="button" value="delete">
</form>
