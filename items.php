<?php
ob_start();
session_start();
$pageTitle="Show Items";
 include "init.php";
 $itemid;
  if(isset($_GET['itemid']) && is_numeric($_GET['itemid']))
 {
   $itemid=intval($_GET['itemid']);
 }else{
   $itemid= 0;
 }
  //Select All Data Depend on this id
 $stmt=$con->prepare("SELECT items.*,category.name AS category_name,users.username
                      FROM items INNER JOIN category ON category.id = items.catid
                      INNER JOIN users ON users.userid = items.memberid
                      ORDER BY itemid DESC");
 //Execute the Data
   $stmt->execute(array($itemid));
   $count=$stmt->rowCount();
   if($count > 0)
   {
   $item=$stmt->fetch();  // return data from database;
 ?>
 <style>
  .item-info ul li{
    padding:7px;
  }
 </style>
<div class='container'>
 <div class='row'>
   <div class='col-md-3 col-md-offset-4'>
    <?php echo "<img src='uploads/photos/4.jpg" ."'class='img-responsive center-block' style='margin-bottom:20px;'>"; ?>
   </div>
</div>
<div class="row">
   <div class='col-md-7 item-info'>
     <ul class='list-unstyled'>
         <li> <span>Grammes </span>  &nbsp&nbsp:  <?php echo $item['grammes'] ?></li>
         <li> <span>Caliber </span> : <?php echo $item['caliber'] ?></li>
         <li> <span> Size</span>  : <?php echo $item['size'] ?></li>
         <li> <span>City</span> : <?php echo $item['city'] ?></li>
         <li> <span>Address</span> : <?php echo $item['address'] ?></li>
         <li> <span>Shop</span> : <?php echo $item['shop'] ?></li>
         <li> <span>Added Date</span> : <?php echo $item['add_date'] ?></li>
    </ul>
   </div>

 </div>

<hr class='custom-hr'>
</div>

 <?php
 }else{
   echo "<div class='alert alert-warning text-center' there is no such id And This item Waitaing Approval</div>";
 }
  include $tpl . "footer.php";
  ob_end_flush();
  ?>
