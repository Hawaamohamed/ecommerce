
<?php
   include 'connect.php';

   //Routes

    $tpl= "include/templetes/";     //Templete Directory
    $css="layout/css/";            // Css Directory
    $js="layout/js/";
    $images="layout/images/";         // images Directory
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
?>
