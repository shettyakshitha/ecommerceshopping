<?php
//establishing a connection to the MYSQL database
$db = new mysqli("localhost","root","","mydatabase");

//check for connection errors
if(!$db){
  die("connection failes:" .$db->connect_error);
}

//retrive username and password from POST data
$username = $_POST['username'];
$password = $_POST['password'];

//check if the username already exists
$check_query = "SELECT *FROM users WHERE username = '$username'";
$check_result = $db->query($check_query);

if($check_result->num_rows>0){
  //username already exists,display alert and redirect back to singnup.html
  echo '<script>alert("username alredy exists.
  please choose different username.");
  window.location.href="signup.html";</script>';
  exit();
}

//insert the new user if the username doesnot exit
$sql="INSERT INTO users (username,password)
VALUES('$username','$password')";

if(mysqli_query($db,$sql)=== TRUE){
  //if insertion is successful,redirect to signin.html
  header("Location:signin.html");
  exit();

}else{
  //if there's an error during insertion,display the erroe message
  echo "Error:".mysqli_error($db);


  $db->close();
}
?>