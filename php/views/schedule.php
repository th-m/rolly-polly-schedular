<?php 
  include("../functions.php"); 
  date_default_timezone_set('Australia/Melbourne');
  $date = date('m/d/Y h:i:s a', time());
  // echo "tester";
  // $d = date;
  echo $date;
?>
<script type="text/javascript">
// window.onload = function(){
  printBtn = document.querySelector('#print');
  printBtn.addEventListener('click',function(){
    console.log("printintg");
    window.print();
  });
  
  emailBtn = document.querySelector('#email');
  emailBtn.addEventListener('click',function() {
    console.log("emailer");
    routerPost('emailer');
  });
// }
  
</script>
<button id="print" type="button" name="button">Print</button>
<button id="email" type="button" name="button">email</button>

		<div id="Wrapper">
			<header>
				<img id="Logo" src="drtab_logo.png">
				<h1>IHC Child Development Scheduler</h1>
				<div class="clear"></div>
			</header>
			
			<nav>
				<h3>Current Week: </h3>
				<h3 class="date"></h3>
				<ul id="Menu">
					<li><a href="#">New Schedule</a></li>
					<li><a href="#">Edit Schedule</a></li>
					<li class="dropdown">
						<a href="#">Teacher Admin</a>
						<ul class="teachers">
							<li><a>Menu item</a></li>
							<li><a>Another menu item</a></li>
						</ul>
					</li>
				</ul>
				<div class="clear"></div>
				<a href="#">Print</a>
				<a href="#">Email</a>
				<div class="clear"></div>
			</nav>
			
			<main>
				<table class="week">
					<tr>
						<th>Teachers</th>
						<th>Monday</th>
						<th>Tuesday</th>
						<th>Wednesday</th>
						<th>Thursday</th>
						<th>Friday</th>
					</tr>
					<tr class="something">
						<td>Foobar</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="something">
						<td>Foobar</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</ul>
			</main>
		</div>