<nav>
   <ul id="nav">
      <li><a <?php if ($currentPage === 'index') { echo 'class="active"'; } ?> href="index.php">Home</a></li>
      <li><a <?php if ($currentPage === 'jobs') { echo 'class="active"'; } ?> href="jobs.php">Join Us</a></li>
      <li><a <?php if ($currentPage === 'apply') { echo 'class="active"'; } ?> href="apply.php">Apply to us</a></li>
      <li><a <?php if ($currentPage === 'about') { echo 'class="active"'; } ?> href="about.php">About Me</a></li>
	  <li><a <?php if ($currentPage === 'enhancements2') { echo 'class="active"'; } ?> href="enhancements2.php">Enhancements 2</a></li>
	  <li><a <?php if ($currentPage === 'phpenhancements') { echo 'class="active"'; } ?> href="phpenhancements.php">Php Enhancements</a></li>
	  <li class="right"><a <?php if ($currentPage === 'logout') { echo 'class="active"'; } ?> href="logout.php">Logout</a></li>
      <li class="right"><a <?php if ($currentPage === 'manage') { echo 'class="active"'; } ?> href="manage.php">Manage</a></li>
	  <li class="right"><a <?php if ($currentPage === 'register') { echo 'class="active"'; } ?> href="register.php">Register</a></li>
	  <li class="right"><a <?php if ($currentPage === 'login') { echo 'class="active"'; } ?> href="login.php">Login</a></li>
   </ul>
</nav>

