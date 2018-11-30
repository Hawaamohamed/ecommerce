<?php

//Categories Page
ob_start();
session_start();
   $pageTitle='Categories';
   if(isset($_SESSION['username'])){

	    include 'init.php';

		$do="";
		if(isset($_GET['do']))
        {
         $do=$_GET['do'];
        }
		else{
			$do='manage';
		}
        //**************************** Manage Members *************************\\
		 if ($do=='manage')
     {
       $sort='ASC';
       $sort_array=array('ASC','DESC');
       if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
         $sort=$_GET['sort'];
       }
       $stmt2=$con->prepare("SELECT * FROM category WHERE parent=0 ORDER BY ordering $sort");
       $stmt2->execute();
       $cats=$stmt2->fetchAll(); ?>

       <h1 class='text-center'>Manage Categories</h1>
       <div class='container categories'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            Manage Categories
            <div class='option pull-right'>
              <i class='fa fa-sort'></i>Ordering [
              <a class="<?php if($sort=='ASK'){echo 'active';} ?>" href='?sort=ASC'>ASC</a> |
              <a class="<?php if($sort=='DESC'){echo 'active';} ?>" href='?sort=DESC'>DESC</a> ]
              <i class='fa fa-eye'></i>Viewing [
              <span class='active' data-view='full'>Full |</span>
              <span data-view='classic'>Classic </span> ]
            </div>
          </div>
          <div class='panel-body'>
            <?php
             foreach($cats as $cat)
             {
             echo "<div class='cat'>";
              echo "<div class='hidden-buttons'>";
                echo "<a href='categories.php?do=Edit&catid=" . $cat['id'] . "'class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                echo "<a href='categories.php?do=delete&catid=" . $cat['id'] . "' class='btn btn-xs btn-danger confirm'><i class='fas fa-times'></i>Delete</a>";
               echo "</div>";
               echo "<h3>" . $cat['name'] . '</h3>';
               echo "<div clas='full-view'>";
               echo "<p>"; if($cat['description'] == ''){echo 'This has no description';}else{echo $cat['description']; } echo '</p>';
               if($cat['visibility'] ==1){echo "<span class='visibility'><i class='fa fa-eye'></i>Hidden </span>";}
               if($cat['allow_comment'] ==1){echo "<span class='commenting'><i class='fa fa-close'></i>comment disabled</span>";}
                if($cat['allow_ads'] ==1){echo "<span class='advertises'><i class='fa fa-close'></i>Ads disabled</span>";}
               echo '<span>Allow Ads is ' . $cat['allow_ads'] . '</span>';
               echo "</div>";
            echo "</div>";

            // get child categories
           $childs=getAllFrom("*",'category',"WHERE parent= {$cat['id']}","",'id','ASC');
           if(!empty($childs))
           {
             echo "<h4 class='child-head'>Childs Categories</h4>";
             echo "<ul class='list-unstyled child-cats'>";
             foreach($childs as $child)
             {
               echo "<li><a href='categories.php?do=Edit&catid=" . $child['id'] ."'>".$child['name']."</a>";
               echo "<a href='categories.php?do=delete&catid=" . $child['id'] . "' class='confirm child-delete'>Delete</a>";

              echo "</li>";
             }
             echo "</ul>";
           }


            echo "<hr>";
             }
            ?>
          </div>
        </div>
        <a class='btn btn-primary add-category' href='categories.php?do=add'><i class='fa fa-plus'></i>Add New Category</a>
      </div>



  <?php   }
     elseif($do =='add'){ ?>


       <h2 class='text-center'> Add New Category </h2>
       <div class="container">
        <form class='form-horizontal' action="?do=insert" method="POST">

         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label"> Category Name </label>
            <div class="col-sm-10  col-md-4">
              <input type='text' name="name" class="form-control" autocomplete="off">
            </div>
         </div>
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label"> Description </label>
            <div class="col-sm-10  col-md-4">
              <input type='text' name="description"  class="form-control" >
            </div>
         </div>
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label"> Ordering </label>
            <div class="col-sm-10  col-md-4">
            <input type='text' name="ordering" class="ordering form-control" autocomplete="new-password">
          </div>
         </div>
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label"> Parent? </label>
            <div class="col-sm-10  col-md-4">
             <select name='parent'>
              <option value='0'>None</option>
              <?php
              // function getAllFrom($field,$fromtable,$where = Null,$orderBy,$ordering ='DESC')
               $allCates=getAllFrom("*",'category',"WHERE parent= 0","",'id','ASC');
              foreach($allCates as $cats)
              {
                echo "<option value='" . $cats['id'] . "'>" . $cats['name'] . "</option>";
              }
              ?>
             </select>

          </div>
         </div>

         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label"> Visibility </label>
            <div class="col-sm-10  col-md-4">
             <div>
               <input type='radio' id='vis-yes' name='visibility' value='0' checked>
               <label for='vis-yes'>Yes</label>
             </div>
             <div>
               <input type='radio' id='vis-no'name='visibility' value='1' >
               <label for='vis-no'>No</label>
             </div>
            </div>
         </div>
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Allow Comments </label>
            <div class="col-sm-10  col-md-4">
             <div>
               <input type='radio' id='com-yes' name='Comments' value='0' checked>
               <label for='com-yes'>Yes</label>
             </div>
             <div>
               <input type='radio' id='com-no'name='Comments' value='1' >
               <label for='com-no'>No</label>
             </div>
            </div>
         </div><div class="form-group form-group-lg">
           <label class="col-sm-2 control-label"> Allow Ads</label>
            <div class="col-sm-10  col-md-4">
             <div>
               <input type='radio' id='ads-yes' name='ads' value='0' checked>
               <label for='ads-yes'>Yes</label>
             </div>
             <div>
               <input type='radio' id='ads-no'name='ads' value='1' >
               <label for='ads-no'>No</label>
             </div>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <input type='submit' value="add category" class="btn btn-primary btn-lg">
            </div>
         </div>

       </form>
     </div>




  <?php   }    /******************* Insert **********************/
     elseif($do=='insert')
     {
          if($_SERVER['REQUEST_METHOD'] == 'POST')
          {
             echo "<h2 class='text-center'> Insert Category </h2>";
             echo "<div class='container'>";
            //get the variables from the form
           $name=$_POST['name'];
           $description=$_POST['description'];
           $ordering=$_POST['ordering'];
           $parent=$_POST['parent'];
           $visibility=$_POST['visibility'];
           $Comments=$_POST['Comments'];
           $ads=$_POST['ads'];

           if(empty($name))
           {
             echo "<div class='alert alert-danger'>NAme Can not be empty</div>";
           }
           else{

             //check if category exist in database
               $check=checkItem('name','category',$name);
               if($check==1)
               {
                 $themsg = "<div class='alert alert-danger'>sorry this Category is Exist</div>";
                 redirectHome($themsg,'back');
               }else{
          // Insert Category info In the database
                 $stmt=$con->prepare("INSERT INTO category(name,description,parent,ordering,visibility,allow_comment,allow_ads)
                                                  VALUES (:zname,:zdesc,:zparent,:zorder,:zvisib,:zcomm,:zads)");
                 $stmt->execute(array('zname' => $name,'zdesc' => $description,'zparent' => $parent, 'zorder' => $ordering,'zvisib' => $visibility, 'zcomm' => $Comments, 'zads' =>$ads));
                 $themsg ="<div class='alert alert-success'>" . $stmt->rowCount() . " Record Insert Successfully </div>";
                 redirectHome($themsg,'back');
          }
}
          }else{
             echo "<div class='container'>";
              $themsg="<div class='alert alert-danger'>You Can not browse this page directory</div>";
              redirectHome($themsg,'back');
              echo "</div>";
          }
            echo "</div>";
          }

     else if($do=='Edit')
     {
       //check if Get Request Catid is Numeric & Get integer value of it
       $catid;
            if(isset($_GET['catid']) && is_numeric($_GET['catid']))
       {
         $catid=intval($_GET['catid']);
       }else{
         $catid= 0;
       }
        //Select All Data Depend on this id
       $stmt=$con->prepare("SELECT * FROM category where id=?");
       //Execute the Data
         $stmt->execute(array($catid));

         $cat=$stmt->fetch();  // return data from database;

         $count=$stmt->rowCount();
       // if there is such id show the form
         if($count > 0)
         {?>

           <h2 class='text-center'> Edit Category </h2>
           <div class="container">
            <form class='form-horizontal' action="?do=update" method="POST">

            <input type='hidden' name='catid' value="<?php echo $catid; ?>" >

             <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label"> Category Name </label>
                <div class="col-sm-10  col-md-4">
                  <input type='text' name="name" class="form-control" value='<?php echo $cat['name']; ?>'>
                </div>
             </div>
             <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label"> Description </label>
                <div class="col-sm-10  col-md-4">
                  <input type='text' name="description"  class="form-control" value='<?php echo $cat['description']; ?>'>
                </div>
             </div>
             <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label"> Parent? </label>
                <div class="col-sm-10  col-md-4">
                 <select name='parent'>
                   <option value='0'>None</option>
                    <?php  $parent=getAllFrom("*",'category',"WHERE parent= 0","",'id','ASC');
                    foreach($parent as $c)
                    {
                    echo "<option value='{$c['id']}'" ;
                    if($cat['parent'] == $c['id']){echo 'selected';}
                    echo ">" . $c['name'] . "</option>";
                   }
                    ?>
                  </select>

              </div>
             </div>

             <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label"> Ordering </label>
                <div class="col-sm-10  col-md-4">
                <input type='text' name="ordering" class="ordering form-control" value='<?php echo $cat['ordering']; ?>'>
              </div>
             </div>
             <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label"> Visibility </label>
                <div class="col-sm-10  col-md-4">
                 <div>
                   <input type='radio' id='vis-yes' name='visibility' value='0' <?php if($cat['visibility'] == 0){echo 'checked'; } ?> >
                   <label for='vis-yes'>Yes</label>
                 </div>
                 <div>
                   <input type='radio' id='vis-no'name='visibility' value='1' <?php if($cat['visibility'] == 1){echo 'checked'; } ?>>
                   <label for='vis-no'>No</label>
                 </div>
                </div>
             </div>
             <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Allow Comments </label>
                <div class="col-sm-10  col-md-4">
                 <div>
                   <input type='radio' id='com-yes' name='Comments' value='0' <?php if($cat['allow_comment'] == 0){echo 'checked'; } ?>>
                   <label for='com-yes'>Yes</label>
                 </div>
                 <div>
                   <input type='radio' id='com-no'name='Comments' value='1' <?php if($cat['allow_comment'] == 1){echo 'checked'; } ?>>
                   <label for='com-no'>No</label>
                 </div>
                </div>
             </div><div class="form-group form-group-lg">
               <label class="col-sm-2 control-label"> Allow Ads</label>
                <div class="col-sm-10  col-md-4">
                 <div>
                   <input type='radio' id='ads-yes' name='ads' value='0' <?php if($cat['allow_ads'] == 0){echo 'checked'; } ?>>
                   <label for='ads-yes'>Yes</label>
                 </div>
                 <div>
                   <input type='radio' id='ads-no'name='ads' value='1' <?php if($cat['allow_ads'] == 1){echo 'checked'; } ?>>
                   <label for='ads-no'>No</label>
                 </div>
                </div>
             </div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type='submit' value="save category" class="btn btn-primary btn-lg">
                </div>
             </div>

           </form>
         </div>

     <?php }
       //if theres No such id in database Show Error Message
     else {
        echo "<div class='container'>";
       $themsg= "<div class='alert alert-danger'>Theres No Such This ID </div>";
        redirectHome($themsg,'back');
        echo "</div>";
     }


     }
    elseif($do=='update')
    {
      echo "<h2 class='text-center'> Update Category </h2>";
     echo "<div class='container'>";
     if($_SERVER['REQUEST_METHOD'] == 'POST')
     {
       //get the variables from the form
      $id=$_POST['catid'];
      $name=$_POST['name'];
      $description=$_POST['description'];
      $ordering=$_POST['ordering'];
      $visibility=$_POST['visibility'];
      $Comments=$_POST['Comments'];
      $ads=$_POST['ads'];

     // Update the category in database with this info
      $stmt=$con->prepare("UPDATE category SET name=? , description=? , ordering=? , visibility=? , allow_comment=? , allow_ads=? where id=?");
      $stmt->execute(array($name,$description,$ordering,$visibility,$Comments,$ads,$id));
      $themsg="<div class='alert alert-danger'>". $stmt->rowCount()  . " Record Update </div> ";
       redirectHome($themsg,'back');




}
    }
    elseif($do == 'delete')
    {
      echo "<h2 class='text-center'> Delete Category </h2>";
      echo "<div class='container'>";
      $catid;
          if(isset($_GET['catid']) && is_numeric($_GET['catid']))
      {
        $catid=intval($_GET['catid']);
      }else{
        $catid= 0;
      }
      //Select All Data Dependent on UserId;
       $check = checkItem('id','category',$catid);
      // if there is such id show the form
        if($check > 0)
        {
         $stmt=$con->prepare("DELETE FROM category WHERE id=:zid");
         $stmt->bindParam(":zid",$catid);
         $stmt->execute();
         $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted </div>";
         redirectHome($themsg,'back');
       }else{

         $themsg = "<div class='alert alert-danger'>this id is not exist</div>";
         redirectHome($themsg);
       }
       echo "</div>";

    }

   include $tpl . 'footer.php';
}
   else{

    header("Location: index.php");
    exit();
   }
ob_end_flush();

?>
