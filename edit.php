<?php
ob_start();
session_start();
include "Admin/connect.php";

     $gram=filter_var($_POST['gm'], FILTER_SANITIZE_NUMBER_INT);
     $cal=filter_var($_POST['cal'], FILTER_SANITIZE_STRING);
     $size=filter_var($_POST['size'], FILTER_SANITIZE_NUMBER_INT);
     $city=filter_var($_POST['city'], FILTER_SANITIZE_STRING);
     $address=filter_var($_POST['ad'], FILTER_SANITIZE_STRING);
     $shop=filter_var($_POST['sh'], FILTER_SANITIZE_STRING);
     $category=filter_var($_POST['category'], FILTER_SANITIZE_STRING);

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

     if(empty($error))
     {

    // Insert the Item In the database
           $stmt=$con->prepare("UPDATE items SET grammes=?,caliber=?,size=?,city=?,address=?,shop=?,category=?,add_date=?,memberid=?,catid=?");
           $stmt->execute(array($gram,$cal,$size, $city,$address,$shop,$category,$_SESSION['uid']));

        foreach($error as $err)
        {
          echo   $err . '<br>';
        }

      }

ob_end_flush();

 ?>
