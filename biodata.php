<?php 
$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()) {
	echo "error:could not connect to database.please try again later.";
	exit;
}

session_start();
$user_check = $_SESSION['name'];
// echo "<h3>Now at the Welcome page</h3>";
$ses_sql = mysqli_query($db,"select user_name from login_admin where user_name = '$user_check' ");
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
$login_session = $row['user_name'];

?>
<html>
	<head>
			<title>Admin:area</title>
			<link rel="stylesheet" type="text/css" href="style2.css">
			

			
	</head>
<body>
	<header>
	<h1>Credence University</h1>
	<img src="pictures/logo.png"/>
	<p>Welcome <i class="fa fa-user-o" aria-hidden="true"></i>
 <?php echo $login_session ; ?>!!</p>
	<h2><a href="logout.php">Sign Out</a>
	<h3 style="text-align:center;font-size:20px;">Admin Login Page</h3>
</header>
<div class="container">

		<!-- <aside>
		<ul>
			<li><a href="">About</a></li>
			<li><a href="">Admission</a></li>
			<li><a href="portal.php">Results</a></li>
			<li><a href="">Students</a></li>
			<li><a href="">Accomodation</a></li>
			<li><a href="">Courses</a></li>
		</ul>
		</aside> -->
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
// session_start();

if(isset($_GET['id']))
$id=$_GET['id'];

$query_session="SELECT * FROM sessions";
$result_session=$db->query($query_session);

// $query_semester="SELECT * FROM semesters";
// $result_semester=$db->query($query_semester);
$query_current_session ="SELECT * FROM current_session";
$result_current_session = $db->query($query_current_session);
$fetch_current_session = mysqli_fetch_array($result_current_session);
if($fetch_current_session)

?>

<h2 id="contact">THE RESULT FOR 
	 <?php
	// if(isset($_GET['id']))
	// 	$id=$_GET['id'];
		$query_student="SELECT students.id,students.matric_number,students.last_name,students.first_name,students.other_name,
				        levels.name ,departments.name AS dep_name
						FROM students
						JOIN levels ON students.level_id=levels.id
						JOIN departments ON students.department_id=departments.id
						where students.id = $id";
		$result_student=$db->query($query_student);
		// print_r($result_student);
		$display = mysqli_fetch_array($result_student);
		if (isset($display)) {
			# code...
		
		echo "<td>".$display['matric_number']."</td>";
		echo "<td>". " ";
		echo "<td>".$display['last_name']." ".$display['first_name']." ".$display['other_name']."</td>";
		echo "<td>". " ";
		echo "<td>".$display['name']."</td>";
		echo "<td>". " ";
		echo "<td>".$display['dep_name']."</td>";
		echo "<td>". " ";
		}
	?>


</h2>

<h4>
	<div id="form">
	<form method="post" action="biodata.php?id=<?php echo $_GET['id']?>"> 
		<label for "session">Session:</label>
		<select  name="session">
			<option value="session">session<br></option>
<?php
$query_session="SELECT * FROM sessions";
$result_session=$db->query($query_session ); 
while ($resource_session=mysqli_fetch_array($result_session)) {
	echo "<option value=\"{$resource_session['id']}\">{$resource_session['name']}</option>";
	// echo "<button type="edit">"edit"</button>";
	$resource_session++;
	}


	$session_check = $_SESSION['session'];
	// if($session_check){
	// 	echo "I exit";
	// 	exit();
	// }else{
	// 	echo "Am Not Exitinggggg.";
	// 	exit();
	// }
// echo "<h3>Now at the Welcome page</h3>";
$ses_sql = mysqli_query($db,"select session_id from student_results where session_id = '$session_check' ");
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
$login_session = $row['session_id'];


?>
</select>
<td colspan="5"><button type="submit" name="submit">Click to view result</button></td>				
</form>
</div>
</h4>

<?php

// if(!isset($_SESSION['session'])){
// 	header("location:index.php");
// }
?>

<h2>FIRST SEMESTER</h2>
<?php
$sql = "SELECT id,name from assessments";
$result = mysqli_query($db,$sql);

$assessments = array();
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$assessments[] = $row;
	}
}

//outputs the result row by row
if (isset($_POST['submit'])) {
	$valuetodisplay = $_POST['session'];
	$sql ="SELECT courses.code, courses.title, courses.unit, student_results.assessment_id, assessments.name, 
		 student_results.score,student_results.max_score,student_results.session_id
		 from student_results
		 JOIN assessments on student_results.assessment_id = assessments.id 
		 JOIN courses on student_results.course_id = courses.id
		 JOIN students on student_results.student_id = students.id
		 JOIN sessions on sessions.id=student_results.session_id
		 WHERE student_results.semester_id=1
		 AND student_results.student_id =$id
		 AND student_results.session_id =$valuetodisplay";
		 $result = mysqli_query($db,$sql);

		 
} else{

$sql = "SELECT courses.code, courses.title, courses.unit, student_results.assessment_id, assessments.name, 
		student_results.score,student_results.max_score,student_results.session_id,current_session.session_id
		 from student_results
		 JOIN assessments on student_results.assessment_id = assessments.id 
		 JOIN courses on student_results.course_id = courses.id
		 JOIN students on student_results.student_id = students.id
		 JOIN sessions on sessions.id=student_results.session_id
		 JOIN current_session on sessions.id = current_session.session_id
		 WHERE student_results.semester_id=1
		 AND student_results.student_id =$id";

$result = mysqli_query($db,$sql) or die(mysql_errno());

}
$student_results = array();
// print_r($result);

if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)){
		$student_results[] = $row;
	}
}
else{
	$empty= "<td colspan='3'>No records found</td>";
	echo "<td>$empty</td>";
	exit;
}

$display_result= array();
foreach ($student_results as $student_result) {
	$course_code = $student_result['code'];
	$course_title = $student_result['title'];
	$course_unit = $student_result['unit'];
	$key = $course_code . " -" .$course_title. " -" .$course_unit;

	$display_result[$key][] = $student_result;
}
?>
<table>
<tr>
			<!--<th>S/N</th>-->
			<th>S/N</th>
			<th>COURSE CODE</th>
			<th>COURSE TITLE</th>
			<th>UNIT</th>

			<?php
			foreach($assessments as $assessment){
				echo "<th>{$assessment['name']}</th>";
			}
			?>

			<th>GRADE</th>
			
		</tr>
		<?php
		$number = 1;
		$total = 0;
		$qq = 0;

		foreach($display_result as $key => $values){
			$add = 0;
			list ($course_code,$course_title,$course_unit) = explode("-", $key);
			$wi_id_array = explode("-", $key);
			echo '<tr>';
			echo '<td>' . $number. '</td>';

			echo '<td>' . $wi_id_array[0] . '</td>';
			echo '<td>' . $wi_id_array[1] . '</td>';
			$total += $wi_id_array[2];
			// $totalnumber +=$number;
			echo '<td>' . $wi_id_array[2] . '</td>';
			$number++;
			
			foreach ($assessments as $assessment) {
				foreach ($values as $val) {
					if ($val['assessment_id'] == $assessment['id']) {

						echo "<td>" . $val['score']. '/'.$val['max_score'] . "</td>";

						$add += $val['score'];

				}
			}
		}
	

		echo '<td>' . $add . '</td>';
		$val ++;
		$result = mysqli_query($db,"select * from grades");

		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				global $add;
				if($add >=$row{'lower_limit'} && $add <= $row{'upper_limit'}){
					echo '<td id="grade">' . $row{'name'} . '</td>';
					 echo "</tr>";
					$view = $row{'points'} * $wi_id_array[2];
					// echo $view;

					$qq += $view;
					$gp = $qq / $total;

				}
				// echo "<td><a href='edit.php?id=".$row['id']."'>edit</a></td></tr>";

			}
			// global $row;
			// echo "<td><a href='edit.php?id=".$row['id']."'>edit</a></td></tr>";

		}
		


		
		echo '</tr>';
	}
	?>	
	<tr><td colspan="3"><h3 style="text-align:center">Total number of Units:</td><td><?php echo $total;?></h3></td></tr>
	<tr><td colspan="3"><h3 style="text-align:center">GP:</td><td>&nbsp;<?php echo number_format($gp,2);?></h3></td></tr>

	
</table>
	
<h2>SECOND SEMESTER</h2>
<?php
$sql = "SELECT id,name from assessments";
$result = mysqli_query($db,$sql);

$assessments = array();
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$assessments[] = $row;
	}
}
//outputs the result row by row

$sql = "SELECT courses.code, courses.title, courses.unit, student_results.assessment_id, assessments.name, 
		student_results.score,student_results.max_score,student_results.session_id,current_session.session_id
		 from student_results
		 JOIN assessments on student_results.assessment_id = assessments.id 
		 JOIN courses on student_results.course_id = courses.id
		 JOIN students on student_results.student_id = students.id
		 JOIN sessions on sessions.id=student_results.session_id
		 JOIN current_session on sessions.id = current_session.session_id
		 WHERE student_results.semester_id=2
		 AND student_results.student_id =$id";
$result = mysqli_query($db,$sql) or die(mysql_errno());

$student_results = array();

if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)){
		$student_results[] = $row;
	}
}
else{
	$empty= "<td colspan='3'>No records found</td>";
	echo "<td>$empty</td>";
	exit;
}

	$display_result= array();
foreach ($student_results as $student_result) {
	$course_code = $student_result['code'];
	$course_title = $student_result['title'];
	$course_unit = $student_result['unit'];
	$key = $course_code . " -" .$course_title. " -" .$course_unit;


	$display_result[$key][] = $student_result;
}
?>

<table>
<tr>
			<!--<th>S/N</th>-->
			<th>S/N</th>
			<th>COURSE CODE</th>
			<th>COURSE TITLE</th>
			<th>UNIT</th>

			<?php
			foreach($assessments as $assessment){
				echo "<th>{$assessment['name']}</th>";
			}
			?>

			<th>GRADE</th>

		</tr>
		<?php
		$number = 1;
		$total = 0;
		$qq = 0;

		foreach($display_result as $key => $values){
			$add = 0;
			list ($course_code,$course_title,$course_unit) = explode("-", $key);
			$wi_id_array = explode("-", $key);
			echo '<tr>';
			echo '<td>' . $number. '</td>';

			echo '<td>' . $wi_id_array[0] . '</td>';
			echo '<td>' . $wi_id_array[1] . '</td>';
			$total += $wi_id_array[2];
			// $totalnumber +=$number;
			echo '<td>' . $wi_id_array[2] . '</td>';
			$number++;
			
			foreach ($assessments as $assessment) {
				foreach ($values as $val) {
					if ($val['assessment_id'] == $assessment['id']) {
						echo '<td>' . $val['score'] .'<b>/</b>'.$val['max_score']. '</td>';

						$add += $val['score'];

				}
			}
		}
	

		echo '<td>' . $add . '</td>';
		$val ++;
		$result = mysqli_query($db,"select * from grades");

		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				global $add;

				if($add >=$row{'lower_limit'} && $add <= $row{'upper_limit'}){
					echo '<td>' . $row{'name'} . '</td>';
					$view = $row{'points'} * $wi_id_array[2];
					// echo $view;

					$qq += $view;
					$gp = $qq / $total;
				}
			}
		}

		echo '</tr>';
	}
	?>	

	<tr><td colspan="3"><h3 style="text-align:center">Total number of Units:</td><td><?php echo $total;?></h3></td></tr>
		<tr><td colspan="3"><h3 style="text-align:center">GP:</td><td>&nbsp;<?php echo number_format($gp,2);?></h3></td></tr>

	
</table>
</section>
</div>
<section>
<footer>&copy; Copyright 2016
Credence University</footer>
</section>
</body>

</html>


