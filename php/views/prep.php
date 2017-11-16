<?php 
  include("../functions.php"); 
  
  $qry = "SELECT * FROM rooms";
  $rooms= sql_query($qry);
   date_default_timezone_set("America/Denver");
   $sunday = strtotime('Sunday');
  $d = date('Y-m-d', $sunday);
  $qry = "SELECT json_blob FROM kids_next_week WHERE date = '$d'";
  // echo $qry;
  $prepBlob= sql_query($qry);
  if(isset($prepBlob[0]['json_blob']) && $prepBlob[0]['json_blob'] != ""){
    $json_blob = json_encode($prepBlob[0]['json_blob']);
  }else{
    $json_blob = "false";
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
     /*height: 35px;*/
     padding: 0px;
     border-right: 1px solid #e6e6e6;
   }
   .wrapper table tbody tr td:last-child{
     border-right: none;
   }
   .wrapper table tbody tr td  div{
     width: 100%;
     height: 35px;
   }
   .wrapper table tbody tr td .hour{
     text-align: center;
      border-bottom: 1px solid #e6e6e6;
   }
   .wrapper table tbody tr td .hour:hover{
     background-color: #eeeeee;
   }
   .wrapper table tbody tr td .hour_label{
        text-align: center;
   }
   .wrapper table tbody tr td .hour_label span{
     position: relative;
     top:4px;
   }
   .highlighted {
      background-color:#969696;
    }
    .selected-hours .hour{
      background-color: red !important;
    }
    .rooms_list{
      display: grid;
       grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
    }
    .rooms_list span{
      text-align: center;
      padding: 14px 0px;
      margin: 6px 6px;
      background-color: #eaeaea;
      border-radius: 7px;
    }
    .rooms_list .selected{
      background-color: #c1c1c1;
    }
    .rooms_list span:hover{
      background-color: #c1c1c1;
    }
 </style>
 <script type="text/javascript">
   var prepOBJ = {};
   var jsonBlob = <?=$json_blob?>;
   var weekDays = ['monday','tuesday','wednesday','thursday','friday'];
   
   if(jsonBlob && jsonBlob != "null"){
     prepOBJ = JSON.parse(jsonBlob);
   }else{
     setUpBlankPrepObj();
   }
   
   function setUpBlankPrepObj(){
     document.querySelectorAll(".rooms_list span").forEach(x => {
        prepOBJ[x.dataset.roomid] = {};  
        weekDays.forEach(xx =>{
          prepOBJ[x.dataset.roomid][xx] = {};
          for(i=0;i<13;i++){
            prepOBJ[x.dataset.roomid][xx][7+i] = 0;
          }
        });
     });
   }
  
   function getClassPrepData(classId){
     weekDays.forEach(wd =>{
       weekDiv = document.querySelector("tbody tr [data-day='"+wd+"']");
       weekDiv.innerHTML = "";
        Object.keys(prepOBJ[classId][wd]).forEach(h => {
          hr = document.createElement('div');
          hr.className += "hour";
          hr.dataset.hour = h;
          hr.dataset.kids = prepOBJ[classId][wd][h];
          hr.innerHTML = prepOBJ[classId][wd][h]
          weekDiv.append(hr);
        }); 
     });
     clickDragger();
   }

   document.querySelector(".rooms_list span:first-child").className += "selected";
   getClassPrepData(document.querySelector(".rooms_list span:first-child").dataset.roomid);
    
   document.querySelectorAll(".rooms_list span").forEach(x => {
      x.addEventListener("click", function(){
        document.querySelectorAll(".rooms_list span").forEach(xx => {xx.className = ""});
        x.className += "selected";
        getClassPrepData(x.dataset.roomid);
      });
   });
   
   function updateDB(){
     // console.log("fired update DB")
     let classId = document.querySelector(".rooms_list .selected").dataset.roomid;
     prepOBJ[classId]={};
     
     document.querySelectorAll("tbody tr .day").forEach(x =>{
       day = x.dataset.day;
       prepOBJ[classId][day]={};
       $(x).children('.hour').each(function () {
           num = this.dataset.kids?this.dataset.kids:0; 
           prepOBJ[classId][day][this.dataset.hour] = num;
       });
     });
     routerPost('update_prep_json',{'json_blob':prepOBJ}, function(data){
       console.log(data);
     });
   }
    
   function clickDragger() {
     var isMouseDown = false;
     var limitDay;
     var divCells = [];
     var groupId = 0;
    
     $("table td .hour")
       .mousedown(function () {
         divCells=[];
         isMouseDown = true;
         $(this).toggleClass("highlighted");
         limitDay = $(this).parent().data('day');
         divCells.push($(this));
         return false; // prevent text selection
       })
       .mouseover(function () {
         if (isMouseDown) {
           if($(this).parent().data('day') == limitDay){
             $(this).toggleClass("highlighted");
            divCells.push($(this));
           }
         }
       }).mouseup(function () {
         swal({
          title: 'How many kids between this time',
          input: 'number',
          confirmButtonText: 'Submit',
        
        }).then(function (kids) {
          // console.log(divCells);
          divCells.forEach(x => {
            x[0].classList.remove("highlighted");
            x[0].setAttribute('data-kids', kids);
            x[0].innerHTML = kids;
          });
          updateDB();
        })
            
           isMouseDown = false;
           limitDay="";
           groupId ++;
        })
       .bind("selectstart", function () {
         return false; // prevent text selection in IE
       });
   };
   
 </script>
 <div class="wrapper">
   
   <table>
     <thead>
       <tr>
         <th>Hours</th>
         <th>Monday</th>
         <th>Tuesday</th>
         <th>Wednesday</th>
         <th>Thursday</th>
         <th>Friday</th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <td>
           <div class="hour_label"><span>7 </span></div>
           <div class="hour_label"><span>8 </span></div>
           <div class="hour_label"><span>9 </span></div>
           <div class="hour_label"><span>10 </span></div>
           <div class="hour_label"><span>11 </span></div>
           <div class="hour_label"><span>12 </span></div>
           <div class="hour_label"><span>13 </span></div>
           <div class="hour_label"><span>14 </span></div>
           <div class="hour_label"><span>15 </span></div>
           <div class="hour_label"><span>16 </span></div>
           <div class="hour_label"><span>17 </span></div>
           <div class="hour_label"><span>18 </span></div>
           <div class="hour_label"><span>19 </span></div>
         </td>
         <td class="day" data-day="monday"></td>
         <td class="day" data-day="tuesday"></td>
         <td class="day" data-day="wednesday"></td>
         <td class="day" data-day="thursday"></td>
         <td class="day" data-day="friday"></td>
       </tr>
     </tbody>
   </table>
   <div class="rooms_list">
     <?php foreach ($rooms as $room) { 
        $cwd = getcwd();
        $imgPath = "http://schedular.xyz/imgs/".$room['img'];
       ?>
       
       <span data-roomid="<?=$room['id']?>"><?=$room['title']?>  <img src="<?=$imgPath?>" style="width:20px; height:20px;" alt=""></span>
     <?php } ?>
  
   </div>
 </div>