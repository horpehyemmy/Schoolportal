
<?php
$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()){
	echo "error:could not connect to database.please try again later.";
	exit;
}
session_start();
if(isset($_POST['submit'])){//username and password sent from form
	$myusername = mysqli_real_escape_string($db,$_POST['username']);	 
	$mypassword = mysqli_real_escape_string($db,$_POST['password']);
   $_SESSION['name'] = $myusername;
    
	$sql = "SELECT * from login_admin where user_name ='$myusername' and user_pass ='$mypassword'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result);
	//$active = $row['active'];
	//counting row

	$count = mysqli_num_rows($result);
	if($row){
		print_r($row);
		// session_register("myusername");
         $_SESSION['name'] = $myusername;
         header("Location:student_result.php");

	}else{

		$error = "Your Login Name or Password is invalid";
		// echo $error;
	
	}
}?>
<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<style>
body{
	background-color: snow;
	padding: 0px;	
	margin: 0px auto;
	overflow-x:hidden;
	}
input[type=text],input[type=password]{
	
	width:100%;
	padding:12px 20px;
	margin:8px 0;
	border:1px solid #ccc;
	display: inline-block;
	border-radius:4px;
	

}
input[type=submit]{
	width:100%;
	background-color: #009933;
	color:white;
	padding: 14px 20px;
	border:none;
	border-radius: 4px;
	cursor: pointer;

}
input[type=submit]:hover{
	background-color:turquoise;
}
.loginpage{
	border-radius: 5px;
	background-color: #f2f2f2;
	padding: 100px;
	width: 50%;
	margin:20px 120px;
	border: 500px;


}
#form{
	margin-top:-100px;
	padding: 100px;
	overflow: hidden;
		

}


	header{
	padding: 10px 20px;
	display: block;
	background-color: #009933;
	min-height:100px;
	width:100%;
	position: relative;
	overflow: auto;
	overflow: hidden;
	}
	
	header h1{
		margin: 0px;
		
	}
	header h3{
		margin: 0px;
		
	}
	header img{
			float:left;
			width:100px;
			height:auto;
			margin:10px;
		}
</style>
</head>
<body>
	<header>
	<h1>Credence University</h1>
	<img src="pictures/logo.png"/>
	<h3 style="text-align:center;font-size:20px;">Admin Login Page</h3>
</header>
<section>
	
<div id="form">
<form method="post" action="">
	
	<div class="loginpage">
		<?php 
	global $error;
	if(isset($error)){
	?><h4 style="color:red;"> <?php echo $error; }?></h4>
	Username:
	<input type="text" name="username" value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']);?>"><br>
	password:
	<input type="password" name="password" placeholder="password"><br>
	<input type="submit" name="submit" value="login">
   </div>
</form>
</div>
</section>

</body>
</html>