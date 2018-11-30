<?php


// Manage Members
// You can Add | Edit | Delete Members From Here
ob_start();
session_start();
   $pageTitle='Member';
   if(isset($_SESSION['username'])){

	    include 'init.php';

		$do="";
		if(isset($_GET['do']))
        {
         $do=$_GET['do'];
        }
		else{
			$do='manage';
		}
        //**************************** Manage Members *************************\\
		 if ($do=='manage'){

       $query='';
       if(isset($_GET['page']) && $_GET['page'] == 'pending')
       {
         $query = "AND ragstatus = 0";
       }
       //select all users Except Admin
       $stmt=$con->prepare("SELECT * FROM users WHERE groupid != 1 $query");
       $stmt->execute();
       $rows=$stmt->fetchAll();


         ?>

        <h2 class='text-center'>Manage Members </h2>
        <div class="container">
          <div class="table-responsive">
           <table class="main-table manage-member text-center table table-bordered">
             <tr>
               <td>#ID</td>
               <td>Avatar</td>
               <td>UserName</td>
               <td>Email</td>
               <td>Full Name</td>
               <td>Register Date</td>
               <td>Control</td>
             </tr>
             <?php
             foreach($rows as $row)
             {
               echo "<tr>";
                    echo "<td>" . $row['userid'] . "</td>";
                    echo "<td>";
                        if(empty($row['avatar'])){
                              echo "<img src='uploads/avatar/17004.svg'>";
                        }else{ echo "<img src='uploads/avatar/" . $row['avatar'] ."'>";}
                    echo "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>
                             <a href='members.php?do=Edit&userid=" . $row['userid']. "'class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>
                             <a href='members.php?do=delete&userid=" . $row['userid']. "'class='btn btn-danger confirm'><i class='fas fa-times'></i>Delete</a>";
                             if($row['ragstatus'] == 0){
                              echo "<a href='members.php?do=activate&userid=" . $row['userid']. "'class='btn btn-info activate'><i class='fas fa-check'></i>activate</a>";
                             }
                   echo "</td>";
                echo "</tr>";
             }

             ?>


           </table>


          </div>
            <a href='members.php?do=add' class="btn btn-primary"><i class="fa fa-plus"> Add New Member</i> </a>
        </div>

      <?php  }
        //**************************** Add Member *************************\\
	  	elseif($do =='add'){ ?>

        <h2 class='text-center'> Add New Member </h2>
        <div class="container">
         <form class='form-horizontal' action="?do=insert" method="POST" enctype="multipart/form-data">

          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> UserName </label>
             <div class="col-sm-10  col-md-4">
               <input type='text' name="username" class="form-control" autocomplete="off">
             </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> Email </label>
             <div class="col-sm-10  col-md-4">
               <input type='email' name="email"  class="form-control" >
             </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> Password </label>
             <div class="col-sm-10  col-md-4">
             <input type='password' name="password" class="password form-control" autocomplete="new-password">
             <i class="show-pass fa fa-eye fa-2x"></i>
           </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> Full Name </label>
             <div class="col-sm-10  col-md-4">
               <input type='text' name="full_name" class="form-control">
             </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label"> User Avatar </label>
             <div class="col-sm-10  col-md-4">
               <input type='file' name="avatar" class="form-control">
             </div>
          </div>
          <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
               <input type='submit' value="add member" class="btn btn-primary btn-lg">
             </div>
          </div>

        </form>
      </div>


  	<?php
   }
      //**************************** Insert Member *************************\\
     elseif($do=='insert')
     {
      echo "insert page";

 	  if($_SERVER['REQUEST_METHOD'] == 'POST')
 	  {
       echo "<h2 class='text-center'> Insert Member </h2>";
  	   echo "<div class='container'>";
 		  //get the variables from the form
 		 $user=$_POST['username'];
     $pass=$_POST['password'];
 		 $email=$_POST['email'];
 		 $full=$_POST['full_name'];
    $hashpass=sha1($_POST['password']);

    $avatarName=$_FILES['avatar']['name'];
    $avatarSize=$_FILES['avatar']['size'];
    $avatarTmp=$_FILES['avatar']['tmp_name'];
    $avatarType=$_FILES['avatar']['type'];
    $avatarAllowedExtention=array('jpg','jpeg','gif','png','svg');
    $avatarExtention=strtolower(end(explode('.','$avatarName')));
 		 // Form validation
 		 $error=array();
 		 if($user=='')
 		 {
 			$error[]=" Please Enter User Name ";
 		 }
 		 if($email=='')
 		 {
 			 $error[]=" Please Enter Email ";
 		 }
     if($pass=='')
      {
       $error[]=" Please Enter Password";
      }
      if(! empty($avatarName) && ! in_array($avatarExtention,$avatarAllowedExtention)){
        $error[]=" This Extention is not allowed";
      
      }
      if(empty($avatarName)){
        $error[]=" Avatar is Required";
      }
      if($avatarSize > 4194304){
        $error[]=" Avatar Image Can not be larger than 4MB";
      }
 		 foreach($error as $err)
 		 {
 			 echo "<div class='alert alert-danger'> <strong>".$err . "</strong> </div>";
 		 }
 		 if(empty($error))
 		 {

       $avatar=rand(0,1000000) . '_' . $avatarName;
       move_uploaded_file($avatarTmp,"uploads\avatar\\".$avatar);
       //check if user exist in database
         $check=checkItem('username','users',$user);
         if($check==1)
         {
           $themsg = "<div class='alert alert-danger'>sorry this user is Exist</div>";
           redirectHome($themsg,'back');
         }else{
 		// Insert the Member info In the database
           $stmt=$con->prepare("INSERT INTO users(username,password,email,fullname,ragstatus,date,avatar) VALUES (:zname,:zpass,:zmail,:zfull,1,now(),:zavatar)");
 		  		 $stmt->execute(array('zname' => $user,'zpass' => $hashpass,'zmail' => $email,'zfull' => $full,'zavatar' =>$avatar));
 		       $themsg ="<div class='alert alert-success'>" . $stmt->rowCount() . " Record Insert Successfully </div>";
           redirectHome($themsg,'back');
 	  }
  }

  }else{
       echo "<div class='container'>";
        $themsg="<div class='alert alert-danger'>You Can not browse this page directory</div>";
        redirectHome($themsg);
        echo "</div>";
  }
 	    echo "</div>";
  }

      //**************************** Edit Member *************************\\
		else if($do=='Edit')
		{
			//check if Get Request userid is Numeric & Get integer value of it
			$userid;
          if(isset($_GET['userid']) && is_numeric($_GET['userid']))
		  {
			  $userid=intval($_GET['userid']);
		  }else{
			  $userid= 0;
		  }
		   //Select All Data Depend on this id
		  $stmt=$con->prepare("SELECT * FROM users where userid=? LIMIT 1");
		  //Execute the Data
	      $stmt->execute(array($userid));

	      $row=$stmt->fetch();  // return data from database;

	      $count=$stmt->rowCount();
		  // if there is such id show the form
	      if($count > 0)
	      {
		     echo $row['username'];

		?>

			<h2 class='text-center'> Edit Member </h2>
			<div class="container">
			 <form class='form-horizontal' action="?do=update" method="POST">

			  <div class="form-group form-group-lg">
			    <label class="col-sm-2 control-label"> UserName </label>
			     <div class="col-sm-10  col-md-4">
			       <input type='text' name="username" value="<?php echo $row['username'] ?>"class="form-control" autocomplete="off">
			     </div>
			  </div>
			  <div class="form-group form-group-lg">
			    <label class="col-sm-2 control-label"> Email </label>
			     <div class="col-sm-10  col-md-4">
			       <input type='email' name="email" value="<?php echo $row['email'] ?>" class="form-control">
			     </div>
			  </div>
			  <div class="form-group form-group-lg">
			    <label class="col-sm-2 control-label"> Password </label>
			     <div class="col-sm-10  col-md-4">
				   <input type='password' name="newpassword" class="form-control" autocomplete="new-password">
			       <input type='hidden' name="oldpassword" value="<?php echo $row['password'] ?>">
				 </div>
			  </div>
			  <div class="form-group form-group-lg">
			    <label class="col-sm-2 control-label"> Full Name </label>
			     <div class="col-sm-10  col-md-4">
			       <input type='text' name="full_name" class="form-control" value="<?php echo $row['fullname'] ?>">
			     </div>
			  </div>
			  <div class="form-group">
			     <div class="col-sm-offset-2 col-sm-10">
			       <input type='submit' value="save" class="btn btn-primary btn-lg">
			     </div>
			  </div>

			  <input type="hidden" name="userid" value="<?php echo $userid ?>">
			</form>
		</div>
		<?php }
		  //if theres No such id in database Show Error Message
		else {
      echo "<div class='container'>";
			$themsg= "<div class='alert alert-danger'>Theres No Such This ID </div>";
      redirectHome($themsg,'back');
      echo "</div>";
		}


      //**************************** Update Member *************************\\
    }elseif($do=='update')
	{
	  echo "<h2 class='text-center'> Update Member </h2>";
	  echo "<div class='container'>";
	  if($_SERVER['REQUEST_METHOD'] == 'POST')
	  {
		  //get the variables from the form
		 $id=$_POST['userid'];
		 $name=$_POST['username'];
		 $email=$_POST['email'];
		 $full=$_POST['full_name'];

		 $pass='';
		 if(empty($_POST['newpassword']))
		 {
			 $pass=($_POST['oldpassword']);
		 }else{
			 $pass=sha1($_POST['newpassword']);
		 }

		 // Form validation
		 $error=array();
		 if($name=='')
		 {
			$error[]=" Please Enter User Name ";
		 }
		 if($email=='')
		 {
			 $error[]=" Please Enter Email ";
		 }

		 foreach($error as $err)
		 {
			 echo "<div class='alert alert-danger'> <strong>".$err . "</strong> </div>";
		 }
		 if(empty($error))
		 {
        $stmt2=$con->prepare("SELECT * FROM users WHERE username=? AND userid !=?");
        $stmt2->execute(array($name,$id));
        $count=$stmt2->rowCount();
        if($count == 1)
        {
          echo "Sorry This User Exist";
        }else{
		// Update the database with this info
		 $stmt=$con->prepare("UPDATE users SET username=? , email=? , password=? , fullname=? where userid=?");
		 $stmt->execute(array($name,$email,$pass,$full,$id));
		 $themsg="<div class='alert alert-danger'>". $stmt->rowCount()  . " Record Update </div> ";
     redirectHome($themsg,'back');
	  }
  }
  }else{
		  $themsg= "<div class='alert alert-danger'> Sorry you can not browse this page directory</div>";
      redirectHome($themsg,'back');
	  }

     echo "</div>";
	 }



//************************* Delete Member ******************\\

   elseif($do == 'delete'){
     echo "<h2 class='text-center'> Delete Member </h2>";
 	   echo "<div class='container'>";
     $userid;
         if(isset($_GET['userid']) && is_numeric($_GET['userid']))
     {
       $userid=intval($_GET['userid']);
     }else{
       $userid= 0;
     }
     //Select All Data Dependent on UserId;
      $check = checkItem('userid','users',$userid);
     // if there is such id show the form
       if($check > 0)
       {
        $stmt=$con->prepare("DELETE FROM users WHERE userid=:zuser");
        $stmt->bindParam(":zuser",$userid);
        $stmt->execute();
        $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted </div>";
        redirectHome($themsg,'back');
      }else{

        $themsg = "<div class='alert alert-danger'>this id is not exist</div>";
        redirectHome($themsg);
      }
      echo "</div>";

      /*********************************Activate Page ******************************/
   }else if($do == 'activate'){
     echo "<h2 class='text-center'> Activate Member </h2>";
    echo "<div class='container'>";
     $userid;
         if(isset($_GET['userid']) && is_numeric($_GET['userid']))
     {
       $userid=intval($_GET['userid']);
     }else{
       $userid= 0;
     }
     //Select All Data Dependent on UserId;
      $check = checkItem('userid','users',$userid);
     // if there is such id show the form
       if($check > 0)
       {
        $stmt=$con->prepare("UPDATE users SET ragstatus = 1 where userid = ?");
        $stmt->execute(array($userid));
        $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated </div>";
        redirectHome($themsg,'back');
      }else{

        $themsg = "<div class='alert alert-danger'>this id is not exist</div>";
        redirectHome($themsg);
      }
      echo "</div>";
   }

		include $tpl . 'footer.php';

   }else{

	   header("Location: index.php");
	   exit();
   }
ob_end_flush();
?>
