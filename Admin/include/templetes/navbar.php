
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('home_admin') ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse test" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('categories') ?></a></li>
		<li><a href="items.php"><?php echo lang('item') ?></a></li>
		<li><a href="members.php?do=manage"><?php echo lang('members') ?></a></li>
    <li><a href="comments.php"><?php echo lang('comments') ?></a></li>
		<li><a href="#"><?php echo lang('statistics') ?></a></li>
		<li><a href="#"><?php echo lang('logs') ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hawaa <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop</a><li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['id'] ?>"> Edit Profile </a></li>
            <li><a href="#">Setting</a></li>
            <li><a href="logout.php">Logout</a></li>

          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
