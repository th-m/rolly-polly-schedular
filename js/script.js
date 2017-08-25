// function getTemplateTabs(callback = null){
//   templateObj['inbound_email_id'] = $('.controller_view #get_inbound_test').val();
//     $.ajax({
//       url: 'app/template_tabs.php',
//       type:'POST',
//       data: JSON.stringify({templateObj})
//     }).done(function(data) {
//       let json = $.parseJSON(data);
//       // console.log(json);
//       if(json.response == 'success'){
//         $('#template_tabs_nav').html(json.html);
//         if(callback != null){
//           callback();
//         }
//       }
//     });
// }

// function queryDB(data , callback = null){
//   values = {
//     'function': "db_query",
//     'data': data, // This expects a sql query. Which will return 
//   }
//   $.ajax({
//     url: 'php/router.php',
//     type:'POST',
//     data: JSON.stringify({values})
//   }).done(function(data) {
//     let json = $.parseJSON(data);
//     if(callback != null){
//       callback(json.response);
//       return true;
//     }
//     return json;
//   });
// }
// NOTE: this function will intereact with our php router
function routerPost(func, data = null, callback = null){
  
  // NOTE: build the data object to be used by router.php
  values = {
    'function': func // "test_hi",
  }
  if(data != null){
    values['data'] = data; // data applied should correlate with route.  
  }
  
  // NOTE: sending a post request using jquery's ajax function.
  $.ajax({
    url: 'php/router.php',
    type:'POST',
    data: JSON.stringify(values),
    dataType:"json",
    success: function (data) {
              console.log(data);
                let json = $.parseJSON(data);
                if(callback != null){
                  callback(json);
                  return true; // if we have a callback function we will let that handle the json;
                }
                return json; // If now callback function specified we assume the user wants the json data.
             },
    error: function (err) {
            console.log(err);
    }
  });
}
    

let test = routerPost('test_hi');
