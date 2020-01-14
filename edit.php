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
<?php
if(isset($_POST['submit'])){
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

 

}



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
		<form id="edit" action="" method="post">
			
			<label for "Course">Course:</label>
		<select  name="course">
			<option value="">course<br></option>
			<?php
			$query_courses="SELECT * FROM courses ORDER BY code ASC";
			$result_courses=$db->query($query_courses); 
			while ($resource_courses=mysqli_fetch_array($result_courses)) {
				echo "<option value=\"{$resource_courses['id']}\">{$resource_courses['code']}</option>";
				// echo "<button type="edit">"edit"</button>";
				$resource_courses++;
				}

			?>
       </select>
	<label for "Department">Department:</label>
		<select  name="department">
			<option value="">department<br></option>
			<?php
			$query_department="SELECT * FROM departments ORDER BY name ASC";
			$result_department=$db->query($query_department); 
			while ($resource_department=mysqli_fetch_array($result_department)) {
				echo "<option value=\"{$resource_department['id']}\">{$resource_department['name']}</option>";
				// echo "<button type="edit">"edit"</button>";
				$resource_department++;
				}
			?>
		</select>

		<label for "Assessment">Assessment:</label>
		<select  name="assessment">
			<option value="">assessment<br></option>
			<?php
			$query_assessment="SELECT * FROM assessments ORDER BY name ASC";
			$result_assessment=$db->query($query_assessment); 
			while ($resource_assessment=mysqli_fetch_array($result_assessment)) {
				echo "<option value=\"{$resource_assessment['id']}\">{$resource_assessment['name']}</option>";
				// echo "<button type="edit">"edit"</button>";
				$resource_assessment++;
				}
			?>
		</select>
		<input type="submit" name="edit" value="edit result">
	<!-- </form> -->
		
		<?php
		if (isset($_POST['edit'])) {

			$coursetodisplay = $_POST['course'];
			$assessmenttodisplay = $_POST['assessment'];
			$departmenttodisplay = $_POST['department'];

			$_SESSION['course'] = $coursetodisplay;
			$_SESSION['assessment'] = $assessmenttodisplay;
			$_SESSION['department'] = $departmenttodisplay;

			$coursetodisplay=$_SESSION['course'];
			$assessmenttodisplay=$_SESSION['assessment'];
			$departmenttodisplay=$_SESSION['department'];


            $errors=array();
			$display = array($coursetodisplay,$assessmenttodisplay,$departmenttodisplay);
			foreach ($display as $value) {
				if (!isset($value) || empty($value)) {
					# code...
					$errors[]=$value;
				
				}
				# code...
			}
			if(!empty($errors)){
				echo('<p><b>please enter all the required fields</b></p>');
			}else{
				
			$query = "SELECT courses.code, courses.title, courses.unit, student_results.assessment_id, assessments.name, student_results.score,
		             student_results.max_score,student_results.session_id,
		             student_results.id,students.department_id,students.first_name,students.other_name,students.last_name 
		             from student_results 
		             JOIN assessments on student_results.assessment_id = assessments.id 
		             JOIN courses on student_results.course_id = courses.id 
		             JOIN students on student_results.student_id = students.id
					WHERE student_results.course_id = $coursetodisplay 
					AND student_results.assessment_id = $assessmenttodisplay 
					AND student_results.course_id = $coursetodisplay";
					
					$result=$db->query($query);

					 $i = 0;
					 

					 print'<form action="" method="post" name="update" >';
					
				?>
				<table> 
	
					<tr>
						<th>STUDENT</th>
						<th>SCORE</th>
					</tr>
					
					
				<?php
		   		if (mysqli_num_rows($result) > 0) {
					 while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						echo "<tr>";
						echo "<td>".$row['first_name']." ".$row['last_name']." ".$row['other_name']."</td>";
						
						 // echo "<td><input type='text' name='assessment[$i]' value='{$row['name']}'</td>";
						 echo "<td><input type='text' name='score[$i]' value='{$row['score']}'</td><br>";
						  echo "<td><input type='hidden' name='id[$i]' value='{$row['id']}'</td>";
						 echo "</tr>";
						  echo "<td>Max-score:<input type='text' name='max_score[$i]' value='{$row['max_score']}'</td>";
						  $i++;

					}

					 echo '<input type="submit" name="submit" value="update">';
			 		echo "</form>";
				}else{
					echo "<td colspan='2'>No entries found</td>";
		   	}
					
			}	    

		 } else{
					echo "<br>";
					echo "<b><td colspan='2'>Enter valid details</td></b><br>";

    }
    global $result_again;

    if($result_again){
            	// echo('Update Successfull');
            	// header('Location:biodata.php?id='.$user_id);
            	echo "update successful!";
            }
            // else{
            // 	echo "No";
            // }	
	?>
</table>
</form>
</section>

<br>
 
</body>

</html>


