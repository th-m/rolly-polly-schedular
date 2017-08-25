<?php
    $link = mysqli_connect('thomvaladez.com', 'electuz4_cs2450', 'cs2450', 'electuz4_schedule_app') or die ("Error " . mysqli_error($link));
    // Change character set to utf8
    mysqli_set_charset($link, "utf8");

?>
