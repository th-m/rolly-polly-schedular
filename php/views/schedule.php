<?php 
  include("../functions.php"); 
  date_default_timezone_set('Australia/Melbourne');
  $date = date('m/d/Y h:i:s a', time());
  $qry = "SELECT * FROM staff_members";
  $teachers= sql_query($qry);
  $teachersJson = json_encode($teachers);
  date_default_timezone_set("America/Denver");
  $sunday = strtotime('Sunday');
  $d = date('Y-m-d', $sunday);
  
  
  $qry = "SELECT * FROM kids_next_week WHERE date = '$d'";
  $kids_next_week = sql_query($qry);
  $kids_next_week = json_encode($kids_next_week[0]['json_blob']);
  
  
  $qry = "SELECT schedule_next_week.*, staff_members.* FROM schedule_next_week 
  LEFT JOIN staff_members ON staff_members.id=schedule_next_week.staff_id WHERE date =  '$d';";
  $schedule_planned = sql_query($qry);
  // echo "$qry";
  if(isset($schedule_planned[0]) && $schedule_planned[0] != ""){
    $schedule_planned_json = json_encode($schedule_planned);
  }else{
    $schedule_planned_json = "false";
  }
  
  $qry = "SELECT * FROM rooms";
  $rooms_list = sql_query($qry);
  $rooms_list = json_encode($rooms_list);
  
  $qry = "SELECT json_blob FROM kids_next_week WHERE date = '$d'";
  // echo $qry;
  $prepBlob= sql_query($qry);
  if(isset($prepBlob[0]['json_blob']) && $prepBlob[0]['json_blob'] != ""){
    $prepBlob = json_encode($prepBlob[0]['json_blob']);
  }else{
    $prepBlob = "false";
  }
  // print_r($schedule_planed);

  // print_r($kids_next_week[0]['json_blob']);
?>
<style media="screen">
  .wrapper table{
    width:100%;
  }
  .wrapper thead tr{
    border-bottom:  1px solid #e6e6e6;
  }
  .wrapper thead tr th{
   height: 35px;
   /*width:25%;*/
   text-align: center;
  }
  .wrapper table tbody tr td * {
  z-index: 0;
  }
  .wrapper table tbody tr td{
   height: 55px;
   padding: 0px;
   border-right: 1px solid #e6e6e6;
   border-bottom: 1px solid #e6e6e6;
   text-align: center;
   z-index: 9999;
  }
  .wrapper table tbody tr td:first-child{
    text-align: center;
  }
  .wrapper table tbody tr td:first-child span{
    font-size: 10px;
  }
  .wrapper table tbody tr td:last-child{
   border-right: none;
  }
  .action_list{
    display: grid;
     grid-template-columns: 1fr 1fr;
  }
  .action_list span{
    text-align: center;
    padding: 14px 0px;
    margin: 6px 6px;
    background-color: #eaeaea;
    border-radius: 7px;
  }
  .action_list span:hover{
    background-color: #c1c1c1;
  }
</style>
<script type="text/javascript">
// window.onload = function(){
$(function() {
  // sched = <?=$schedule?>;
  schedule_planned = <?=$schedule_planned_json?>;
  console.log("schedule_planned");
  console.log(schedule_planned);
  staffMembers = <?=$teachersJson?>;
  kidsNextWeek = JSON.parse(<?=$kids_next_week?>);
  rooms_list = <?=$rooms_list?>;
  console.log(rooms_list);
  var prepBlob = JSON.parse(<?=$prepBlob?>);
  console.log("prepBlob");
  console.log(prepBlob);
  var busyHours = {};
  var weekDays = ['monday','tuesday','wednesday','thursday','friday'];
  
  weekDays.forEach(x => {
    console.log(x);
  });
  
  // looop through kids_next_week
  Object.keys(prepBlob).forEach(x=>{
    // console.log(prepBlob.x);
    
    // find matching room 
    ri = rooms_list.find(function(j){
      return j.id == x;
    })
    
    console.log(ri)
    
    // looop through weekdays
    weekDays.forEach(w =>{
      console.log("ri.max_students_per_teacher");
      console.log(ri.max_students_per_teacher);
      // check each hour in prep for each day
      // TODO: Looop through class here then hours
      Object.keys(prepBlob[x][w]).forEach(h =>{
        // if no kids that hour skip
        if(prepBlob[x][w][h] != 0){
          if(ri.max_students_per_teacher){
            var neededTeachers = Math.ceil(prepBlob[x][w][h]/ri.max_students_per_teacher);
          }else{
            var neededTeachers = 1;
          }
          console.log("hour");
          console.log(h);
          console.log("prepBlob[x][w][h]");
          console.log(prepBlob[x][w][h]);
          console.log("neededTeachers")
          console.log(neededTeachers)
          // if kids are schedule that hour match it scheduled teachers
          matchDaysArray = [];
          Object.keys(schedule_planned).forEach(sp =>{
          
            if(schedule_planned[sp].dow.toUpperCase() == w.toUpperCase()){
              spw = schedule_planned[sp];
              matchDaysArray.push(spw);
            }
          });
          // check rooms in schedule planned
          if(matchDaysArray){
            // console.log("matchDaysArray");
            // console.log(matchDaysArray);
            matchDaysArray.forEach(mda=>{
              mdaJson = JSON.parse(mda.json_blob);
              mdaJson.forEach(mdaj => {
                mdaj.room = mdaj.room.replace(" ", "_");
              
                
                if(ri.title.toUpperCase() == mdaj.room.toUpperCase()){
                  console.log("mdaj");
                  console.log(mdaj);
                  console.log("hour");
                  console.log(h);
                
                }
              });
            });
          }
        } 
      });

    });
    
    
    // console.log(x)
  });
  // for each day  check each class.
  // if there is a teacher for each student hide img else show it
  // Object.keys(kidsNextWeek).forEach(x=>{
  //   Object.keys(kidsNextWeek[x]).forEach(j=>{
  //     classDay = x +"_"+ j;
  //     busyHours[classDay] = [0,0];
  //     Object.keys(kidsNextWeek[x][j]).forEach(xj=>{
  //       if(kidsNextWeek[x][j][xj] > busyHours[classDay][1]){
  //          busyHours[classDay]=[xj,kidsNextWeek[x][j][xj]]
  //       }
  //     });
  //   });
  // });
  // console.log("busyHours");
  // console.log(busyHours);
  if(schedule_planned && schedule_planned != "null"){
    writeSchedule();
  }
  
  function writeSchedule(){
    schedule_planned.forEach(x =>{
      let string;
      let div = document.querySelector("tbody #teacher_"+x.staff_id+" [data-day='"+x.dow+"']");
      if(div){
        JSON.parse(x.json_blob).forEach(j =>{
          p = document.createElement("p");
          p.innerHTML = "<span class='room_title'>"+j.room +"</span> "+ "<span class='start_time'>"+ j.start+"</span>-<span class='end_time'>"+j.stop+"</span>";
          div.appendChild(p);
        });
      }
    });
  }

  document.querySelectorAll('.wrapper table tbody tr .day').forEach(x => {
    x.addEventListener('click',triggerModal);
  });
  
  function triggerModal(e){
    $td = $(e.target);
    if(!$td.is("td")){
      $td = $(e.target).parents("td")
    }
    day = $td.data().day;
    teacherId = $td.parent().attr('id');
    teacherName = $("#"+teacherId+" td:first-child").html();
    title = day+" - "+teacherName;
    $("#editTeacherLabel").html(title);
    tempData = {
      view: "components/modal",
      day: day,
      teacherId: teacherId.replace("teacher_", "")
    }
    renderView(tempData.view, tempData, "modal_body");
    $('#teacherEditModal').modal();
  }
  printBtn = document.querySelector('#print');
  printBtn.addEventListener('click',function(){
    scheduleDiv = document.querySelector('#schedule');
    scheduleDiv.print();
  });
  
  emailBtn = document.querySelector('#email');
  emailBtn.addEventListener('click',function() {
    routerPost('emailer');
  });
  document.querySelectorAll('table tbody tr').forEach(x =>{
      weeklyHoursSpan = document.querySelector("#"+x.id+" .weekly_hours");
      scheduledHours = parseInt(weeklyHoursSpan.innerHTML);
    $(x).children().each(function(j,i){
      $(i).children("p").each(function(jj, ii){
        let startTime =  $(ii).find(".start_time").html();
        let endTime =  $(ii).find(".end_time").html();
        if(startTime){
          let left = startTime.split(":");
          let right = endTime.split(":");
          let hourDiff = left[0] - right[0];
          let minuteDiff = ((left[1] - right[1])*(10/6))*.01;
          scheduledHours += (hourDiff + minuteDiff);
          weeklyHoursSpan.innerHTML = scheduledHours;
        }
      })
    });
  });
});
</script>
<div class="wrapper">
	<table>
    <thead>
			<tr>
				<th>Teachers</th>
				<th data-headday="monday">Monday</th>
				<th data-headday="tuesday">Tuesday</th>
				<th data-headday="wednesday">Wednesday</th>
				<th data-headday="thursday">Thursday</th>
				<th data-headday="friday">Friday</th>
			</tr>
    </thead>
    <tbody>
      
    <?php foreach ($teachers as $teacher) { ?>
    <tr id="teacher_<?=$teacher['id']?>" class="teacher_schedule">
			<td><?=$teacher['title']?> <br> 
        <span>hrs: &nbsp;<span class="weekly_hours"><?=$teacher['weekly_hours']?></span></span>
        <br> 
        <span>rooms: &nbsp;<span class="rooms"><?=getImgIconsforTeacher($teacher['id'])?></span></span>
      </td>
			<td class="day" data-day="Monday"></td>
			<td class="day" data-day="Tuesday"></td>
			<td class="day" data-day="Wednesday"></td>
			<td class="day" data-day="Thursday"></td>
			<td class="day" data-day="Friday"></td>
		</tr>
    <?php } ?>
  </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="teacherEditModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTeacherLabel">Modal title</h5>
      </div>
      <div id="modal_body">
      </div>
    </div>
  </div>
</div>

<div class="action_list">
  <span id="print" >Print</span>
  <span id="email" >email</span>
</div>