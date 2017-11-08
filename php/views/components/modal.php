<?php 
  include("../../functions.php"); 
  date_default_timezone_set("America/Denver");
  $sunday = strtotime('Sunday');
  $d = date('Y-m-d', $sunday);
  $qry = "SELECT json_blob FROM schedule_next_week WHERE dow = '{$_POST['day']}' AND date = '$d' AND staff_id = {$_POST['teacherId']};";
  // echo $qry;
  // $qry = "SELECT id FROM schedule_next_week WHERE date = '$d' AND dow = '{$json["data"]["dow"]}' AND staff_id = '{$json["data"]["staff_id"]}'; ";
  $schedule = sql_query($qry);
  // print_r($schedule);
  $schedule_blob = json_encode($schedule[0]['json_blob']);
  if(isset($schedule[0]['json_blob']) && $schedule[0]['json_blob'] != ""){
    $schedule_blob = json_encode($schedule[0]['json_blob']);
  }else{
    $schedule_blob = "false";
  }
  // echo $d;
  // echo $_POST['day'];
  echo $_POST['teacherId'];
  
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
    margin: auto;
  }
</style>
<script type="text/javascript">
  var teachersSchedule = {};
  var scheduleBlob = <?=$schedule_blob?>;
  
  if(scheduleBlob && scheduleBlob != "null"){
    scheduleOBJ = JSON.parse(scheduleBlob);
    setTimeout(addRowsFromDB, 5); // timing is funny here. set a time out to wait for modal before firing function. 
  }
  
  function addRowsFromDB(){
    console.log('firled');
    scheduleOBJ.forEach(x => {
      addRow(null, x.start, x.stop, x.room);
    });
  }
  
  form = document.querySelector("form");
  
  document.querySelector(".modal-footer .btn-primary").addEventListener('click', function(){
    valid = true;
    form.childNodes.forEach(x =>{
      if(x.id != undefined && x.id != null){
        teachersSchedule[x.id]={}
        x.childNodes.forEach(j =>{
          if(j.className != "room"){
            var string = j.value;
            var re = new RegExp("^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$");
            if (re.test(string)) {
                console.log("Valid");
            } else {
                console.log("Invalid");
                valid = false;
            }
          }
          teachersSchedule[x.id][j.className] = j.value;  
        });
      }
    });
    if(valid){
      console.log(teachersSchedule);
      routerPost('update_teacher_schedule_json',{'json_blob':teachersSchedule, 'dow':'<?=$_POST['day']?>','staff_id':'<?=$_POST['teacherId']?>'});  
    }
    // console.log(data);
  });
  // });
  
  function addRow(e, startVal = null, stopVal = null, roomVal = null){
    div = document.createElement("div");
    div.className = "schedule_data";
    console.log(form);
    div.id = form.childElementCount;
    // console.log(startVal);
    start = document.createElement("input");
    start.type = "text";
    start.placeholder = "start time";
    start.className = "start";
    start.value = startVal?startVal:"";
    div.appendChild(start);
    
    stop = document.createElement("input");
    stop.type = "text";
    stop.placeholder = "stop time";
    stop.className = "stop";
    stop.value = stopVal?stopVal:"";
    div.appendChild(stop);
    
    room = document.createElement("input");
    room.type = "text";
    room.className = "room";
    room.placeholder = "what class";
    room.value = roomVal;
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

