<?php 
  include("../../functions.php"); 
  date_default_timezone_set("America/Denver");
  $sunday = strtotime('Sunday');
  $d = date('Y-m-d', $sunday);
  $qry = "SELECT json_blob FROM schedule_next_week WHERE dow = '{$_POST['day']}' AND date = '$d' AND staff_id = {$_POST['teacherId']};";
  $schedule = sql_query($qry);
  $schedule_blob = json_encode($schedule[0]['json_blob']);
  if(isset($schedule[0]['json_blob']) && $schedule[0]['json_blob'] != ""){
    $schedule_blob = json_encode($schedule[0]['json_blob']);
  }else{
    $schedule_blob = "false";
  }
  $qry = "SELECT * FROM staff_members WHERE id = {$_POST['teacherId']};";
  $teacher_data = sql_query($qry);
  $teacher_data = json_encode($teacher_data[0]);
?>
<style media="screen">
  #dailySchedule div i{
    position: relative;
    top:5px;
    right: 10px;
    color:#6e6e6e;
  }
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
  var teacherData = <?=$teacher_data?>;
  var eventsList;
  var roomsList

  if(teacherData.events_list){
    if(teacherData.events_list[0] == '[' && teacherData.events_list[teacherData.events_list.length-1] == ']'){
      eventsList = JSON.parse(teacherData.events_list);
    }else{
      eventsList = [teacherData.rooms_list];
    }
  }

  if(teacherData.rooms_list){
    if(teacherData.rooms_list[0] == '[' && teacherData.rooms_list[teacherData.rooms_list.length-1] == ']'){
      roomsList = JSON.parse(teacherData.rooms_list);
    }else{
      roomsList = [teacherData.rooms_list];
    }
  }

  if(scheduleBlob && scheduleBlob != "null"){
    scheduleOBJ = JSON.parse(scheduleBlob);
    setTimeout(addRowsFromDB, 5); // timing is funny here. set a time out to wait for modal before firing function. 
  }
  
  function addRowsFromDB(){
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
          if(j.className != "btn-group bootstrap-select room"){
            var string = j.value;
            var re = new RegExp("^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$");
            if (re.test(string)) {
            } else {
                valid = false;
            }
            teachersSchedule[x.id][j.getAttribute('name')] = j.value;  
          }else{
            teachersSchedule[x.id]['room'] = j.firstChild.title;  
          }
        });
      }
    });
    if(valid){
      // console.log(teachersSchedule);
      routerPost('update_teacher_schedule_json',{'json_blob':teachersSchedule, 'dow':'<?=$_POST['day']?>','staff_id':'<?=$_POST['teacherId']?>'});  
    }
  });
  $('#dailySchedule').on('focusout', "input", function(){
    // console.log($(this).val()); 
    var time = $(this).val();
    if(time.length < 3 || time.length > 5){
      $(this).focus();
      return false;
    }
    if(!time.includes(":")){
      var time = time.slice(0, time.length-2) + ":" + time.slice(time.length-2);
      $(this).val(time);
      // return false;
    }
    // timeFormatted = $(this).val()[$(this).val()-3]
  });
  $('#dailySchedule').on('click', 'i', function(){
    $(this).parent().remove();
    console.log($(this).parent());
    console.log("clicke");
  });
  function addRow(e, startVal = null, stopVal = null, roomVal = null){
    topdiv = document.createElement("div");
    del = document.createElement("i");
    del.className = "fa fa-times fa-lg";
    // 
    topdiv.appendChild(del);
    
    div = document.createElement("div");
    //<i class="fa fa-camera-retro fa-lg"></i>
    
    room = document.createElement("select");
    room.type = "text";
    room.className = "room selectpicker";
    room.placeholder = "what class";
    room.name = "room";
    // 
    if(roomsList){
      optgrp = document.createElement("optgroup");
      optgrp.label = "rooms";
      roomsList.forEach(x =>{
          opt = document.createElement("option");
          opt.value = x;
          opt.innerHTML = x;
          
          // console.log(x);
          optgrp.appendChild(opt);
      });
      room.appendChild(optgrp);
    }
    if(eventsList){
      optgrp = document.createElement("optgroup");
      optgrp.label = "duties";
      eventsList.forEach(x =>{
          opt = document.createElement("option");
          opt.value = x;
          opt.innerHTML = x;
            // console.log(x);
          optgrp.appendChild(opt);
      });
      room.appendChild(optgrp);
    }
    div.appendChild(room);
    
    div.className = "schedule_data";
    // console.log(form);
    div.id = form.childElementCount;
    // console.log(startVal);
    start = document.createElement("input");
    start.type = "text";
    start.placeholder = "start time";
    start.name = "start";
    start.className = "start form-control";
    start.value = startVal?startVal:"";
    div.appendChild(start);
    
    stop = document.createElement("input");
    stop.type = "text";
    stop.placeholder = "stop time";
    stop.name = "stop";
    stop.className = "stop form-control";
    stop.value = stopVal?stopVal:"";
    div.appendChild(stop);
    
    topdiv.appendChild(div);
    // room.value = roomVal;
    
    
    form.appendChild(topdiv);
    $('.selectpicker').selectpicker();
    
  }
  document.querySelector(".add_row").addEventListener('click', addRow);

</script>
<div class="modal-body">
  <form id="dailySchedule" action="javascript:void(0);"  class="form-group">
  
  </form>
</div>  
<div class="modal-footer">
  <button type="button" class="btn btn-success add_row"> Add </button>
  <button type="button" class="btn btn-primary save_schedule">Save changes</button>
</div>

