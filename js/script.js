
// NOTE: this function will interact with our php router / database when needed
function routerPost(func, data = null, callback = null){
  
  // NOTE: build the data object to be used by router.php
  values = {
    'function': func // "test_hi",
  }
  if(data != null){
    values['data'] = data; // data applied should correlate with route.  
  }

  // NOTE: sending a post request using javascript fetch function.
  var myHeaders = new Headers();
  myHeaders.append('Content-Type', 'application/json');
  myHeaders.append('Accept', 'application/json'); 
  var myInit = {
                 headers: myHeaders,
                 method: "POST",
                 body: JSON.stringify(values),
                 cache: 'default' 
               };
                
  fetch('php/router.php', myInit).then(function(response) {
    console.log("fetching router");
    return response.json();
  }).then(function(data) {
    json = (data);
    if(callback != null){
      callback(json);
      return true; // if we have a callback function we will let that handle the json;
    }
    console.log(data);
    return json;
  });

}

routerPost('test_hi');
function renderView(view, data = null, div = "rolly_polly_main",  callback = null){
  // NOTE: view will be the php file that returns our view. 
  // NOTE: div will be where the content will be injected. 
  // NOTE: data will be extra data needed or wanted for rendering.
  // NOTE: callback will be the callback function to fire. 
  
  // values = {};
  // 
  // if(data != null){
  //   values['data'] = data; // data applied should correlate with route.  
  // }
  // console.log(data.assoctables);
  // NOTE: sending a post request using jquery's ajax function.

  // $('#rolly_polly_main').load('./php/views/'+view+'.php', {"json": JSON.stringify(data)});
  // console.log(JSON.parse(data));
  $('#'+div).load('./php/views/'+view+'.php', data);
}
//NOTE: This method facilitates the main menu
navLinks = document.querySelectorAll("nav ul li");   
navLinks.forEach(lnk => {
  lnk.addEventListener('click', function(){ renderView(lnk.dataset.view, lnk.dataset);}, false);
}); 


