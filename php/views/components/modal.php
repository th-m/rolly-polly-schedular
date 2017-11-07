<?php 
  include("../../functions.php"); 
  date_default_timezone_set("America/Denver");
  $sunday = strtotime('Sunday');
  $d = date('Y-m-d', $sunday);
  $qry = "SELECT json_blob FROM schedule_next_week WHERE dow = '{$_POST['day']}' AND date = '$d' AND staff_id = {$_POST['teacherId']};";
  // echo $qry;
  $schedule = sql_query($qry);
  // print_r($schedule);
  $schedule_blob = json_encode($schedule[0]['json_blob']);
  
  // echo $d;
  // echo $_POST['day'];
  // echo $_POST['teacherId'];
  
  // print_r($schedule);
  // print_r($_POST['teacherId']);
  // print_r($_POST['day']);
  // {$_POST['day']}
  // {$_POST['teacherId']}
  // $rowId = isset($_POST['rowId']) ? $_POST['rowId']: 1;
  // $qry = "SELECT * FROM {$_POST['day']} WHERE id = $rowId";  
  // $table_info = sql_query($qry);
  // $dontShowColumns = ['id', 'company_id'];
  // $columns = array_diff(array_keys($table_info[0]), $dontShowColumns);
?>
<style media="screen">
  .schedule_data{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 10px;
  }
  .schedule_data input{
    font-size: 11px;
  }
</style>
<script type="text/javascript">
  var model = {
    id:{
      room:"",
      start:"",
      stop:"",
    }
  }
  var scheduleBlob = <?=$schedule_blob?>;
  
  form = document.querySelector("form");
  
  console.log(scheduleBlob);
  document.querySelector(".modal-footer .btn-primary").addEventListener('click', function(){
    console.log("hi");
    // console.log(form);
    form.childNodes.forEach(x =>{
      console.log(x)
    });
    // document.querySelector("#modal_body form");
  });
  
  function addRow(){
    div = document.createElement("div");
    div.className = "schedule_data";
    console.log(form);
    div.id = form.childElementCount;
    
    start = document.createElement("input");
    start.type = "text";
    start.placeholder = "start time";
    start.className = "start";
    div.appendChild(start);
    
    stop = document.createElement("input");
    stop.type = "text";
    stop.placeholder = "stop time";
    stop.className = "stop";
    div.appendChild(stop);
    
    room = document.createElement("input");
    room.type = "text";
    room.className = "room";
    room.placeholder = "what class";
    div.appendChild(room);
    
    form.appendChild(div);
  }
  
  document.querySelector(".add_row").addEventListener('click', addRow);

</script>
<div class="modal-body">
  <form  action="javascript:void(0);">
    
  </form>
</div>  
<div class="modal-footer">
  <button type="button" class="btn btn-success add_row"> Add </button>
  <button type="button" class="btn btn-primary save_schedule">Save changes</button>
</div>

