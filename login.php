<nav class="navbar navbar-default" style="margin-bottom:0!important; color:white; border:none;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Rolly Polly Schedular</a>
    </div>

  </div><!--/.container-fluid -->
</nav>

<div class="col-xs-6 col-xs-offset-3">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Who even are you?">
    </div>
    <div class="form-group">
     <label for="email">Email address</label>
     <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
     <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
   </div>
   <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
