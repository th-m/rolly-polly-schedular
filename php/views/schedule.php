<?php 
  include("../functions.php"); 
  date_default_timezone_set('Australia/Melbourne');
  $date = date('m/d/Y h:i:s a', time());
  // echo "tester";
  // $d = date;
  
  // echo $date;
  $qry = "SELECT * FROM staff_members";
  $teachers= sql_query($qry);
  
  date_default_timezone_set("America/Denver");
  $sunday = strtotime('Sunday');
  $d = date('Y-m-d', $sunday);
  // echo $d;
  $qry = "SELECT * FROM schedule_next_week WHERE date = '$d'";
  $schedule= sql_query($qry);
  if(isset($schedule[0]) && $schedule[0] != ""){
    $schedule = json_encode($schedule);
  }else{
    $schedule = "false";
    // $schedule_blob = "false";
  }
  // $schedule= json_encode($schedule);
  
  // echo"test";
  // echo $schedule;
  // print_r($schedule);
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
  if(sched && sched != "null"){
    writeSchedule();
    // console.log(sched);
    // schedOBJ = JSON.parse(sched);
    // console.log(schedOBJ);
    // setTimeout(addRowsFromDB, 5); // timing is funny here. set a time out to wait for modal before firing function. 
  }
  // TODO loop through schedule
  // if data look at staff_id for row and day for day
  // parse json blob for html.
  function writeSchedule(){
    sched.forEach(x =>{
      console.log(x);
      // console.log(JSON.parse(x.json_blob));
      let string;
      let div = document.querySelector("tbody #teacher_"+x.staff_id+" [data-day='"+x.dow+"']");
      console.log(div);
      JSON.parse(x.json_blob).forEach(j =>{
        console.log(j);
        p = document.createElement("p");
      //   p.innerHTML = j.room +" "+ j.start+"-"+j.stop;
        // div.appendChild(p);
      //   // string+= j.room +" "+ j.start+"-"+j.stop;
      });
      // x.staff_id
      // x.dow
    });
  }
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
			<td><?=$teacher['title']?></td>
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