<?php
  session_start();
$pageTitle='Login';
$noNavbar='';
if(isset($_SESSION['user']))
{
  header('location: index.php');
  exit();
}
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if(isset($_POST['loginForm']))
  {
  $email=$_POST['email'];
  $password=$_POST['password'];
  $hashedpass=sha1($password);

  $stmt=$con->prepare('SELECT userid , email , password ,shop FROM users WHERE email=? AND password=?');
  $stmt->execute(array($email,$hashedpass));
  $get= $stmt->fetch();
  $count=$stmt->rowCount();

  $shop=$get['shop'];

  if($count > 0){
       $stmt2=$con->prepare("SELECT id , name , address, city FROM shops WHERE name = ?");
       $stmt2->execute(array($shop));
       $get2= $stmt2->fetch();

    $_SESSION['email'] = $email;
    $_SESSION['uid'] = $get['userid'];
    $_SESSION['user'] = $get['username'];
    $_SESSION['shop'] = $shop;
    $_SESSION['shopid'] = $get2['id'];
    header('location: index.php');
    exit();
  }
  /********************SignUp User**************/
}else if(isset($_POST['signupForm'])){

$error=array();
$username=$_POST['username'];
$shop=$_POST['shop'];
$email=$_POST['email'];
$city=$_POST['city'];
$address=$_POST['address'];
$password=$_POST['password'];
$hashpass=sha1($password);

  if(isset($_POST['username']))
  {
//filter the username to get only string
//if insert (<script>Hawaa</script><h2>Mohamed</h2>)  will print (Hawaa Mohamed)
    $FilterUser=filter_var($_POST['username'],FILTER_SANITIZE_STRING);
  }
  if(isset($_POST['password']) && isset($_POST['password2']))
  {
    if(empty($_POST['password']))
    {
      $error[]='The Password Cannot Be Empty';
    }
    $pass1=sha1($_POST['password']);
    $pass2=sha1($_POST['password2']);
    if($pass1 !== $pass2)
    {
      $error[]="Two Password is Not Match";
    }

  }
  if(isset($_POST['email']))
  {
    //filter Email to get only string
    $FilterEmail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    if(filter_var($FilterEmail ) != true)
    {
      $error[]="Email Not Valid";
    }
  }

  if(empty($error))
  {
    //check if user exist in database
      $check=checkItem('email','users',$email);
      if($check == 1)
      {
        $error[] = "Sorry This User is Exist";
      }else{

 // Insert the Member info In the database
        $stmt=$con->prepare("INSERT INTO users(username,password,email,shop,date) VALUES (:zname,:zpass,:zmail,:zshop,now())");
        $stmt->execute(array('zname' => $username,'zpass' => $hashpass,'zmail' => $email,'zshop' => $shop));
        echo "<div class='alert alert-success'>THANK YOU FOR YOUR REGISTER</div>";
/*
        $stmt3=$con->prepare('SELECT userid , email , password ,shop FROM users WHERE email=?');
        $stmt3->execute(array($email));
        $get3= $stmt3->fetch();
        $shop=$get3['shop']
*/
        $stmt=$con->prepare("INSERT INTO shops(name,address,city) VALUES(:zname,:zadd,:zcity)");
        $stmt->execute(array('zname'=>$shop,'zadd'=>$address,'zcity'=>$city));


        $stmt4=$con->prepare("SELECT id , name , address, city FROM shops WHERE name = ?");
        $stmt4->execute(array($shop));
        $shop4= $stmt4->fetch();

        $_SESSION['email'] = $email;
        $_SESSION['user'] = $username;
        $_SESSION['uid'] = $get3['userid'];
        $_SESSION['shop'] = $shop;
        $_SESSION['shopid'] = $shop4['id'];
        header('location: index.php');
        exit();
 }
}
}
}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title> User | Log in</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="layout/css/bootstrap.min.css">
   <link rel="stylesheet" href="layout/css/font-awesome.min.css">
   <link rel="stylesheet" href="layout/css/ionicons.min.css">
   <link rel="stylesheet" href="layout/css/AdminLTE.min.css">
   <link rel="stylesheet" href="layout/iCheck/square/blue.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

 </head>

 <body class="hold-transition login-page">
 <div class='container login-pages'>
  <h1 class='text-center'>
      <span data-class='login' class='selected'>Login</span> |
      <span data-class='signup'>SignUp</span>
  </h1>
                      <div class="login-box login">
                        <!-- /.login-logo -->
                        <div class="login-box-body">
                          <p class="login-box-msg">Sign in to start your session</p>

  <form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
   <div class="input-container form-group has-feedback">
    <input type='email' name='email' class='form-control' placeholder="Your Email"  required>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
   <input type='password' name='password' class='form-control' placeholder="Your Password" autocomplete="new-password">
   <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>
  <div class="row">
   <div class="col-xs-8">
     <div class="checkbox icheck">
       <label>
         <input type="checkbox" name='remember'> Remember Me
       </label>
     </div>
   </div>

   <div class="col-xs-4">

   <input type='submit' class='btn btn-primary btn-block'  name='loginForm' value='Login'>
  </div>
 </div>
</form>
</div>

<?php
if(! empty($error))
{
  echo "<div class='alert alert-danger text-center'>";
  foreach($error as $err)
  {
    echo  $err ."<br>";
  }
   echo "</div>";

}
?>
</div>
<!-- ************************Form Form Register*********************-->
      <div class="hold-transition register-page signup">
      <div class="register-box">
        <div class="register-box-body signup-forms">
          <p class="login-box-msg">Register a new membership</p>

  <form class='' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class='row'>

     <div class='col-sm-12'>
      <div class="form-group has-feedback">
       <input type='text' minLength='3' name='username' class='form-control' placeholder="Your Name" autocomplete="off" required>
       <span class="glyphicon glyphicon-user form-control-feedback"></span>
     </div>
    </div>
    <div class='col-sm-12'>
     <div class="form-group has-feedback">
      <input type='text' minLength='3' name='shop' class='form-control' placeholder="Shop Name" autocomplete="off" required>
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
   </div>
   <div class='col-sm-12'>
    <div class="form-group has-feedback">
      <input type='email' name='email' class='form-control' placeholder="Valid Email">
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
   </div>
   <div class='col-sm-12'>
    <div class="form-group has-feedback">
     <input type='text' minLength='3' name='city' class='form-control' placeholder="City" autocomplete="off" required>
     <span class="glyphicon glyphicon-user form-control-feedback"></span>
   </div>
  </div>
  <div class='col-sm-12'>
   <div class="form-group has-feedback">
    <input type='text' minLength='3' name='address' class='form-control' placeholder="Address" autocomplete="off" required>
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
  </div>
 </div>
  <div class='col-sm-12'>
   <div class="form-group has-feedback">
    <input type='password' name='password' class='form-control' placeholder="Your Password" autocomplete="new-password">
    <span class="glyphicon glyphicon-log form-control-feedback"></span>
   </div>
 </div>
 <div class='col-sm-12'>
  <div class="form-group has-feedback">
    <input type='password' name='password2' class='form-control' placeholder="Confirm Password" autocomplete="new-password">
    <span class="glyphicon glyphicon-password form-control-feedback"></span>
  </div>
 </div>

 <div class='col-sm-4'>
   <input type='submit' class='btn btn-success btn-block' name='signupForm' value='signup'>
</div>
  </form>

  <div class='error-msg text-center'>

  </div>
</div>


<script src="layout/js/jquery.min.js"></script>
<script src="layout/js/bootstrap.min.js"></script>
<script src="layout/icheck/icheck.min.js"></script>
<script>
$(document).ready(function(){
  $(".login-page h1 span").click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');

    //$('.login-pages div').hide();
      $('.login-pages div.' + $(this).data('class')).siblings('div').hide();
      $('.login-pages div.' + $(this).data('class')).fadeIn(100);
  });

 });
</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

</body>
</html>
