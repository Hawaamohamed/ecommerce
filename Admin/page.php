<?php 

$do="";

if(isset($_GET['do']))
{
   $do=$_GET['do'];
	
}else{
	$do='manage';
}

if($do=="manage")
{
	
	echo "welcom in manage page";
}
else if($do=="do")
{
	echo "welcom in Do page" ;
}