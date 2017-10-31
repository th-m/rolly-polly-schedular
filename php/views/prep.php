<?php 
  include("../functions.php"); 
  
  $qry = "SELECT * FROM rooms";
  $rooms= sql_query($qry);

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
    .rooms_list span:hover{
      background-color: #c1c1c1;
    }
 </style>
 <script type="text/javascript">
 
   document.querySelectorAll("tbody tr .day").forEach(x =>{
     for(i=0;i<13;i++){
       hr = document.createElement('div');
       hr.className += "hour";
       x.append(hr);
     }
   });
   
  //  document.querySelectorAll(".day .hour").forEach(x =>{
  //    console.log("Adding functions");
  //    x.addEventListener('onMouseDown', changeColor);
  //  });
   $(function () {
     var isMouseDown = false;
     var limitDay;
     var divCells = [];
     var groupId = 0;
    //  var kidCount = 0;
     $("table td .hour")
       .mousedown(function () {
         killSpans();
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
            console.log($(this));
            divCells.push($(this));
           }
         }
       }).mouseup(function () {
         swal({
          title: 'How many kids between this time',
          input: 'number',
          confirmButtonText: 'Submit',
          // showLoaderOnConfirm: true,
          // preConfirm: function (email) {
          //   return new Promise(function (resolve, reject) {
          //     setTimeout(function() {
          //       if (email === 'taken@example.com') {
          //         reject('This email is already taken.')
          //       } else {
          //         resolve()
          //       }
          //     }, 2000)
          //   })
          // },
          // allowOutsideClick: false
        }).then(function (kids) {
          divCells.forEach(x => {
            x[0].classList.remove("highlighted");
            x[0].setAttribute('data-kids', kids);
            // x[0].setAttribute('data-kids', kids);
          });
        })
            // console.log(divCells);
            // var newSpan = $('<span/>').addClass('selected-hours');
            // var Cells = divCells.slice();
            // console.log(Cells);
            // frontOverLap = checkFront(divCells, 0);
            // var cnt = $(".remove-just-this").contents();
            // $(".remove-just-this").replaceWith(cnt);
            // 
            // if(divCells[0].parent().is("span")){
            //   moveAfter(divCells, 0);
            // }
            // 
            // if(divCells[divCells.length-1].parent().is("span")){
            //   moveBefore(divCells, divCells.length-1);
            // }
            // // clearBack(divCells, divCells.length-1);
            // createSpan(divCells);
            // divCells.forEach(x => {
            //   x[0].setAttribute('data-group', groupId);
            // });
            // createSpans();
            // cleanEmptySpans();
            // $(divCells[0]).before(newSpan);
            // divCells.forEach(x => {newSpan.append(x);});
           isMouseDown = false;
           limitDay="";
           divCells=[];
           groupId ++;
        })
       .bind("selectstart", function () {
         return false; // prevent text selection in IE
       });
      //  function moveAfter(arr, i){
      //    if(arr[i].parent().is("span") && arr.length-1 != i){
      //      arr[i].parent().after(arr[i]);
      //      clearFront(arr,i+1);
      //    }else{
      //      return i
      //    }
      //  }
      //  function moveBefore(arr,i){
      //    if(arr[i].parent().is("span") && i != 0){
      //      arr[i].after(arr[i].parent());
      //     //  arr[i].parent().before(arr[i]);
      //      clearBack(arr,i-1);
      //    }else{
      //      return
      //    }
      //  }
      function killSpans(){
        arr = document.querySelectorAll('.selected-hours');
        arr.forEach(x =>{
          var cnt = $(x).contents();
          $(x).replaceWith(cnt);
        });
        
      }
      //TODO instead of create a span around the div we will just insert the number of kids selected for that time.
      // we will then show a shade of color depending on the number of kids selected
      //  function createSpans(){
      //    for(i=0;i<=groupId;i++){
      //      arr = document.querySelectorAll('*[data-group="'+i+'"]');
      //      let newSpan = $('<span/>').addClass('selected-hours');
      //      $(arr[0]).before(newSpan);
      //      arr.forEach(x => {newSpan.append(x);});
      //    }
      //  }
      //  function cleanEmptySpans(){
      //    document.querySelectorAll('.selected-hours').forEach(x =>{
      //      if(x.children.length == 0){
      //        x.remove();
      //        console.log("removing this div");
      //        
      //      }
      //    })
      //  }
      //  //$toolbar.parent().after($toolbar);
    //if one is selected
    // check if it is in a parent selected-hours.
    // if it is in a parent selected hours. pop it out.
    // check if 
    //  $(document).mouseup(function () {
    //       divCells.push($(this));
    //       var newSpan = $('<span/>').addClass('selected-hours');
    //       for(i=0;i<divCells.length;i++){
    //         divCells
    //         if(i==0){
    //           $(divCells[i]).before(newSpan);
    //         }else{
    //           newSpan.append(divCells[i]);
    //         }
    //       }
    //      isMouseDown = false;
    //      limitDay="";
    //      divCells=[];
    //   });
   });
   
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
         <td class="day" data-day="wedday"></td>
         <td class="day" data-day="thursday"></td>
         <td class="day" data-day="friday"></td>
       </tr>
     </tbody>
   </table>
   <div class="rooms_list">
     <?php foreach ($rooms as $room) { ?>
       <span data-roomid="<?=$room['id']?>"><?=$room['title']?></span>
     <?php } ?>
  
   </div>
 </div>