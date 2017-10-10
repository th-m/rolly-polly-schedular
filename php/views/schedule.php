<?php 
  include("../functions.php"); 
  date_default_timezone_set('Australia/Melbourne');
  $date = date('m/d/Y h:i:s a', time());
  // echo "tester";
  // $d = date;
  echo $date;
?>
<script type="text/javascript">
// window.onload = function(){
  printBtn = document.querySelector('#print');
  printBtn.addEventListener('click',function(){
    console.log("printintg");
    scheduleDiv = document.querySelector('#schedule');
    scheduleDiv.print();
  });
  
  emailBtn = document.querySelector('#email');
  emailBtn.addEventListener('click',function() {
    console.log("emailer");
    routerPost('emailer');
  });
// }
  
</script>
<button id="print" type="button" name="button">Print</button>
<button id="email" type="button" name="button">email</button>

<div id="schedule" class="">
  <h1>test</h1>
</div>