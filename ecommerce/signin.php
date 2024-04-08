<?php
//start a session to manage user session

session_start();

//establish a connection to the MYSQL database
$db= new mysqli("localhost","root","","mydatabase");

//check foe connection erros
if($db->connect_error){
  die("Connection failed" .$db->connect_error);
}

//check if the request method is POST (from submission)
if($_SERVER["REQUEST_METHOD"]=="POST"){
  //Retrieve username  and password from POST data
  $username = $_POST['username'];
  $password = $_POST[ 'password' ];

  //Use a prepared statement to prevent SQL injection
  $query = "SELECT * FROM users WHERE username=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("s",$username);
  $stmt->execute();
  $result = $stmt->get_result();

  //check if any rows are returned (if the username exists)
  if($result->num_rows>0){
    //fetch the row

    $row = $result->fetch_assoc();

    //use strcmp to compare the password entered with
    //the hased password from the database

    //  In simpler terms, this conditional statement
    //  checks if the entered password matches the password stored in the
    //   $row 
    //  array retrieved from the database. If they match exactly, 
     // the condition will be true.

     if(strcmp($password,$row['password']==0)){
    //password match,set session variable and redirect to index.html
      $_SESSION['username']=$username;
      header("location:index.html");
     exit();
    
  }else{
    // Passwords don't match, display error message and redirect back to signin.html
    echo '<script>alert("Invalid password");
    window.location.href="signin.html";</script>';
  }
  }else{
      // Username not found, display error message and redirect back to signin.html
      echo '<script>alert("user not found");
      window.location.href="signin.html";</script>';
  }
  //close the prepared statement
  $stmt->close();
}
// Close the database connection
$db->close();
?>