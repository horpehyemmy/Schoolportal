<?php
$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()){
	echo "error:could not connect to database.please try again later.";
	exit;
}
?>
<html>
<head>
<title>Admin page to add or edit result</title>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<header>

	<img src="pictures/logo.png"/>
	<h1 id="name">Credence University</h1>
	
	<h3>STUDENTS</h3>

</header>
<div class="container">

		<aside>
		<ul>
			<li><a href="">About</a></li>
			<li><a href="">Admission</a></li>
			<li><a href="portal.php">Results</a></li>
			<li><a href="">Students</a></li>
			<li><a href="">Accomodation</a></li>
			<li><a href="">Courses</a></li>
		</ul>
		</aside>
		<section>
		<form action="" method = "post">
		<select name="action">
		<option value = "Add">Add</option>
		<option value = "Edit">Edit</option>
	</select>

	
	<form method="post" action=""> 
		<label for "Assessments">Assessment</label>
		<select  name="assessment">
			<option value="session">assessment<br></option>
<?php
$query_assessment="SELECT * FROM assessments";
$result_assessment=$db->query($query_assessment ); 
while ($resource_assessment=mysqli_fetch_array($result_assessment)) {
	echo "<option value=\"{$resource_assessment['id']}\">{$resource_assessment['name']}</option>";
	// echo "<button type="edit">"edit"</button>";
	$resource_assessment++;
	}

	?>	
</select>
</p>
<?php




// get results from database

// $result = mysql_query("SELECT * FROM students") or die(mysql_error());

$query_student="SELECT students.id,students.matric_number,students.last_name,students.first_name,students.other_name,levels.name ,departments.name AS dep_name
				FROM students
				JOIN levels ON students.level_id=levels.id
				JOIN departments ON students.department_id=departments.id";
$result_student=$db->query($query_student);
?>
<p><b>View All</b> | <a href='paginated.php?page=1'>View Paginated</a></p>


<p>
	
 <table id="example" class="display" width:"100%" cellspacing="0">
	<thead>
	<tr>
		<th>MATRIC NUMBER</th>
		<th>NAME</th>
		<th>LEVEL</th>
		<th>DEPARTMENT</th>
		<th>ACTION</th>
		
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
		echo "<td><a href='edit.php?id=".$row['id']."'>Edit</a></td>";
		echo "<td><a href='delete.php?id=".$row['id']."'>Delete</a></td></tr>";
	

		
		$row++;
	}
		
	?>
</tbody>
</table> 


<p><a href="new.php">Add a new record</a></p>



</body>

</html>

</section>
</div>

<footer id="footer">&copy; Copyright 2016
Credence University</footer>




</div>
</body>
</html>