<?php 
session_start();

// $user_id=$_SESSION['id'];

$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()) {
	echo "error:could not connect to database.please try again later.";
	exit;
}
			$size = count($_POST['score']);
			 
               $i =0;
			  //start a loop to update the record
			  $score = array();
			  while ($i < $size){
			  	$score = $_POST['score'][$i];
			  	$assessment = $_POST['id'][$i];
			  	$max_score = $_POST['max_score'][$i];
			 	$id = $_REQUEST['id'];

			  	$query_again = "UPDATE student_results SET score = '$score',max_score = '$max_score' WHERE id = '$assessment' LIMIT 1";
			    $result_again = $db->query($query_again);
			  	++$i;
            }

            if($result_again){
            	// echo('Update Successfull');
            	// header('Location:biodata.php?id='.$user_id);
            	echo "update successful";
            }
            else{
            	echo "No";
            }



?>