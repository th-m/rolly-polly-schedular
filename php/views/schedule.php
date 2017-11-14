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
  $qry = "SELECT * FROM schedule_next_week WHERE date = '$d'";
  $schedule= sql_query($qry);
  if(isset($schedule[0]) && $schedule[0] != ""){
    $schedule = json_encode($schedule);
  }else{
    $schedule = "false";
  }
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
  .wrapper table tbody tr td{
   height: 55px;
   padding: 0px;
   border-right: 1px solid #e6e6e6;
   border-bottom: 1px solid #e6e6e6;
   text-align: center;
  }
  .wrapper table tbody tr td:first-child{
    text-align: center;
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
  sched = <?=$schedule?>;
  staffMembers = <?=$teachersJson?>;
  console.log("staffMembers");
  console.log(staffMembers);
  if(sched && sched != "null"){
    writeSchedule();
  }
  function writeSchedule(){
    sched.forEach(x =>{
      console.log(x);
      let string;
      let div = document.querySelector("tbody #teacher_"+x.staff_id+" [data-day='"+x.dow+"']");
      console.log(div);
      if(div){
        
        JSON.parse(x.json_blob).forEach(j =>{
          console.log(j);
          p = document.createElement("p");
          p.innerHTML = j.room +" "+ j.start+"-"+j.stop;
          div.appendChild(p);
        });
      }
    });
  }

  document.querySelectorAll('.wrapper table tbody tr .day').forEach(x => {
    x.addEventListener('click',triggerModal);
  });
  
  function triggerModal(e){
    $d = $(e.target).data();
    day = $d.day;
    teacherId = $(e.target).parent().attr('id');
    teacherName = $("#"+teacherId+" td:first-child").html();
    title = teacherName+" - "+day;
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
    console.log("printintg");
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
      let string =  $(i).children().html();
      console.log(string);
      if(string){
        let sides = string.split("-");
        let left = sides[0].split(" ")[1].split(":");
        let right = sides[1].split(":");
        let hourDiff = left[0] - right[0];
        let minuteDiff = ((left[1] - right[1])*(10/6))*.01;
        scheduledHours += (hourDiff + minuteDiff);
        weeklyHoursSpan.innerHTML = scheduledHours;
      }
    });
  });
});
</script>
<div class="wrapper">
	<table>
    <thead>
			<tr>
				<th>Teachers</th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
			</tr>
    </thead>
    <tbody>
      
    <?php foreach ($teachers as $teacher) { ?>
    <tr id="teacher_<?=$teacher['id']?>" class="teacher_schedule">
			<td><?=$teacher['title']?> <br> 
        <span style="font-size:10px;">weekly hours:<span class="weekly_hours"><?=$teacher['weekly_hours']?></span></span>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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