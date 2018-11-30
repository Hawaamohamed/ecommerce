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


//function to get latest items from database
function getLatest($select,$table,$order,$limit = 5){
	global $con;
	$getstmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC limit $limit");
	$getstmt->execute();
	$rows = $getstmt->fetchAll();
	return $rows;
}



?>
