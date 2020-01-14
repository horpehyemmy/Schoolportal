<?php
$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()){
	echo "error:could not connect to database.please try again later.";
	exit;
}
session_start();

$user_check = $_SESSION['name'];
$ses_sql = mysqli_query($db,"select user_name from login_admin where user_name = '$user_check' ");
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
$login_session = $row['user_name'];
if(!isset($_SESSION['name'])){
	header("location:index.php");
}
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styling.css">
	<!-- <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="path/to/font-awesome/css/font-awesome.min.css"> -->
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
	<header class="cd-main-header">
		<a href="#0" class="cd-logo"><img src="img/cd-logo.svg" alt="Logo"></a>
		
	<div class="cd-search">
		<p>Welcome <i class="fa fa-user-o" aria-hidden="true"></i>
 		<?php echo $login_session ; ?>!!</p>
		<i class="fa fa-user-o" aria-hidden="true"></i>
        <h3>STUDENTS</h3>
		<h1 id="name" style="color:white; margin:-15px; font-size:20px;">Credence University</h1>
	</div> <!-- cd-search -->

		<a href="#0" class="cd-nav-trigger">Dashboard<span></span></a>

		<nav class="cd-nav">
			<ul class="cd-top-nav">
				<li><a href="#0">About</a></li>
				<li class="has-children account">
					<a href="#0">
						<img src="img/cd-avatar.png" alt="avatar">
						Account
					</a>

					<ul>

						<li><a href="#0">My Account</a></li>
						<li><a href="#0">Edit Account</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</header> <!-- .cd-main-header -->

	<main class="cd-main-content">
		<nav class="cd-side-nav">
			<ul>
				<li class="cd-label">Main</li>
				<li class="has-children overview">
					<a href="#0">Admission</a>	
					<ul>
						<li><a href="#0">New Students</a></li>
						<li><a href="#0">Existing Students</a></li>
					</ul>
			   </li>
			   <li class="has-children notifications active">
					<a href="#0">Results<span class="count">3</span></a>
				
					<ul>
						<li><a href="#0">View results</a></li>
						<li><a href="#0">Edit Students</a></li>
						<!-- other list items here -->
					</ul>
				</li>

				<li class="has-children comments">
					<a href="#0">Students</a>
					
					<ul>
						<li><a href="#0">Registration</a></li>
						<li><a href="#0">Edit profile</a></li>
						<li><a href="#0">Check status</a></li>
						<li><a href="#0">Check results</a></li>
					</ul>
				</li>
			</ul>

			<ul>
				<li class="cd-label">Others</li>
				<li class="has-children bookmarks">
					<a href="#0">Accomodation</a>
					
					<ul>
						<li><a href="#0">Check status</a></li>
						<li><a href="#0">Apply for hostel</a></li>
						<li><a href="#0">Generate invoice</a></li>
						<li><a href="#0">payment</a></li>

					</ul>
				</li>
				<li class="has-children images">
					<a href="#0">Courses</a>
					
					<ul>
						<li><a href="#0">Register courses</a></li>
						<li><a href="#0">Edit/add courses</a></li>
						<li><a href="#0">View courses</a></li>
					</ul>
				</li>

				<li class="has-children users">
					<a href="#0">Payment</a>
					
					<ul>
						<li><a href="#0">School fees</a></li>
					<li><a href="#0">Accomodation</a></li>
					<li><a href="#0">Miscellaneous</a></li>

					</ul>
				</li>
			</ul>

			<!-- <ul>
				<li class="cd-label">Action</li>
				<li class="action-btn"><a href="#0">+ Button</a></li>
			</ul> -->
		</nav>
 </main>
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
		 <!-- .content-wrapper -->
	 <!-- .cd-main-content -->
<script src="js/jquery-2.1.4.js"></script>
<!-- <script src="js/jquery.menu-aim.js"></script>
 --><!-- <script src="js/main.js"></script> --> <!-- Resource jQuery -->
</body>
</html>