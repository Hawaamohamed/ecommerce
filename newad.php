<?php
ob_start();
session_start();
$pageTitle="New Item";
 include "init.php";
 include "include/languages/arabic.php";

 if(isset($_SESSION['user']))
 {
   $shop=$_SESSION['shop'];
   $shopid=$_SESSION['shopid'];
   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
     $gram=$_POST['grammes'];
     $cal=$_POST['caliber'];
     $size=$_POST['size'];
     $city=$_POST['city'];
     $address=$_POST['address'];
     $category=$_POST['category'];

      $gram=filter_var($_POST['grammes'], FILTER_SANITIZE_NUMBER_INT);
      $cal=filter_var($_POST['caliber'], FILTER_SANITIZE_STRING);
      $size=filter_var($_POST['size'], FILTER_SANITIZE_NUMBER_INT);
      $city=filter_var($_POST['city'], FILTER_SANITIZE_STRING);
      $address=filter_var($_POST['address'], FILTER_SANITIZE_STRING);
      $category=filter_var($_POST['category'], FILTER_SANITIZE_STRING);

          $photoName=$_FILES['photo']['name'];
          $photoSize=$_FILES['photo']['size'];
          $photoTmp=$_FILES['photo']['tmp_name'];
          $photoType=$_FILES['photo']['type'];
          $photoAllowedExtention=array('jpg','jpeg','gif','png','svg');
          $photoExtention=strtolower(end(explode('.','$photoName')));
      $error=array();

      if ($address=='') {
        $error[]= "Address can not be Empty";
      }
      if ($city=='') {
        $error[]= "City can not be Empty";
      }
      if ($size=='') {
        $error[]= "Size can not be Empty";
      }
      if ($cal=='') {
        $error[]= "Caliber can not be Empty";
      }
      if ($gram=='') {
        $error[]= "Grammes can not be Empty";
      }
      /*if(! empty($photoName) && ! in_array($photoExtention,$photoAllowedExtention)){
        $error[]=" This Extention is not allowed";

      }*/
      if($photoName==''){
        $error[]=" Photo is Required";
      }
      if($photoSize > 4194304){
        $error[]=" Photo Image Can not be larger than 4MB";
      }
      if(empty($error))
      {
        //$photo=rand(0,1000000) . '_' . $photoName;
        move_uploaded_file($photoTmp,"uploads\photos\\".$photoName);
     // Insert the Item In the database
            $stmt=$con->prepare("INSERT INTO items(grammes,caliber,size,city,address,shop,shopid,image,add_date,memberid,catid) VALUES (?,?,?,?,?,?,?,?,now(),?,?)");
            $stmt->execute(array($gram,$cal,$size,$city,$address, $shop,$_SESSION['shopid'],$photoName,$_SESSION['uid'], $category));

            if($stmt){
              echo 'item added Successfully';
            }else{echo "Error";}
       }else if(!empty($error)){
         echo "<br><br><div class='alert alert-danger text-center'>";
         foreach($error as $err)
         {
           echo   $err . '<br>';
         }
         echo "</div>";
       }

   }

?>
<style>
h1{
  margin-bottom: 38px;
    margin-top: 78px;
}
.caption {
  font-size:14px;
  color:#DDD;
}
</style>
<h1 class='text-center'>Add New Item</h1>
<div class='create-ad block'>
 <div class='container'>
  <div class='panel panel-warning'>
    <div class='panel-heading'>New Item</div>
    <div class='panel-body'>
     <div class='row'>
       <div class='col-sm-8'>
         <div class="container">
          <form class='form-horizontal' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

           <div class="form-group">
             <label class="col-sm-2 "> Grammes </label>
              <div class="col-sm-5  col-md-4">
                <input type='text' name="grammes" class="form-control live-grammes">
              </div>
           </div>

           <div class="form-group">
             <label class="col-sm-2">Caliber</label>
              <div class="col-sm-5  col-md-4">
                <select name='caliber' class="live-caliber">
                 <option value=''>...</option>
                 <option value='24'>24</option>
                 <option value='21'>21</option>
                 <option value='18'>18</option>
                </select>
              </div>
           </div>

           <div class="form-group">
             <label class="col-sm-2 ">Size </label>
              <div class="col-sm-5  col-md-4">
                <input type='text' name="size" class="form-control live-size">
              </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2">City </label>
              <div class="col-sm-5  col-md-4">
                <input type='text' name="city" class="form-control live-city">
              </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2">Address</label>
              <div class="col-sm-5  col-md-4">
                <input type='text' name="address" class="form-control live-address">
              </div>
           </div>

           <div class="form-group">
             <label class="col-sm-2">Category</label>
              <div class="col-sm-5 col-md-4">
                <select name='category'>
                 <option value=''>...</option>
               <?php
              //function getAllFrom($field,$fromtable,$where = Null,$orderBy,$ordering ='DESC')
               $cats=getAllFrom('*','category','','id');
                foreach($cats as $cat)
                {
                  echo "<option value='".$cat['id']."'>". $cat['name'] . "</option>";
                }
              ?>
                </select>
              </div>
           </div>
           <div class="form-group ">
             <label class="col-sm-2"> Photo </label>
              <div class="col-sm-5  col-md-4">

                 <input type='file' name="photo"  id='photo' class="form-control live-photo">

              </div>
           </div>

           <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <input type='submit' value="Add item" class="btn btn-primary btn-sm">
              </div>
           </div>

         </form>
       </div>


       </div>
       <div class='col-sm-4'>
         <div class='thumbnail live-preview'>
             <img src="<?php echo $images . '4.jpg' ?>"alt='' class='img-responsive center-block'>
             <div class='caption'>
                <span>Grammes: </span> <span></span><br>
                <span>caliber: </span> <span></span><br>
                <span>Size: </span> <span></span><br>
                <span>City: </span> <span></span><br>
                <span>Address: </span> <span></span><br>
                <span>Shop: </span> <span></span>
             </div>
         </div>
       </div>
    </div>
    <?php

    ?>
   </div>
  </div>
 </div>
</div>

 <?php
}else{
  header('Location: index.php');
  exit();
}
    include $tpl . "footer.php";  ?>

<script>
$('.live-grammes').keyup(function(){
  $('.live-preview .caption span:eq(1)').text($(this).val());
});
$('.live-caliber').change(function(){
  $('.live-preview .caption span:eq(3)').text($(this).val());
});
$('.live-size').keyup(function(){
  $('.live-preview .caption span:eq(5)').text( $(this).val());
});
$('.live-city').keyup(function(){
  $('.live-preview .caption span:eq(7)').text($(this).val());
});
$('.live-address').keyup(function(){
  $('.live-preview .caption span:eq(9)').text($(this).val());
});
$('.live-shop').keyup(function(){
  $('.live-preview .caption span:eq(11)').text( $(this).val());
});

$('#photo').change(function(e){
  var tmp_name    = $("#photo").val();
  var fileName    = e.target.files[0].name;
  var size        = e.target.files[0].size;
  var avatar_type = e.target.files[0].type;
  var path        = "uploads/photos/";
  //document.write(tmp_name);
$.ajax({
  url:'avatar.php',
  data:{fileName:fileName,tmp_name,tmp_name,size,size,avatar_type,avatar_type},
  contentType:"multipart/form-data",
  success:function(data)
  {
    $('.live-preview img').attr("src",path+data);
  }
})

});


</script>
