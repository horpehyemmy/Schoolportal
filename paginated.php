<html>
<?php
$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()){
	echo "error:could not connect to database.please try again later.";
	exit;
}

/*

VIEW-PAGINATED.PHP

Displays all data from 'students' table

This is a modified version of view.php that includes pagination

*/




$per_page = 3;



// figure out the total pages in the database

$query = "SELECT students.id,students.matric_number,students.last_name,students.first_name,students.other_name,levels.name ,departments.name AS dep_name FROM students
	JOIN levels ON students.level_id=levels.id
	JOIN departments ON students.department_id=departments.id";
	$result=$db->query($query);


$total_results = mysqli_num_rows($result);

$total_pages = ceil($total_results / $per_page);



// check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)

if (isset($_GET['page']) && is_numeric($_GET['page']))

{

$show_page = $_GET['page'];



// make sure the $show_page value is valid

if ($show_page > 0 && $show_page <= $total_pages){

	$start = ($show_page -1) * $per_page;

	$end = $start + $per_page;
}else{

	// error - show first set of results

	$start = 0;

	$end = $per_page;
}
}

else{

	// if page isn't set, show first set of results

	$start = 0;

	$end = $per_page;

}



// display pagination



echo "<p><a href='view.php'>View All</a> | <b>View Page:</b> ";

for ($i = 1; $i <= $total_pages; $i++){

echo "<a href='paginated.php?page=$i'>$i</a> ";

}

echo "</p>";



// display data in table

echo "<table border='1' cellpadding='10'>";

echo "<tr>
		<th>MATRIC NUMBER</th>
		<th>NAME</th>
		<th>LEVEL</th>
		<th>DEPARTMENT</th>
		<th>VIEW</th>
		
	</tr>";



// loop through results of database query, displaying them in the table

for ($i = $start; $i < $end; $i++)

{

// make sure that PHP doesn't try to show results that don't exist

if ($i == $total_results) { break; }

while ($row = mysqli_fetch_array($result)){

		echo "<td>".$row['matric_number']."</td>";
		echo "<td>".$row['first_name']." ".$row['last_name']." ".$row['other_name']."</td>";
		echo "<td>".$row['name']."</td>";
		echo "<td>".$row['dep_name']."</td>";
		echo "<td><a href='edit.php?id=".$row['id']."'>Edit</a></td>";
		echo "<td><a href='delete.php?id=".$row['id']."'>Delete</a></td></tr>";
	

		
		$row++;
	}
		
		

// echo out the contents of each row into a table



}

// close table>

echo "</table>";



// pagination



?>

<p><a href="new.php">Add a new record</a></p>



</body>

</html>
