<?php 
  include("../../functions.php"); 
  $qry = "SELECT * FROM {$_POST['table']}";
  $table_info = sql_query($qry);
  // print_r($table_info[0]);
  $columns = array_keys($table_info[0]);
  
?>
<style media="screen">

</style>
<form class="" action="" >
  <?php foreach ($columns as $column) { 
    // NOTE: we can pregmatch(_id) and replace with s, run through a qry and pull lists
    // NOTE: if we find column with id we can keep it hidden.
    // NOTE: we also look for _id to help find drop down options.
    if($column != "id"){
      if(strpos($column, '_id')){  
        $associate_column = str_replace("_id","s",$column);
        if($associate_column == "companys"){
          $associate_column = "companies";
        }
    ?>
    <!-- <label for=""><?=$associate_column?></label> -->
    <select id="<?=$column?>" class="" name="">
      <?php 
        $qry = "SELECT * FROM $associate_column";
        $table_info = sql_query($qry);
        foreach ($table_info as $row) { 
        // NOTE: we query the table for a list of all options. 
      ?>

        <option id="<?=$row['id']?>" value=""><?=$row['title']?></option>
          <li data-table"<?=$v['table']?>" data-rowId="<?=$row['id']?>"><?=$row['title']?></li>
  
      <?php } ?>    
    </select>    
  <?php } else { ?>
  
    <input type="text" name="<?=$column?>" value="" placeholder="<?=$column?>">
    
  <?php }
      } 
    }
  ?>
</form>

<script type="text/javascript">
  
  // 1 fetch url
  // 2 process response
  // 3 process data
  // fetch(url).then(function(response){
  //   return response.json();
  // }).then(function(data){
  //   console.log(data);
  // });
</script>