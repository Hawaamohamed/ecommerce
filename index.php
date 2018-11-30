<?php
   ob_start();
    session_start();
    $pageTitle="HomePage";
     include "init.php";

?>
<style>
.thumbnail{
  padding:8px;
  border: none;
}
.caption{
  font-size:12px;
}
.thumbnail h3{
      color: #c18221;
}
.item-info ul li{
  padding:7px;
}
a:hover , a:active{
  text-decoration: none;
}
.item-box img{
  max-height: 20%;
  padding:4% 0 -7% 5%;
  margin:0% 0%;
  width:100%;
  border-radius:4% 4% 0 0;
  margin-bottom: 0px;
}

.div1:hover{
	background:rgba(3,3,3,0.3);
	cursor:pointer;
	border-radius:4%;
}
.item-box{
	background-color:#e2e2df;
	height:auto;
	padding:0px;
	border-radius:4%;
	margin-bottom:5%;
  box-shadow: none;
}
.item-box a{
	color:#c18221;/*#d80b8e;/*#ffc006;  yellow*/
	font-family: 'Indie Flower', cursive;
}
.name{
	margin-top:0px;
  color:#ffc006;
}
.search select{
    width: 75%;
    height: 35px;
    margin-top:10px;
    border-radius: 5px;
}
.thumbnail img {
    height: 260px;
}
.item-box img:hover {
 transform:scale(1.1,1.1) rotate(360deg);
  border:2px solid #ffc006;
  transition:all 4s ease-in-out;
}
.modal-body .img-modal{
  max-width: 120%;
  max-height: 70%;
}
</style>
  <div class='container'>
    <div class='row' style="margin-top:50px;">
     <div class='col-sm-6 form-inline search my-2 my-lg-0'>

<?php
   $stmt2=$con->prepare("SELECT * FROM shops");
   $stmt2->execute();
   $shops= $stmt2->fetchAll();
 ?>
         <select class="selectpicker show-tick" id='search_input'>
           <option value=''>Choose Shop Name</option>
           <?php
           foreach($shops as $shop)
           {
              echo "<option value='".$shop['id']."'>". $shop['name'] . "</option>";
           }
           ?>

         </select>
         <button class="btn btn-outline-success my-2 my-sm-0" id='search_btn' style="margin-top: -5px;background: #e0459a;color: white;"placeholder="Choose Shop Name" type="submit">Search</button>

     </div>
    </div>
     <div class='row'><br><br>
     <?php
     //function getAllFrom($field,$fromtable,$where = Null,$orderBy,$ordering ='DESC')
     $items=getAllFrom('*','items','','itemid','ASC');
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
                                      <div class='col-sm-6'><span style='width:100%;'>Grammes Number</span></div>
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
                                        <div class='col-sm-6'><span>Shop</span></div>
                                        <div class='col-sm-6'><span id="shop"> </span> </div>
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
                              <?php echo "<img src=''class='img-responsive center-block img-modal'>"; ?>
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

     ?>

     </div>
   </div>
  <?php include $tpl . "footer.php";?>
  <script src="layout/js/jquery-1.12.4.min.js"></script>


  <script>

  var btn_id     = document.getElementById('search_input').value;
  var search_btn = document.getElementById('search_btn');

   search_btn.onclick=function(){
     'use strict';
    if(btn_id=='')
    {
      window.alert('Choose Correct Value');
    }
  }





  $(document).ready(function(){




    $('#search_btn').click(function(){
       var shop_name = $("#search_input").val();
       if(shop_name !='')
       {
       $.ajax({
         url:'search.php',
         type:'POST',
         data:{shop_name:shop_name},
         success:function(data){
           window.location.href = "http://localhost/eCommerce/shop.php?shopid="+data;
         }
       })
     }

    });



    $('.thumbnail a').click(function(){
     var itemid = $(this).attr('id');
     var path   = "uploads/photos/";
     $.ajax({
       url:"show_item.php",
       type:'POST',
       data:{itemid:itemid},
       dataType:"JSON",
       success:function(data){
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
 <?php ob_end_flush(); ?>
