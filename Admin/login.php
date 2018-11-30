
<?php
   session_start();
   $noNavbar='';
   $pageTitle = "Login";

   if(isset($_SESSION['username'])){
	   header('Location: dashboard.php');
   }

   include 'init.php';

   if($_SERVER['REQUEST_METHOD'] == 'POST'){

	   $username=$_POST['user'];
	   $password=$_POST['pass'];
	   $hashpass=sha1($password);

	   //check if user exist in Database
	   $stmt=$con->prepare("SELECT userid , username , password FROM users where username=? AND password=? AND groupid=1 LIMIT 1");
	   $stmt->execute(array($username,$hashpass));
	   $row=$stmt->fetch();  // return data from database;

	   $count=$stmt->rowCount();
	   if($count > 0)
	   {
		   $_SESSION['username']=$username;  //register session name
		   $_SESSION['id']=$row['userid'];   //register session id
		   header('Location: dashboard.php');
		   exit();

	   }
   }


?>

  <form role="form" class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
   <h4 class="text-center"> Admin Login </h4>
      <input type="text" class="form-control" name="user" placeholder="UserName" autocomplete="off">
      <input type="password" class="form-control" name="pass" placeholder='password' autocomplete="new-password">
      <input type="submit" class="btn btn-primary btn-block" value="Login">
  </form>






<?php include $tpl . 'footer.php'; ?>
