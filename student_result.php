<?php
$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()){
	echo "error:could not connect to database.please try again later.";
	exit;
}

//function to connect and execute query
// echo "Welcome"." ".$_POST['username'];

session_start();

$user_check = $_SESSION['name'];
// echo "<h3>Now at the Welcome page</h3>";
$ses_sql = mysqli_query($db,"select user_name from login_admin where user_name = '$user_check' ");
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
$login_session = $row['user_name'];
if(!isset($_SESSION['name'])){
	header("location:index.php");
}
?>
<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="js/jquery-1.12.3.js"></script>
    <script type="text/javascript" src="js/dataTables.min.js"></script>
    <title>Welcome to Admin:area</title>
    	
    <script type="text/javascript">
    	$(document).ready(function() {
            $('#example').DataTable();
        } );
	</script>
</head>
<body>


<header>

	<!-- <img src="pictures/logo.png"/> -->
	<h1 id="name">Credence University</h1>
	<p>Welcome <i class="fa fa-user-o" aria-hidden="true"></i>
 <?php echo $login_session ; ?>!!</p>
	<h2><a href="logout.php">Sign Out</a>
		<i class="fa fa-user-o" aria-hidden="true"></i>

	<h3>STUDENTS</h3>

</header>


	<div class="container">

		<aside>
			<main class="cd-main-content">
	<nav class="cd-side-nav">
		<ul>
			<li class="cd-label">Main</li>
			<li class="class="dropdown"">
				<a href="#0"class="dropbtn">Admission</a>
				<div class="dropdown-content">
					<a href="#">New Students</a>
					<a href="#">Existing Students</a>

			</li>
			<li class="class="dropdown"">
				<a href="#0" class="dropbtn">Results<span class="count"></span></a>
				<div class="dropdown-content">
				<a href="student_result.php">view results</a>
				<a href="edit.php">Edit results</a>
			</li>

			<li class="class="dropdown"">
				<a href="#0"class="dropbtn">Courses</a>
				<div class="dropdown-content">
					<a href="#">Register courses</a>
					<a href="#">Edit/add courses</a>
					<a href="#">View courses</a>
				
			</li>
			<li class="class="dropdown"">
				<a href="#0"class="dropbtn">Accomodation</a>
				<div class="dropdown-content">
					<a href="#">Generate invoice</a>
					<a href="#">Payment</a>
					<a href="#">Book bed space</a>
				
			</li>


			
		</ul>
 
		<!-- other unordered lists here -->
	</nav>
</main> <!-- .cd-main-content -->


		</aside>

		
	<section>
	
<?php


 


$query_student="SELECT students.id,students.matric_number,students.last_name,students.first_name,students.other_name,levels.name ,departments.name AS dep_name
				FROM students
				JOIN levels ON students.level_id=levels.id
				JOIN departments ON students.department_id=departments.id";
$result_student=$db->query($query_student);

?>
<p>
	
 <table id="example" class="display" width="100%" cellspacing="0">
	<thead>
	<tr>
		<th>MATRIC NUMBER</th>
		<th>NAME</th>
		<th>LEVEL</th>
		<th>DEPARTMENT</th>
		<th>VIEW</th>
		
	</tr>
</thead>
<tbody>
	
	<tr>
	<?php 


	while ($row = mysqli_fetch_array($result_student)){

		echo "<td>".$row['matric_number']."</td>";
		echo "<td>".$row['first_name']." ".$row['last_name']." ".$row['other_name']."</td>";
		echo "<td>".$row['name']."</td>";
		echo "<td>".$row['dep_name']."</td>";
		echo "<td><a href='biodata.php?id=".$row['id']."'>View Result</a></td></tr>";

		
		$row++;
	}
		
	?>
</tbody>
</table> 
</p>

</section>
</div>

<footer id="footer">&copy; Copyright 2016
Credence University</footer>

</body>
	</html>