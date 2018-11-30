<?php

function getTitle()
{
	global $pageTitle;

	if(isset($pageTitle))
	{
		echo $pageTitle;
	}
	else{
		echo "Default";
	}

}


function getAllFrom($field,$fromtable,$where = Null,$orderBy,$ordering ='DESC'){
	global $con;
	$getAll=$con->prepare("SELECT $field FROM $fromtable $where ORDER BY $orderBy $ordering");
	$getAll->execute();
	$all = $getAll->fetchAll();
	return $all;
}



// Home Redirect Function
// Function for Errors

function redirectHome($errormsg,$url = null,$seconds = 4)
{
	if($url === null)
	{
		$url = 'index.php';
		$link = 'Homepage';
	}
	else{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '')
		{
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'Previous';
		}else{
			$url='index.php';
		  $link = 'Homepage';
		}
	}
  echo $errormsg;
  echo "<div class='alert alert-info'> You Will Be Redirect to $link After $seconds Seconds. </div>";

  header("refresh:4;url=$url");
  exit();

}



// Function to check item in database
function checkItem($select,$from,$value)
{
	global $con;
	$statement=$con->prepare("SELECT $select FROM $from WHERE $select=?");
	$statement->execute(array($value));
	$count=$statement->rowCount();
	return $count;
}


// Count Numbers Of Items Function v1
//function to count Numbers of items $rows
function countItems($item,$table){
	global $con;
	$stmt2=$con->prepare("SELECT COUNT($item) FROM $table");
	$stmt2->execute();
	return $stmt2->fetchColumn();
}


//function to get Categorys from database
function getcats(){
	global $con;
	$getcats=$con->prepare("SELECT * FROM category ORDER BY id ASC");
	$getcats->execute();
	$cats = $getcats->fetchAll();
	return $cats;
}
//function to get items from database
function getitems($where,$value,$approve = NULL){
	if($approve == NULL){
		$sql = "And approve = 1";
	}else{
		$sql = NULL;
	}
	global $con;
	$getitems=$con->prepare("SELECT * FROM items WHERE $where= ? $sql ORDER BY itemid DESC");
	$getitems->execute(array($value));
	$items = $getitems->fetchAll();
	return $items;
}
//Function to check if user is not Active
// Function to check if the RagStatus of user
function checkUserStatus($user)
{
	global $con;
	$stmtx=$con->prepare('SELECT username , ragstatus FROM users WHERE username=? AND ragstatus=0');
  $stmtx->execute(array($user));
  $status=$stmtx->rowCount();
	return $status;
}

?>
