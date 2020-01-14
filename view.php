<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>New Record</title>

</head>

<body>

<?php

$db=new mysqli('localhost','root',"",'student_portal');
if(mysqli_connect_errno()){
	echo "error:could not connect to database.please try again later.";
	exit;
}
function renderForm($first, $last, $error)

{


// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<div>

<strong>First Name: *</strong> <input type="text" name="firstname" value="<?php echo $first; ?>" /><br/>

<strong>Last Name: *</strong> <input type="text" name="lastname" value="<?php echo $last; ?>" /><br/>

<p>* required</p>

<input type="submit" name="submit" value="Submit">

</div>

</form>

</body>

</html>

<?php

}


// check if the form has been submitted. If it has, start to process the form and save it to the database

if (isset($_POST['submit']))

{

// get form data, making sure it is valid

$firstname = mysqli_real_escape_string($db,htmlspecialchars($_POST['firstname']));

$lastname = mysqli_real_escape_string($db,htmlspecialchars($_POST['lastname']));



// check to make sure both fields are entered

if ($firstname == '' || $lastname == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again

renderForm($firstname, $lastname, $error);

}

else

{

// save the data to the database

$query ="INSERT students SET first_name='$firstname', last_name='$lastname'";

$result=$db->query($query);



// once saved, redirect back to the view page

header("Location: view.php");

}

}

else

// if the form hasn't been submitted, display the form

{

renderForm('','','');

}

?>

