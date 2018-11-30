<?php

ob_start();
include "init.php";
//Select All Data Depend on this id
$itemid=$_REQUEST['itemid'];

$stmt=$con->prepare("DELETE FROM items WHERE itemid=:zitem");
$stmt->bindParam(":zitem",$itemid);
$stmt->execute();

ob_end_flush();
?>
