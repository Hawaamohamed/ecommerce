
<?php
ob_start();
  $SessionUser='';
  if(isset($_SESSION['user']))
  {
    $SessionUser=$_SESSION['user'];
  }
///////////////////////////////////////////
   include 'Admin/connect.php';
   //Routes
    $tpl= "include/templetes/";     //Templete Directory
    $css="layout/css/";            // Css Directory
    $js="layout/js/";             // js Directory
    $images="layout/images/";
    $lang='include/languages/';   //languages Directory
    $func='include/functions/';   // functions Directory

  include $func . 'function.php';   // For Title , Must be the first include
  include $lang . 'english.php';
//  include $lang . 'arabic.php';
	include $tpl . 'header.php';

	//include Navbar on all pages Expect the one with noNavbar variable
  if(!isset($noNavbar))
	{
	 include $tpl . 'navbar.php';
	}
 ob_end_flush();
?>
