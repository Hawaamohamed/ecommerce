<?php
ob_start();
session_start();
$pageTitle="Profile";
 include "init.php";

 echo $SessionUser;
if(isset($_SESSION['user']))
{
  $getUser=$con->prepare('SELECT * FROM users WHERE username=?');
  $getUser->execute(array($SessionUser));
  $info=$getUser->fetch();
 ?><br><br>
<h1 class='text-center'>My Profile</h1>
<div class='information block'>
 <div class='container'>
  <div class='panel panel-success'>
    <div class='panel-heading'>My Information</div>
    <div class='panel-body'>
      <ul class='list-unstyled'>
     <li><i class='fa fa-unlock-alt fa-fw'></i> <span>Name</span> : <?php echo $info['username'] ?></li>
     <li><i class="fas fa-envelope"></i> <span>Email</span> &nbsp;: <?php echo $info['email'] ?></li>
     <li><i class='fa fa-calendar fa-fw'></i> <span>Register Date</span> : <?php echo $info['date'] ?></li>

   </ul>

  </div>
 </div>
</div>
</div>

<div class='ads block' id='my-ads'>
 <div class='container'>
  <div class='panel panel-warning'>
    <div class='panel-heading'>My Items</div>
    <div class='panel-body'>
      <?php
      if(! empty(getitems('memberid',$info['userid'])))
      {
        echo "<div class='row'>";
      $items=getitems('memberid',$info['userid']);
       foreach($items as $item)
       {
         echo "<div class='col-sm-4 col-md-3'>";
          echo "<div class='thumbnail item-box'>";
            echo "<div class='div1'>";
             echo "<img src='uploads/photos/" . $item['image'] ."'class='img-responsive center-block'>";
            echo "</div>";
            echo "<div class='caption name'>";
             echo  "<h3>" . $item['shop'] . " Shop </h3>";
             echo  "caliber: ".$item['caliber']."<br>";

             echo '<a href="#myModal" role="botton" class="btn btn-danger pull-right delete" type="submit" data-id="'. $item['itemid'] .'" data-toggle="modal">Delete</a>';
            // echo '<a href="edit_item.php?itemid='. $item['itemid']. '"role="botton" class="btn btn-info pull-left edit" data-id="'. $item['itemid'] .'" data-toggle="modal">Edit</a>';
            echo '</div>';


             ?>
             <!-- Delete Pop Up -->
             <div class='container'>
                <div id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Confirmation</h4>
                            </div>
                           <div class="modal-body">
                               <div class='row'>
                              <div class='col-md-7 item-info'>
                              Are You Sure that You Want To Delete This Item ?
                              </div>
                            </div>
                          </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary yes" data-dismiss="modal">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>
              </div>




             <?php
             echo "</div>";
          echo "</div>";
       }
       echo "</div>";
     }else{
       echo "There is No Items";
     }

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

?>

 <?php  include $tpl . "footer.php";  ?>
<script>


$(document).ready(function(){

  $(".delete").on('click',function(){
   var item= $(this).data('id');
   $(".yes").attr('id',item);
   $(".yes").click(function(){
      var itemid = $(".yes").attr('id');
      $.ajax({
        url:'delete.php',
        type:"POST",
        data:{itemid,itemid},
        success:function(){
          location.reload();
        }
      });
   })
  });



  $(".edit").on('click',function(){
   var item= $(this).data('id');
   $(".update").attr('id',item);

   $.ajax({
     url:'edit.php',
     type:"POST",
     data:{item,item},
     success:function(data){
       $("input.itemid").attr('value',data);
     }
   });


   $(".update").click(function(){
      var itemid = $(".update").attr('id');
      $.ajax({
        url:'edit.php',
        type:"POST",
        data:{itemid,itemid},
        success:function(data){
          document.write(data);
        }
      });
   })
  });

})
</script>
<?php ob_end_flush(); ?>
