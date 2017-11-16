<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Doctor Tab</title>
		<meta charset="UTF-8">
		<meta name="google" content="notranslate">
    <!-- <link rel="stylesheet" href="style.css"> -->
		<meta http-equiv="Content-Language" content="en">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="./css/style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.3/vivus.min.js"></script>
    
  </head>
  <body>
    <?php if (!empty($_POST)){
        include ('php/sql.php');
        $qry = "SELECT * FROM users WHERE name = '{$_POST["name"]}' AND email = '{$_POST["email"]}';";
        $user = sql_query($qry);
        $_SESSION['user'] = $user[0];
        if(isset($user[0]['id']) && $user[0]['id'] != ""){
          include ("nav.php");
        }
      }else{
        include ("login.php");
      }
    ?>
    
  
  