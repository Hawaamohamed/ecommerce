
<style>
.dropdown-menu{
 border-radius:0;
}
.navbar{
  margin-bottom:60px;
    height: 57px;
}
.navbar li{
  font-size: 17px;
  color: #5f6263;
}
.cat{
  margin-top:14px;
}
.navbar li.logo{
    color: #ffc006;
    font-size: 20px;
    margin: 9px -87px 30px;
}
</style>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse test" id="app-nav">
      <ul class="nav navbar-nav navbar-left">
        <li>
          <a class="navbar-brand" href="index.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li>
          <div class='btn-group my-info cat'>
            <span class='dropdown-toggle' data-toggle='dropdown'>
                    Categories
                <span class='caret'></span>
            </span>
            <ul class='dropdown-menu'>
              <?php
              // function getAllFrom($field,$fromtable,$where = Null,$orderBy,$ordering ='DESC')
               $categories=getAllFrom("*",'category',"WHERE parent= 0","",'id','ASC');
              foreach($categories as $cat)
              {
                echo "<li><a href='categories.php?pageid=".$cat['id']."'>".$cat['name']."</a></li>";
              }
              ?>
            </ul>
          </div>
         </li>
<img src="layout/images/cap.png" class="navbar-brand img-responsive nav hidden-xs center-block" style="width:11%;height:20%;margin-top:-5px;margin-left:25%;overflow:hidden">
<li class="logo">Jew-4-You</li>
    <li class='navbar-right pull-right'>
    <div class='upper-bar'>

    <?php
    if(isset($_SESSION['email']))
    {?>
    <a href="profile.php?id=<?php echo $_SESSION['uid']; ?>"><img src="<?php echo $images . '4.jpg' ?>" class=' img-header img-circle'></a>
    <div class='btn-group my-info'>
    <span class='btn dropdown-toggle' data-toggle='dropdown'>
      <?php echo $_SESSION['user'] ?>
     <span class='caret'></span>
    </span>
    <ul class='dropdown-menu'>
     <li><a href="profile.php?id=<?php echo $_SESSION['uid']; ?>"> My Profile </a></li>
     <li><a href="logout.php?uid=<?php echo $_SESSION['uid']; ?>"> Logout </a></li>
    </ul>
    </div>

    <?php
    }else{
    ?>
    <a href="login.php">
    <span class='pull-right'>Login | SinUp</span>
    </a>
    <?php } ?>
    </div>
    </li>
      </ul>

    </div>
  </div>
</nav>
<br>
