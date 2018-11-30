<?php


// Manage comments
// You can  Edit | Delete | Approve comments From Here
ob_start();
session_start();
   $pageTitle='Comments';
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
        //**************************** Manage Comments *************************\\
		 if ($do=='manage'){
       //select all Comments
      /* $stmt=$con->prepare("SELECT comments.*, items.name AS item_name, users.username AS member
                           FROM comments INNER JOIN items ON
                           items.itemid, comments.item_id
                           INNER JOIN users ON
                           users.userid=comments.user_id");
                           */
       $stmt=$con->prepare("SELECT * FROM comments");
       $stmt->execute();
       $rows=$stmt->fetchAll();


         ?>

        <h2 class='text-center'>Manage comments </h2>
        <div class="container">
          <div class="table-responsive">
           <table class="main-table text-center table table-bordered">
             <tr>
               <td>#ID</td>
               <td>Comment</td>
               <td>Item Name</td>
               <td>User Name</td>
               <td>Added Date</td>
               <td>Control</td>
             </tr>
             <?php
             foreach($rows as $row)
             {
               echo "<tr>";
                    echo "<td>" . $row['c_id'] . "</td>";
                    echo "<td>" . $row['comment'] . "</td>";
                    echo "<td>" . $row['item_id'] . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['comment_date'] . "</td>";
                    echo "<td>
                             <a href='comments.php?do=Edit&comid=" . $row['c_id']. "'class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>
                             <a href='comments.php?do=delete&comid=" . $row['c_id']. "'class='btn btn-danger confirm'><i class='fas fa-times'></i>Delete</a>";
                             if($row['status'] == 0){
                              echo "<a href='comments.php?do=approve&comid=" . $row['c_id']. "'class='btn btn-info activate'><i class='fas fa-check'></i>Approve</a>";
                             }
                   echo "</td>";
                echo "</tr>";
             }

             ?>
           </table>
          </div>
        </div>

      <?php  }
      //**************************** Edit Comment *************************\\
		else if($do=='Edit')
		{
			//check if Get Request Comment id is Numeric & Get integer value of it
			$comid;
          if(isset($_GET['comid']) && is_numeric($_GET['comid']))
		  {
			  $comid=intval($_GET['comid']);
		  }else{
			  $comid= 0;
		  }
		   //Select All Data Depend on this id
		  $stmt=$con->prepare("SELECT * FROM Comments where c_id=?");
		  //Execute the Data
	      $stmt->execute(array($comid));

	      $row=$stmt->fetch();  // return data from database;

	      $count=$stmt->rowCount();
		  // if there is such id show the form
	      if($count > 0)
	      {
		     echo $row['comment'];

		?>

			<h2 class='text-center'> Edit Comment </h2>
			<div class="container">
			 <form class='form-horizontal' action="?do=update" method="POST">

			  <div class="form-group form-group-lg">
			    <label class="col-sm-2 control-label"> Comment </label>
			     <div class="col-sm-10  col-md-4">
			       <textarea name='comment' value="" class="form-control" autocomplete="off"><?php echo $row['comment'] ?></textarea>
			     </div>
			  </div>
			  <input type="hidden" name="comid" value="<?php echo $comid ?>">

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <input type='submit' value="save" class="btn btn-primary btn-lg">
          </div>
       </div>
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
		 $comid=$_POST['comid'];
		 $comment=$_POST['comment'];

		// Update the database with this info
		 $stmt=$con->prepare("UPDATE comments SET comment=? where c_id=?");
		 $stmt->execute(array($comment,$comid));
		 $themsg="<div class='alert alert-danger'>". $stmt->rowCount()  . " Record Update </div> ";
     redirectHome($themsg,'back');

  }else{
		  $themsg= "<div class='alert alert-danger'> Sorry you can not browse this page directory</div>";
      redirectHome($themsg,'back');
	  }

     echo "</div>";
	 }



//************************* Delete Member ******************\\

   elseif($do == 'delete'){
     echo "<h2 class='text-center'> Delete Comment </h2>";
 	   echo "<div class='container'>";
     $comid;
         if(isset($_GET['comid']) && is_numeric($_GET['comid']))
     {
       $comid=intval($_GET['comid']);
     }else{
       $comid= 0;
     }
     //Select All Data Dependent on UserId;
      $check = checkItem('c_id','comments',$comid);
     // if there is such id show the form
       if($check > 0)
       {
        $stmt=$con->prepare("DELETE FROM comments WHERE c_id=:zid");
        $stmt->bindParam(":zid",$comid);
        $stmt->execute();
        $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted </div>";
        redirectHome($themsg,'back');
      }else{

        $themsg = "<div class='alert alert-danger'>this id is not exist</div>";
        redirectHome($themsg);
      }
      echo "</div>";

      /*********************************Activate Page ******************************/
   }else if($do == 'approve'){
     echo "<h2 class='text-center'> Approve Comment </h2>";
    echo "<div class='container'>";
     $comid;
         if(isset($_GET['comid']) && is_numeric($_GET['comid']))
     {
       $comid=intval($_GET['comid']);
     }else{
       $comid= 0;
     }
     //Select All Data Dependent on UserId;
      $check = checkItem('c_id','comments',$comid);
     // if there is such id show the form
       if($check > 0)
       {
        $stmt=$con->prepare("UPDATE comments SET status = 1 where c_id = ?");
        $stmt->execute(array($comid));
        $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Approved </div>";
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
