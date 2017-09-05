<?php 
  include("../../functions.php"); 
  if(isset($_POST['rowId'])){
    $qry = "SELECT * FROM {$_POST['table']} WHERE id = {$_POST['rowId']}";  
  }else{
    $qry = "SELECT * FROM {$_POST['table']}";
  }
  $table_info = sql_query($qry);

?>  
<pre>
<?php print_r($_POST); ?>
</pre>
<!-- <pre>
<?php print_r($table_info); ?>
</pre> -->
<?php
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
    <!-- <select id="<?=$column?>"> -->
      <?php selectBoxOptionHelper($column, $_POST['rowId'], $_POST['table']); ?>
    <!-- </select>    -->
    <br> 
  <?php } else { ?>
    <input type="text" name="<?=$column?>" value="<?=$table_info[0][$column]?>" placeholder="<?=$column?>">
    <br> 
  <?php }
    }  ?>
</form>
