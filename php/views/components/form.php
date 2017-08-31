<?php 
  include("../../functions.php"); 
  print_r($_POST);
  
  // $v = json_decode($_POST['json'], true);
?>

<form class="" action="" >
  <?php foreach ($columns as $column) { 
    // NOTE: we can pregmatch(_id) and replace with s, run through a qry and pull lists
    // NOTE: if id we need to hide it.
    ?>
    <input type="text" name="<?=$column?>" value="" placeholder="<?=$column?>">
  <?php } ?>
</form>