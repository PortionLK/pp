<nav class="navbar mainNav navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-bar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand hotel-logo" href="<?php echo (isset($hotel->web_url) && (strlen($hotel->web_url) > 0)) ? 'http://' . $hotel->web_url : DOMAIN . $hotel->seo_url; ?>"><img src="<?php echo DOMAIN; ?>images/roomista_logo.png" class=""/></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navigation-bar">

      <ul class="nav navbar-nav navbar-right">
	  	<?php if(isset($_SESSION['logged_user']) && ($_SESSION['logged_user'] == true)){ ?> 
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user text-success"></i> <?php echo $_SESSION['user']['first_name']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo DOMAIN;?>dashboard" class="name"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?><br><small>View Profile</small></a></li>
				<li class="divider"></li>
				<li><a href="<?php echo DOMAIN;?>dashboard"><i class="fa fa-tachometer"></i> Dashboard</a></li>
				<li class="divider"></li>
				<li>
					<form action="<?php echo DOMAIN; ?>logout" method="post">
						<input value="93661628262a8a7eec4a61518f92bf8c" name="csrf" type="hidden">
						<button type="submit" class="btn btn-link"><i class="fa fa-sign-out"></i> Log out</button>
					</form>
				</li>
            </ul>
        </li>
		<?php }else{ ?>
        	<li><a href="<?php echo DOMAIN;?>register/">Register</a></li>
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sign-in"></i> Login <span class="caret"></span></a>
            <ul id="login-dp" class="dropdown-menu">
                <li>
                     <div class="row">
                            <div class="col-md-12">
                                <h3>Login to Roomista</h3>
                                 <form class="form" role="form" method="post" action="<?php echo DOMAIN; ?>login" accept-charset="UTF-8" id="login-nav">
                  <input type="hidden" name="csrf" value="e29a7dc6b05461dfb19942e4331666b9">
                                    <div class="form-group">
                                         <label class="sr-only" for="email">Email address</label>
                                         <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
                                    </div>
                                    <div class="form-group">
                                         <label class="sr-only" for="password">Password</label>
                                         <input type="password" class="form-control" id="password" name="pswd" placeholder="Password" required>
                                         <div class="help-block text-right"><a href="">Forget the password ?</a></div>
                                    </div>
                                    <div class="form-group">
                                         <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                    </div>
                                 </form>
                            </div>
                            <div class="bottom text-center">
                                New here ? <a href="<?php echo DOMAIN; ?>register/"><b>Join Us</b></a>
                            </div>
                     </div>
                </li>
            </ul>
        </li>
		<?php }?>
      </ul>
    </div><!-- /.navbar-collapse -->
    </div>
  </div><!-- /.container-fluid -->
</nav>


<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div id="links">
      <ul class="nav navbar-nav">
        <li class=""><a href="<?php echo DOMAIN .'bookings/'. $seo_url; ?>">Home</a></li>
        <li class=""><a href="<?php echo DOMAIN .'bookings/'. $seo_url; ?>/special-offers/">Special offers</a></li>
        <li class=""><a href="<?php echo DOMAIN .'bookings/'. $seo_url; ?>/direction/">Directions</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>