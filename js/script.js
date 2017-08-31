
// NOTE: this function will intereact with our php router / database when needed
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

function renderView(view, data = null, div = "rolly_polly_main",  callback = null){
  // NOTE: view will be the php file that returns our view. 
  // NOTE: div will be where the content will be injected. 
  // NOTE: data will be extra data needed or wanted for rendering.
  // NOTE: callback will be the callback function to fire. 
  
  values = {};

  if(data != null){
    values['data'] = data; // data applied should correlate with route.  
  }
  // NOTE: sending a post request using jquery's ajax function.

  // $('#rolly_polly_main').load('./php/views/'+view+'.php', {"json": JSON.stringify(data)});
  // console.log(JSON.stringify(data));
  $('#rolly_polly_main').load('./php/views/'+view+'.php', data);
}

function prepRenderView(lnkData){
  view = lnkData.view;
  renderView(view, lnkData);
}

navLinks = document.querySelectorAll("nav ul li");   
navLinks.forEach(lnk => {
  lnk.addEventListener('click', function(){ prepRenderView(lnk.dataset);}, false);
  // lnk.addEventListener('click', renderView(lnk.dataset.view));
}); 
console.log(navLinks);
var drawerLinks;

