<?php

session_start();
include "include/functions/function.php";
include "Admin/connect.php";

$fileName    = $_REQUEST['fileName']; // 4.jpg
$tmp_name    = $_REQUEST['tmp_name'];
$size        = $_REQUEST['size'];    // 4407
$photo_type  = $_REQUEST['avatar_type']; // image/jpg
$photoAllowedExtention = array('jpeg','jpg','png','svg');

$photoExtention = strtolower(end(explode('/',$photo_type))); // jpg
$photoTmp       = explode($fileName,$tmp_name); // C:folder/

//echo $avatarTmp[0];

if(!empty($fileName) && !in_array($photoExtention,$photoAllowedExtention))
{
  echo "Sorry This Extention is Not Allowed";
}
if($size > 4194304)
{
  echo "Image Size Very Large";
}
 //$photo=rand(0,1000000) . '_' . $fileName;
 //move_uploaded_file($tmp_name,"uploads\photos\\" . $fileName);

    //echo "uploads\avatar\\" . $avatar;
    //insert Avatar
  //  $stmt3=$con->prepare("INSERT INTO items(image) VALUES(:zimg)");
  //  $stmt3->execute(array('zimg' => $fileName));
        //echo "photo";
        echo $fileName;





 ?>
