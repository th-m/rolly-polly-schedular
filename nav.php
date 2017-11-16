<nav class="navbar navbar-default" style="margin-bottom:0!important; color:white; border:none;">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Rolly Polly Schedular</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="nav-item">
          <a class="nav-link get_view" href="#"  data-view="schedule" data-info="schedule">Schedule</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link get_view" href="#" data-view="prep" data-info="prep">Prep</a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin Controls <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item get_view" data-view="edit" data-table="staff_members" data-assoctables='staff_roles,staff_rooms' href="#">Teachers</a></li>
            <li><a class="dropdown-item get_view" data-view="edit" data-table="rooms" href="#">Rooms</a></li>
            <li><a class="dropdown-item get_view" data-view="edit" data-table="events" href="#">Events</a></li>
            <!-- <li><a class="dropdown-item get_view" data-view="edit" data-table="roles" href="#">Roles</a></li>              -->
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!--/.container-fluid -->
</nav>