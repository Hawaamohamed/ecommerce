<?php
 ob_start();
   session_start();
   if(isset($_SESSION['username'])){
	   $pageTitle="Dashboard";
	    include 'init.php';
 $latestUsers=5;
 $thelatest = getLatest('*','users','userid',$latestUsers);
 $numItems=6;
 $latestItems=getLatest('*','items','itemid',$numItems);


  ?>
     <!-- Start Dashboard Page -->



     <div class='container home-stats text-center'>
       <h1> Dashboard </h1>
       <div class='row'>
         <div class='col-md-3'>
           <div class='stat st-members'>
             <i class='fa fa-users'></i>
             <div class="info">
               Total members
             <span><a href="members.php" ><?php echo countItems('userid','users') ?></a></span>
           </div>
          </div>
        </div>
        <div class='col-md-3'>
          <div class='stat st-pending'>
          <i class='fa fa-user-plus'></i>
          <div class="info">
            Pending members
            <span><a href="members.php?do=manage&page=pending" ><?php echo checkItem('ragstatus','users',0) ?> </a></span>
          </div>
         </div>
       </div>
       <div class='col-md-3'>
         <div class='stat st-items'>
           <i class='fa fa-tag'></i>
           <div class='info'>
           Total Items
           <span><a href="items.php" ><?php echo countItems('itemid','items') ?></a></span>
         </div>
        </div>
      </div>
      <div class='col-md-3'>
        <div class='stat st-comments'>
          <i class='fa fa-comments'></i>
          <div class='info'>
          Total Commentes
      <span><a href="comments.php" ><?php echo countItems('c_id','comments') ?></a></span>
      </div>
       </div>
     </div>

  </div>
</div>

<div class="container latest">
 <div class="row">
   <div class='col-sm-6'>
     <div class='panel panel-default'>
       <div class="panel-heading">
         <i class='fa fa-users'> </i> Latest <?php echo $latestUsers ?> Register Users
       <span class='toggle-info pull-right'>
         <i class='fa fa-plus fa-lg'></i>
       </span>
       </div>
       <div class='panel-body'>
         <ul class='list-unstyled latest-users'>
         <?php


           if(!empty($thelatest))
           {
             foreach($thelatest as $user)
             {
              echo '<li>' . $user['username'] ;
              echo '<a href="members.php?do=Edit&userid='. $user['userid'] .'">';
              echo '<span class="btn btn-success pull-right">';
              echo '<i class="fa fa-edit"></i>Edit';
              if($user['ragstatus'] == 0){
               echo "<a href='members.php?do=activate&userid=" . $user['userid']. "'class='btn btn-info activate'><i class='fas fa-times'></i>activate</a>";
              }
              echo '</span></a></li>';
             }
         }else{
           echo "Users Is Empty";
         }
         ?>
       </ul>
       </div>
     </div>
   </div>

   <div class='col-sm-6'>
     <div class='panel panel-default'>
       <div class="panel-heading">
         <i class='fa fa-users'> </i> Latest Register Items
         <span class='toggle-info pull-right'>
           <i class='fa fa-plus fa-lg'></i>
         </span>
       </div>
       <div class='panel-body'>
         <?php
         if(!empty($latestItems))
         {
           foreach($latestItems as $item)
           {
            echo '<li>' . $item['name'] ;
            echo '<a href="members.php?do=Edit&userid='. $item['itemid'] .'">';
            echo '<span class="btn btn-success pull-right">';
            echo '<i class="fa fa-edit"></i>Edit';
            if($item['status'] == 0){
             echo "<a href='members.php?do=activate&userid=" . $item['itemid']. "'class='btn btn-info activate'><i class='fas fa-times'></i>activate</a>";
            }
            echo '</span></a></li>';
           }

         }else{
           echo "Items Is Empty";
         }

         ?>

       </div>
     </div>
   </div>
 </div>

 <!-- Start Latest Comments -->
 <div class="row">
   <div class='col-sm-6'>
     <div class='panel panel-default'>
       <div class="panel-heading">
         <i class='fa fa-comments-o'> </i> Latest <?php echo $latestUsers ?> Comments
       <span class='toggle-info pull-right'>
         <i class='fa fa-plus fa-lg'></i>
       </span>
       </div>
       <div class='panel-body'>
         <?php
         /* $stmt=$con->prepare("SELECT comments.*, items.name AS item_name, users.username AS member
                              FROM comments
                              INNER JOIN users ON
                              users.userid=comments.user_id");
                              */
          $stmt=$con->prepare("SELECT * FROM comments ORDER BY c_id DESC");
          $stmt->execute();
          $comments=$stmt->fetchAll();
          foreach($comments as $comment)
          {
            echo "<div class='comment-box'>";
            echo "<span class='member-n'> Name</span>";
            echo "<p class='member-c'>". $comment['comment'] . "</p>";
            echo "</div>";
          }

          ?>
       </div>
     </div>
   </div>
 </div>


 <!-- End Latest Comments -->
</div>
      <!-- End Dashboard Page -->
      <?php
		include $tpl . 'footer.php';

   }else{
	   header("Location: index.php");
	   exit();
   }

   ob_end_flush();
   ?>
