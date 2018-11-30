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

 if($_SERVER['REQUEST_METHOD'] == 'POST')
 {

   $gram=filter_var($_POST['gm'], FILTER_SANITIZE_NUMBER_INT);
   //$cal=filter_var($_POST['cal'], FILTER_SANITIZE_STRING);
   $size=filter_var($_POST['size'], FILTER_SANITIZE_NUMBER_INT);
   $city=filter_var($_POST['city'], FILTER_SANITIZE_STRING);
   $address=filter_var($_POST['address'], FILTER_SANITIZE_STRING);
   $shop=filter_var($_POST['shop'], FILTER_SANITIZE_STRING);

   $error=array();
   if (empty($shop)) {
     $error[]= "Shop can not be Empty";
   }
   if ($shop < 2) {
     $error[]= "Shop Can Not Be Less Than 2";
   }
   if ($address < 4) {
     $error[]= "Please Enter Valid Address";
   }
   if (empty($address)) {
     $error[]= "Address can not be Empty";
   }
   if (empty($City)) {
     $error[]= "City can not be Empty";
   }
   if (empty($Size)) {
     $error[]= "Size can not be Empty";
   }
   if (empty($cal)) {
     $error[]= "Caliber can not be Empty";
   }
   if (empty($gram)) {
     $error[]= "Grammes can not be Empty";
   }

  // Insert the Item In the database
         $stmt=$con->prepare("UPDATE items SET grammes=?,caliber=?,size=?,city=?,address=?,shop=?,memberid=? WHERE itemid = ?");
         $stmt->execute(array($gram,$cal,$size, $city,$address,$shop,$_SESSION['uid'],$itemid));


 }
  //Select All Data Depend on this id
 $stmt=$con->prepare("SELECT items.*,category.name AS category_name,users.username
                      FROM items INNER JOIN category ON category.id = items.catid
                      INNER JOIN users ON users.userid = items.memberid
                      ORDER BY itemid DESC");
 //Execute the Data
   $stmt->execute(array($itemid));
    $item=$stmt->fetch();
   $count=$stmt->rowCount();
   if($count > 0)
   {

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

<form method='get' action="<?PHP echo $_SERVER['PHP_SELF']; ?>" role='form'>
    <div class='row'>
       <div class="form-group">
        <div class='col-sm-3'>
          <label>Grammes Number</label>
        </div>
        <div class='col-sm-3'>
          <input type="text" name='gm' class="gramme form-control" value=" <?php echo $item['grammes'] ;?>">
        </div>
       </div>

        <div class="form-group">
         <div class='col-sm-3'>
          <label>Caliber</label>
         </div>
           <div class="col-sm-3">
             <select name='cal' class="live-caliber form-control">
                <option value="<?php echo $item['caliber'] ;?>"><?php echo $item['caliber'] ;?></option>
                <option value='24'>24</option>
                <option value='21'>21</option>
                <option value='18'>18</option>
             </select>
           </div>
        </div>
     </div>
     <div class='row'>
        <div class="form-group">
         <div class='col-sm-3'>
          <label>Size </label>
         </div>
          <div class='col-sm-3 item-info form-group'>
           <input type="text"name='size' class="form-control" value="<?php echo $item['size']; ?>">
          </div>
        </div>

       <div class="form-group">
        <div class='col-sm-3'>
          <label>City</label>
        </div>
        <div class='col-sm-3 form-group'>
          <input type="text" name='city' class='form-control' value="<?php echo $item['city'] ;?>">
        </div>
      </div>
    </div>
    <div class='row'>
      <div class="form-group">
        <div class='col-sm-3 item-info'>
          <label>Address</label>
        </div>
        <div class='col-sm-3'>
          <input type="text" name='address' class='form-control' value="<?php echo $item['address'] ;?>">
        </div>
      </div>
      <div class="form-group">
        <div class='col-sm-3'>
          <label>Shop</label>
        </div>
        <div class='col-sm-3'>
          <input type="text" name='shop'class="form-control" value="<?php echo $item['shop'] ;?>">
        </div>
      </div>


      <div class="form-group">
         <div class="col-sm-3 col-sm-offset-5">
           <input type='submit' name='submit' id="<?php echo $item['itemid'] ;?>" value="Update" class="btn btn-info">
         </div>
      </div>
     </div>
     </form>
    </div>


 <?php
 }else{
   echo "<div class='alert alert-warning text-center' there is no such id And This item Waitaing Approval</div>";
 }
  include $tpl . "footer.php";
  ?>
<script>

</script>

  <?php ob_end_flush();?>
