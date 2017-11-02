<?php
  if($_SERVER['HTTP_HOST'] == "http://thomvaladez.com/"){
    $link = mysqli_connect('localhost', 'electuz4_cs2450', 'cs2450', 'electuz4_schedule_app') or die ("Error " . mysqli_error($link));
  }else{
    $link = mysqli_connect('thomvaladez.com', 'electuz4_cs2450', 'cs2450', 'electuz4_schedule_app') or die ("Error " . mysqli_error($link));
  }
    // Change character set to utf8
    mysqli_set_charset($link, "utf8");

?>
