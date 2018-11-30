<?php

include "Admin/connect.php";
//Select All Data Depend on this id
$itemid=$_REQUEST['itemid'];

$stmt=$con->prepare("SELECT * FROM items where itemid = ?");
//Execute the Data
 $stmt->execute(array($itemid));
  $item=$stmt->fetch();
  $data['gm']      = $item['grammes'];
  $data['cal']     = $item['caliber'];
  $data['size']    = $item['size'];
  $data['city']    = $item['city'];
  $data['address'] = $item['address'];
  $data['shop']    = $item['shop'];
  $data['img']     = $item['image'];
  $data['date']    = $item['add_date'];

  echo json_encode($data);



?>
