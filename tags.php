<?php
$pageTitle='Category';
include "init.php";
?>
<div class='container'>
<div class='row'>
<?php
if(isset($_GET['name']))
{
   $tag = $_GET['name'];
  echo "<h1 class='text-center'>" .  $tag . "</h1>";


 $tagitems=getAllFrom("*","items","WHERE tags LIKE '%$tag%' AND approve = 1","itemid",$ordering ='DESC');
 foreach($tagitems as $item)
 {
   echo "<div class='col-sm-6 col-md-3'>";
     echo "<div class='thumbnail item-box'>";
       echo "<span class='price-tag'>" . $item['price'] . "</span>";
       echo "<img src='". $images . "4.jpg' alt='' class='img-responsive center-block'>";
       echo "<div class='caption'>";
          echo '<h3> <a href="items.php?pageid="'.$item['catid']. ">". $item['name'] . "</a></h3>";
          echo "<p>" . $item['description'] . "</p>";
          echo "<div class='date'>" . $item['add_date'] . "</div>";
       echo "</div>";
     echo "</div>";
  echo "</div>";
}
}else{
  echo "You Must Enter Page ID";
}
?>
</div>
</div>



 <?php  include $tpl . "footer.php";  ?>
