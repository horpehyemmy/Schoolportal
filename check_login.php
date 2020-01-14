<?php
$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()){
	echo "error:could not connect to database.please try again later.";
	exit;
}

$username = $_POST['username'];//set username
$password = $_POST['password'];//sets password
$msg=" ";
if (isset($username,$password)) {
	$myusername = stripslashes($username);
	$mypassword = stripslashes($password);
	$myusername = 
	mysqli_real_escape_string($db,$myusername);
	$mypassword = 
	mysqli_real_escape_string($db,$mypassword);
	$sql = "select * from login_admin where user_name ='$myusername' and user_pass = sha1('$mypassword')";
	$result = mysqli_query($db,$sql);
	//counting row
	$count = mysqli_num_rows($result);

	if($count ==1){
		//register username and password
		session_register("admin");
		session_register("password");
		$_SESSION['name'] = $myusername;
		header("location:portal.php");
	}
	else{
		$msg = "wrong username or password.
		Please retry" ;
		echo $msg;

	}
	ob_end_of_flush();

}
else{
	echo "Please enter some username and password";
}





?>