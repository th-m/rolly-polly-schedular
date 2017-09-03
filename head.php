<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rolly Polly</title> <!--TODO:Create php $_GET look at the title of the page.-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <nav>
      <ul>
        <li data-view="edit" data-table="staff_members" data-assoctables='staff_roles,staff_rooms'>Teachers</li>
        <li data-view="edit" data-table="rooms">Room</li>
        <li data-view="edit" data-table="events">Events</li>
        <li data-view="edit" data-table="roles">Roles</li>
        <li data-view="schedule" data-info="schedule">Schedule</li>
        <li data-view="prep" data-info="prep">Prep</li>
      </ul>
    </nav>