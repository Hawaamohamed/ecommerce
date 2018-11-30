<?php

ob_start();
session_start();
$pageTitle='Items';
if(isset($_SESSION['username']))
{
  include 'init.php';

if(isset($_GET['do']))
{
   $do=$_GET['do'];

}else{
	$do='manage';
}

if($do=="manage")
{
              //Join in database
  $stmt=$con->prepare("SELECT items.*, category.name AS category_name,users.username
                       FROM items INNER JOIN category ON category.id=items.catid
                                  INNER JOIN users ON users.userid=items.memberid");
  $stmt->execute();
  $items=$stmt->fetchAll();
    ?>

   <h2 class='text-center'>Manage Items </h2>
   <div class="container">
     <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
        <tr>
          <td>#ID</td>
          <td>Name</td>
          <td>Description</td>
          <td>Price</td>
          <td>Adding Date</td>
          <td>Member</td>
          <td>Category</td>
          <td>Control</td>
        </tr>
        <?php
        foreach($items as $item)
        {
          echo "<tr>";
               echo "<td>" . $item['itemid'] . "</td>";
               echo "<td>" . $item['name'] . "</td>";
               echo "<td>" . $item['description'] . "</td>";
               echo "<td>" . $item['price'] . "</td>";
               echo "<td>" . $item['add_date'] . "</td>";
               echo "<td>" . $item['username'] . "</td>";
               echo "<td>" . $item['category_name'] . "</td>";
               echo "<td>
                        <a href='items.php?do=Edit&itemid=" . $item['itemid']. "'class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>
                        <a href='items.php?do=delete&itemid=" . $item['itemid']. "'class='btn btn-danger confirm'><i class='fas fa-times'></i>Delete</a>";
                        if($item['approve'] == 0){
                         echo "<a href='items.php?do=approve&itemid=" . $item['itemid']. "'class='btn btn-info activate'><i class='fas fa-check'></i>Approve</a>";
                        }
              echo "</td>";
           echo "</tr>";
        }

        ?>


      </table>


     </div>
       <a href='items.php?do=add' class="btn btn-primary"><i class="fa fa-plus"> Add New Item</i> </a>
   </div>

 <?php
}
else if($do=="add")
{
  ?>


    <h2 class='text-center'> Add New Item </h2>
    <div class="container">
     <form class='form-horizontal' action="?do=insert" method="POST">

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Item Name </label>
         <div class="col-sm-10  col-md-4">
           <input type='text' name="name" class="form-control">
         </div>
      </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Description</label>
         <div class="col-sm-10  col-md-4">
           <input type='text' name="description" class="form-control">
         </div>
      </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Price </label>
         <div class="col-sm-10  col-md-4">
           <input type='text' name="price" class="form-control">
         </div>
      </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Country </label>
         <div class="col-sm-10  col-md-4">
           <input type='text' name="country" class="form-control">
         </div>
      </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Status </label>
         <div class="col-sm-10  col-md-4">
           <select name='status'>
            <option value='0'>...</option>
            <option value='1'>New</option>
            <option value='2'>Like New</option>
            <option value='3'>Used</option>
            <option value='4'>Very Old</option>
           </select>
         </div>
      </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Member</label>
         <div class="col-sm-10  col-md-4">
           <select name='member'>
            <option value='0'>...</option>
          <?php
           $stmt=$con->prepare("SELECT * FROM users");
           $stmt->execute();
           $rows=$stmt->fetchAll();
           foreach($rows as $row)
           {
             echo "<option value='".$row['userid']."'>". $row['username'] . "</option>";
           }
         ?>
           </select>
         </div>
      </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Category</label>
         <div class="col-sm-10  col-md-4">
           <select name='category'>
            <option value='0'>...</option>
          <?php
           $cats=getAllFrom("*",'category',"WHERE parent= 0","",'id','ASC');
           foreach($cats as $cat)
           {
             echo "<option value='".$cat['id']."'>". $cat['name'] . "</option>";
             $childs=getAllFrom("*",'category',"WHERE parent= {$cat['id']}","",'id','ASC');
             foreach($childs as $child ){
               echo "<option value='".$child['id']."'> --". $child['name'] . "</option>";
             }
           }
         ?>
           </select>
         </div>
      </div>
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Tags </label>
         <div class="col-sm-10 col-md-4">
           <input type='text' name="tags" class="form-control" placeholder='Separate Tags With Comma(,)'>
         </div>
      </div>

      <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
           <input type='submit' value="add item" class="btn btn-primary btn-sm">
         </div>
      </div>

    </form>
  </div>




  <?php
}
else if($do=="insert")
{
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
     echo "<h2 class='text-center'> Insert Item </h2>";
     echo "<div class='container'>";

   $name=$_POST['name'];
   $description=$_POST['description'];
   $price=$_POST['price'];
   $country=$_POST['country'];
   $status=$_POST['status'];
   $member=$_POST['member'];
   $category=$_POST['category'];
   $tags=$_POST['tags'];
   // Form validation
   $error=array();
   if(empty($name))
   {
    $error[]=" Please Enter Name ";
   }
   if(empty($description))
   {
     $error[]=" Please Enter description";
   }
   if(empty($price))
    {
     $error[]=" Please Enter price";
    }
    if(empty($country))
     {
      $error[]=" Please Enter country";
     }
     if($status==0)
      {
       $error[]=" Please select status";
      }
    if($member==0)
     {
      $error[]=" Please select member";
     }
    if($category==0)
     {
       $error[]=" Please select category";
     }
   foreach($error as $err)
   {
     echo "<div class='alert alert-danger'> <strong>".$err . "</strong> </div>";
   }
   if(empty($error))
   {
     //check if user exist in database

  // Insert the Member info In the database
         $stmt=$con->prepare("INSERT INTO items(name,description,price,country_made,status,add_date,memberid,catid,tags) VALUES (:zname,:zdesc,:zprice,:zcountry,:zstatus,now(),:zmember,:zcat,:ztags)");
         $stmt->execute(array('zname' => $name,'zdesc' => $description,'zprice' => $price , 'zcountry' => $country,'zstatus' => $status,'zmember' => $member,'zcat' => $category,'ztags' => $tags));
         $themsg ="<div class='alert alert-success'>" . $stmt->rowCount() . " Record Insert Successfully </div>";
         redirectHome($themsg,'back');
}

}else{
     echo "<div class='container'>";
      $themsg="<div class='alert alert-danger'>You Can not browse this page directory</div>";
      redirectHome($themsg);
      echo "</div>";
}
    echo "</div>";

}
else if($do == "Edit")
{
  //check if Get Request item is Numeric & Get integer value of it
  $itemid;
      if(isset($_GET['itemid']) && is_numeric($_GET['itemid']))
  {
    $itemid=intval($_GET['itemid']);
  }else{
    $itemid= 0;
  }
   //Select All Data Depend on this id
  $stmt=$con->prepare("SELECT * FROM items where itemid=?");
  //Execute the Data
    $stmt->execute(array($itemid));

    $item=$stmt->fetch();  // return data from database;

    $count=$stmt->rowCount();
  // if there is such id show the form
    if($count > 0)
    {

?>

<h2 class='text-center'> Edit Item </h2>
<div class="container">
 <form class='form-horizontal' action="?do=update" method="POST">

<input type='hidden' name='itemid' value="<?php echo $item['itemid']; ?>">
  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Name </label>
     <div class="col-sm-10  col-md-4">
       <input type='text' name="name" class="form-control" value="<?php echo $item['name'] ?>">
     </div>
  </div>

  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Description</label>
     <div class="col-sm-10  col-md-4">
       <input type='text' name="description" class="form-control" value="<?php echo $item['description'] ?>">
     </div>
  </div>

  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Price </label>
     <div class="col-sm-10  col-md-4">
       <input type='text' name="price" class="form-control" value="<?php echo $item['price'] ?>">
     </div>
  </div>

  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Country </label>
     <div class="col-sm-10  col-md-4">
       <input type='text' name="country" class="form-control" value="<?php echo $item['country_made'] ?>">
     </div>
  </div>

  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Status </label>
     <div class="col-sm-10  col-md-4">
       <select name='status'>
        <option <?php if($item['status'] == 1){echo 'selected';} ?>>New</option>
        <option <?php if($item['status'] == 2){echo 'selected';} ?>>Like New</option>
        <option <?php if($item['status'] == 3){echo 'selected';} ?>>Used</option>
        <option <?php if($item['status'] == 4){echo 'selected';} ?>>Very Old</option>
       </select>
     </div>
  </div>

  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Member</label>
     <div class="col-sm-10  col-md-4">
       <select name='member'>
      <?php
       $stmt=$con->prepare("SELECT * FROM users");
       $stmt->execute();
       $users=$stmt->fetchAll();
       foreach($users as $user)
       {
         echo "<option value='".$user['userid']."'";
         if($item['memberid'] == $user['userid']){echo 'selected'; }
         echo "'>". $user['username'] . "</option>";
       }
     ?>
       </select>
     </div>
  </div>

  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Category</label>
     <div class="col-sm-10  col-md-4">
       <select name='category'>
         <?php
          $stmt=$con->prepare("SELECT * FROM category");
          $stmt->execute();
          $cats=$stmt->fetchAll();
          foreach($cats as $cat)
          {
            echo "<option value='".$cat['id']."'";
            if($item['catid'] == $cat['id']){echo 'selected'; }
            echo "'>". $cat['name'] . "</option>";
          }
        ?>
       </select>
     </div>
  </div>

  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Tags </label>
     <div class="col-sm-10 col-md-4">
       <input type='text' name="tags" class="form-control" placeholder='Separate Tags With Comma(,)' value="<?php echo $item['tags'] ?>">
     </div>
  </div>

  <div class="form-group">
     <div class="col-sm-offset-2 col-sm-10">
       <input type='submit' value="Save item" class="btn btn-primary btn-sm">
     </div>
  </div>

</form>

<!-- Start Comments for this item -->
<?php
//select all Comments
/* $stmt=$con->prepare("SELECT comments.*, items.name AS item_name, users.username AS member
                    FROM comments
                    INNER JOIN users ON
                    users.userid=comments.user_id
                    where item_id=?");
                    */
$stmt=$con->prepare("SELECT * FROM comments where item_id=?");
$stmt->execute(array($itemid));
$rows=$stmt->fetchAll();

if(!empty($rows))
{
  ?>

 <h2 class='text-center'>Manage <?php echo $item['name'] ?> comments </h2>
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
      <tr>
        <td>Comment</td>
        <td>User Name</td>
        <td>Added Date</td>
        <td>Control</td>
      </tr>
      <?php
      foreach($rows as $row)
      {
        echo "<tr>";
             echo "<td>" . $row['comment'] . "</td>";
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
 <?php } ?>


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


?>
<!-- End Comments -->

</div>





<?php }
  //if theres No such id in database Show Error Message
else {
  echo "<div class='container'>";
  $themsg= "<div class='alert alert-danger'>Theres No Such This ID </div>";
  redirectHome($themsg,'back');
  echo "</div>";
}

}
else if($do=="update")
{
  echo "<h2 class='text-center'> Update Item </h2>";
  echo "<div class='container'>";
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $id=$_POST['itemid'];
    $name=$_POST['name'];
    $description=$_POST['description'];
    $price=$_POST['price'];
    $country=$_POST['country'];
    $status=$_POST['status'];
    $member=$_POST['member'];
    $category=$_POST['category'];
    // Form validation
    $error=array();
    if(empty($name))
    {
     $error[]=" Please Enter Name ";
    }
    if(empty($description))
    {
      $error[]=" Please Enter description";
    }
    if(empty($price))
     {
      $error[]=" Please Enter price";
     }
     if(empty($country))
      {
       $error[]=" Please Enter country";
      }

    foreach($error as $err)
    {
      echo "<div class='alert alert-danger'> <strong>".$err . "</strong> </div>";
    }

   if(empty($error))
   {

  // Update the database with this info
   $stmt=$con->prepare("UPDATE items SET name=? , description=? , price=? , country_made=? , status=? , memberid , catid where itemid=?");
   $stmt->execute(array($name,$description,$price,$country,$status,$member,$category,$id));
   $themsg="<div class='alert alert-danger'>". $stmt->rowCount()  . " Record Update </div> ";
   redirectHome($themsg,'back');
  }
}else{
    $themsg= "<div class='alert alert-danger'> Sorry you can not browse this page directory</div>";
    redirectHome($themsg,'back');
  }

   echo "</div>";
}
/*********************Delete Item*************************/
else if($do == 'delete')
{
  echo "<h2 class='text-center'> Delete Item </h2>";
  echo "<div class='container'>";
  $itemid;
      if(isset($_GET['itemid']) && is_numeric($_GET['itemid']))
  {
    $itemid=intval($_GET['itemid']);
  }else{
    $itemid= 0;
  }
  //Select All Data Dependent on UserId;
   $check = checkItem('itemid','items',$itemid);
  // if there is such id show the form
    if($check > 0)
    {
     $stmt=$con->prepare("DELETE FROM items WHERE itemid=:zitem");
     $stmt->bindParam(":zitem",$itemid);
     $stmt->execute();
     $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted </div>";
     redirectHome($themsg,'back');
   }else{

     $themsg = "<div class='alert alert-danger'>this id is not exist</div>";
     redirectHome($themsg);
   }
   echo "</div>";

}
/********************Approve***************************/
else if($do=="approve")
{
  echo "<h2 class='text-center'> Approve Item </h2>";
 echo "<div class='container'>";
  $itemid;
      if(isset($_GET['itemid']) && is_numeric($_GET['itemid']))
  {
    $itemid=intval($_GET['itemid']);
  }else{
    $itemid= 0;
  }
  //Select All Data Dependent on UserId;
   $check = checkItem('itemid','items',$itemid);
  // if there is such id show the form
    if($check > 0)
    {
     $stmt=$con->prepare("UPDATE items SET approve = 1 where itemid = ?");
     $stmt->execute(array($itemid));
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
