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
  // console.log("/////schedule_planned//////");
console.log(schedule_planned);
  // staffMembers = <?=$teachersJson?>;
  kidsNextWeek = JSON.parse(<?=$kids_next_week?>);
  // console.log("/////kidsNextWeek//////");
console.log(kidsNextWeek);
  
  rooms_list = <?=$rooms_list?>;
  // console.log("/////rooms_list//////");
console.log(rooms_list);
// console.log(rooms_list);
  var prepBlob = JSON.parse(<?=$prepBlob?>);
  // console.log("//////prepBlob/////////");
console.log(prepBlob);
  var busyHours = {};
  var weekDays = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
  
  // weekDays.forEach(x => {
  //   console.log(x);
  // });
  function squashListings(listedTimes, squash=true){
    if(!squash)return true;
    squash = false;
    listedTimes.forEach((i, ii)=>{
      listedTimes.forEach((j, ji)=>{
        if(i[1].toString() == j[0].toString()){
          listedTimes[ii][1] = listedTimes[ji][1];
          listedTimes.splice(ji,1);
          squash = true;
        }
      });
    });
    squashListings(listedTimes, squash)
  }
  
  function convertToDecimal(listedTimes){
    listedTimes.map(x=>{
      return x[0]+x[1]*(.1/6);
    })
  }
  //looop through kids_next_week
  function checkHours(){
    Object.keys(prepBlob).forEach(x=>{
      // console.log(prepBlob.x);
      
      // each top level prepBlob key is a room id
      // find matching room 
      ri = rooms_list.find(function(j){
        return j.id == x;
      })
    
    
      // looop through weekdays
      weekDays.forEach(w =>{
        // console.log("ri.max_students_per_teacher");
        // console.log(ri.max_students_per_teacher);
        
        listedTimes = []
        $("td.day[data-day='" + w + "'] p span[data-roomtitle='" + ri.title + "']").each((spI,span) =>{ 
          listing = $(span).parent();
          startTime = listing.children(".start_time").html().split(":");
          endTime = listing.children(".end_time").html().split(":");
          listedTimes.push([startTime,endTime]);
        });
        
        //TODO flatten times
        listedTimes.forEach(lt =>{
            console.log(lt);
        });
        
        if(listedTimes.length){
      
          squashListings(listedTimes);
          console.log("after listedTimes");
          console.log(listedTimes);
          listedTimes.forEach((lt,lti)=>{
            lt.forEach((ltx,ltxi) =>{
              listedTimes[lti][ltxi] = parseInt(ltx[0])+(parseInt(ltx[1])*(.1/6));
            })
          }); 
        
          Object.keys(prepBlob[x][w.toLowerCase()]).forEach(h =>{
          
          });
        }
    
      
      });
    // console.log(x)
    });
  }
  
  if(schedule_planned && schedule_planned != "null"){
    writeSchedule();
    checkHours();
  }
  
  function writeSchedule(){
    schedule_planned.forEach(x =>{
      let string;
      let div = document.querySelector("tbody #teacher_"+x.staff_id+" [data-day='"+x.dow+"']");
      if(div){
        JSON.parse(x.json_blob).forEach(j =>{
          p = document.createElement("p");
          // j.room
          console.log(j.room.replace(" ", "_"));
          p.innerHTML = "<span class='room_title' data-roomtitle='"+j.room.replace(" ", "_")+"'>"+j.room +"</span> "+ "<span class='start_time'>"+ j.start+"</span>-<span class='end_time'>"+j.stop+"</span>";
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
          let minuteDiff = ((left[1] - right[1])*(.1/6));
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