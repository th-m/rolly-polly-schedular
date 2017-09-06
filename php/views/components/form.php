<?php 
  include("../../functions.php"); 
  $rowId = isset($_POST['rowId']) ? $_POST['rowId']: 1;
  $qry = "SELECT * FROM {$_POST['table']} WHERE id = $rowId";  
  $table_info = sql_query($qry);
  $dontShowColumns = ['id', 'company_id'];
  $columns = array_diff(array_keys($table_info[0]), $dontShowColumns);
?>
<script type="text/javascript">
  document.querySelector('form').addEventListener('submit', function(){
    console.log("hello");
  });
</script>
<form  action="javascript:void(0);" data-table="<?=$_POST['table']?>" data-row="<?=$rowId?>" >
  <?php foreach ($columns as $column) { 
    if(strpos($column, '_id')){  ?>
    <select id="<?=$column?>">
      <?php selectBoxOptionHelper($column, $_POST['rowId'], $_POST['table']); ?>
    </select>   
    <br> 
  <?php } else { ?>
    <label for="<?=$column?>"><?=str_replace("_"," ",$column);?></label><br>
    <input type="text" name="<?=$column?>" value="<?=$table_info[0][$column]?>" placeholder="<?=$column?>">
    <br> 
  <?php }
    }  ?>
    <input type="submit" value="save">
</form>
