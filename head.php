<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Doctor Tab</title>
		<meta charset="UTF-8">
		<meta name="google" content="notranslate">
    <!-- <link rel="stylesheet" href="style.css"> -->
		<meta http-equiv="Content-Language" content="en">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.css">

    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <!-- <header>
      <img id="Logo" src="drtab_logo.png">
      <h1>IHC Child Development Scheduler</h1>
    </header> -->
    <nav class="navbar navbar-expand-md navbar-light bg-faded" style="background-color: #4151A3;">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#" style="color:white;"> <img id="Logo" style="width:70px;" src="drtab_logo.png"> </a>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link get_view" href="#"  data-view="schedule" data-info="schedule">Schedule</a>
          </li>
          <li class="nav-item" >
            <a class="nav-link get_view" href="#" data-view="prep" data-info="prep">Prep</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Admin
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item get_view" data-view="edit" data-table="staff_members" data-assoctables='staff_roles,staff_rooms' href="#">Teachers</a>
              <a class="dropdown-item get_view" data-view="edit" data-table="rooms" href="#">Rooms</a>
              <a class="dropdown-item get_view" data-view="edit" data-table="events" href="#">Events</a>
              <a class="dropdown-item get_view" data-view="edit" data-table="roles" href="#">Roles</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    
    <!-- <nav>
      <ul>
        <li data-view="edit" data-table="staff_members" data-assoctables='staff_roles,staff_rooms'>Teachers</li>
        <li data-view="edit" data-table="rooms">Room</li>
        <li data-view="edit" data-table="events">Events</li>
        <li data-view="edit" data-table="roles">Roles</li>
        <li data-view="schedule" data-info="schedule">Schedule</li>
        <li data-view="prep" data-info="prep">Prep</li>
      </ul>
    </nav> -->