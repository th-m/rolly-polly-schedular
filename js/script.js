
// NOTE: this function will intereact with our php router / database when needed
function routerPost(func, data = null, callback = null){
  
  // console.log(func);
  // console.log(data);
  // NOTE: build the data object to be used by router.php
  values = {
    'function': func // "test_hi",
  }
  // if(data != null){
  //   values['data'] = data; // data applied should correlate with route.  
  // }
  console.log(values.data);
  // NOTE: sending a post request using jquery's ajax function.
  // console.log(JSON.stringify(values));
  // var myHeaders = new Headers();

  // myHeaders.append('Content-Type', 'application/json');
  // var myInit = { method: 'POST',
  //                headers: myHeaders,
  //                body: JSON.stringify(values),
  //                cache: 'default' };
  //                
  // fetch('php/router.php').then(function(response) {
  //   // response.json().then(function(response){console.log(response);});
  //   // response.blob().then(function(response){console.log(response);});
  //   return response.text();
  //   // response.blob();
  //   // return response.json();
  // }).then(function(response) {
  //   // console.log('hellow')
  //   console.log(response);
  //   // var objectURL = URL.createObjectURL(myBlob);
  //   // myImage.src = objectURL;
  // });
  $.ajax({
    url: 'php/router.php',
    type:'POST',
    data: JSON.stringify(values),
    dataType:"json",
    success: function (data) {
              console.log('Got Data \n');
                let json = $.parseJSON(data);
                console.log(json);
                if(callback != null){
                  callback(json);
                  return true; // if we have a callback function we will let that handle the json;
                }
                return json; // If now callback function specified we assume the user wants the json data.
             },
    error: function (err) {
            console.log('Got err \n');
            console.log(err);
    }
  });
  
}

// routerPost('test_hi');
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
  $('#rolly_polly_main').load('./php/views/'+view+'.php', data);
}


navLinks = document.querySelectorAll("nav ul li");   
navLinks.forEach(lnk => {
  lnk.addEventListener('click', function(){ renderView(lnk.dataset.view, lnk.dataset);}, false);
}); 


