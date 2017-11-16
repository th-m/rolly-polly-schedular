<?php 
// NOTE: let's use this to link all of our styles
include('head.php'); 

if($_SESSION['user']){
?>
  <div id="rolly_polly_main">
    <div class="">
      <img src="http://schedular.xyz/imgs/home.svg" alt="">
    </div>
  </div>
<?php 
}
// NOTE: let's use this to link all of our js
include('footer.php');?>