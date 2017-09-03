<?php 
  include("../../functions.php"); 
  $qry = "SELECT * FROM {$_POST['table']}";
  $table_info = sql_query($qry);
  $dontShowColumns = ['id', 'company_id'];
  $columns = array_diff(array_keys($table_info[0]), $dontShowColumns);
?>
<!-- <pre>
<?php print_r($columns); ?>
</pre> -->

<form class="" action="" >
  <?php foreach ($columns as $column) { 
    if(strpos($column, '_id')){  ?>
    <select id="<?=$column?>">
      <?php selectBoxOptionHelper($column); ?>
    </select>   
    <br> 
  <?php } else { ?>
    <input type="text" name="<?=$column?>" value="" placeholder="<?=$column?>">
    <br> 
  <?php }
    }  ?>
</form>
