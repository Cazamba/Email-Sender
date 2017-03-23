<div class="wrapper login-container">

    <div class="logo-div">
    	<img src="/images/czmb-logo-black.svg">
    </div>
    
    <form class="form-signin" action="" method="POST">       
      <input type="text" class="form-control" name="username" placeholder="Email Address" required="" autofocus="" value="<?= $user_name ?>"/>
      <input type="password" class="form-control" name="password" placeholder="Password" required="" value="<?= $password ?>"/> 

      <label class="checkbox"> 
      	<input type="checkbox" value="remember-me" <?= $remember ?> id="rememberMe" name="rememberMe"> Remember me 
	  </label> 

      <?php if (isset($error)) { ?>
      <?= $error ?>
      <?php } ?>

      <button class="btn btn-lg btn-orange btn-block" type="submit">Login</button>   
    </form>
  </div>
