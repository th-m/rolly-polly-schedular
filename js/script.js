// NOTE: Tracability stuff.
// NOTE: this function will interact with our php router / database when needed.
function routerPost(func, data = null, callback = null){
  // NOTE: func determines which function in router.php will fire.
  // NOTE: data is correlated to function.
  // NOTE: callback is a function that can be fired on completetion. 
  values = {
    'function': func 
  }
  if(data != null){
    values['data'] = data; 
  }

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
    return response.json();
  }).then(function(data) {
    if(callback != null){
      callback(data);
      return true; 
    }
    return data;
  });

}

function renderView(view, data = null, div = "rolly_polly_main",  callback = null){
  // NOTE: view will be the php file that returns our view. 
  // NOTE: div will be where the content will be injected. 
  // NOTE: data will be extra data for view rendering.
  // NOTE: callback will be the callback function to fire. 
  $('#'+div).load('./php/views/'+view+'.php', data);
}

navLinks = document.querySelectorAll("nav ul li .get_view");   
navLinks.forEach(lnk => {
  lnk.addEventListener('click', function(){ renderView(lnk.dataset.view, lnk.dataset);}, false);
}); 


