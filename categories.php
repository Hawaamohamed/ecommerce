<?php
session_start();
$pageTitle='Category';
include "init.php";
?>
<style>
.thumbnail img{
  height:250px;
}
.modal-body .img-modal{
  max-width: 120%;
  max-height: 70%;
}
</style>
<br><br>
<div class='container'>


<div class='row'>
<?php
//$category=isset($_GET['pageid']) && is_numeric($_GET['pageid'])? intval($_GET['pageid']): 0;
if(isset($_GET['pageid']) && is_numeric($_GET['pageid']))
{
 $category = intval($_GET['pageid']);
  $stmt2=$con->prepare("SELECT id,name FROM category where id ={$category}");
  $stmt2->execute();
  $get=$stmt2->fetch();

 $items=getAllFrom("*","items","WHERE catid = {$category}","itemid",$ordering ='DESC');
?>
   <h1 class='text-center'> <?php echo $get['name']; ?> Category</h1>
<?php
 foreach($items as $item)
 {
   echo "<div class='col-sm-4 col-md-3'>";
    echo "<div class='thumbnail item-box'>";
    echo '<input type="hidden" name=\'catid\' value="'.$item['itemid'].'">';
     echo '<a href="#myModal"   role="botton" type="submit" data-toggle="modal" id="'.$item['itemid'] .'">';
      echo "<div class='div1'>";
       echo "<img src='uploads/photos/" . $item['image'] ."'class='img-responsive center-block'>";
      echo "</div>";
      echo "<div class='caption name'>";
       echo  "<h3>" . $item['shop'] . " Shop </h3>";
       echo  "caliber: ".$item['caliber']."<br>";
      echo '</div>';

       echo "</a>";
       ?>
       <!-- Pop Up -->
       <div class='container'>
          <div id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Item</h4>
                      </div>
                     <div class="modal-body">
                         <div class='row'>
                        <div class='col-md-7 item-info'>
                          <ul class='list-unstyled'>

                              <li>
                                <div class='row'>
                                 <div class='col-sm-6'><span  style='width:100%;'>Grammes Number</span></div>
                                 <div class='col-sm-6'><span id="gm"> </span></div>
                               </div>
                             </li>

                              <li>
                                <div class='row'>
                                 <div class='col-sm-6'><span>Caliber </span> </div>
                                 <div class='col-sm-6'><span id="cal"> </span></div>
                               </div>
                             </li>

                              <li>
                               <div class='row'>
                                 <div class='col-sm-6'> <span> Size</span> </div>
                                 <div class='col-sm-6'><span id="size"></span></div>
                               </div>
                              </li>
                              <li>
                                <div class='row'>
                                   <div class='col-sm-6'> <span>City</span> </div>
                                   <div class='col-sm-6'><span id="city"> </span></div>
                                 </div>
                              </li>


                              <li>
                                <div class='row'>
                                 <div class='col-sm-6'> <span>Address</span></div>
                                 <div class='col-sm-6'><span id="ad"> </span></div>
                               </div>
                              </li>



                              <li>
                                <div class='row'>
                                   <div class='col-sm-6'><span>Added Date</span></div>
                                   <div class='col-sm-6'> <span id="date"> </span></div>
                                 </div>
                              </li>
                         </ul>
                        </div>
                        <div class='col-md-4'>
                         <?php echo "<img src='uploads/photos/" . $item['image'] ."'class='img-responsive img-modal center-block'>"; ?>
                        </div>
                      </div>
                     </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Ok</button>
                      </div>
                  </div>
              </div>
          </div>
        </div>
       <?php
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
 <script>
 $(document).ready(function(){


       $('.thumbnail a').click(function(){
        var itemid = $(this).attr('id');
        var path        = "uploads/photos/";
        $.ajax({
          url:"show_item.php",
          type:'POST',
          data:{itemid:itemid},
          dataType:"JSON",
          success:function(data){
            //document.write(data.gm);
            $(".modal-body #gm").html(data.gm);
            $(".modal-body #cal").html(data.cal);
            $(".modal-body #size").html(data.size);
            $(".modal-body #city").html(data.city);
            $(".modal-body #ad").html(data.address);
            $(".modal-body #date").html(data.date);
            $(".modal-body #shop").html(data.sh);
            $(".modal-body img").attr('src',"uploads/photos/"+data.img);
          }

        })

       });

 })
 </script>
