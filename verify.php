<?php
$emailid = $_POST['email'];
$password = $_POST['pass'];
$conn = mysqli_connect("localhost","root","","wisdom");
if(!$conn){
    die('Connection failed');
}

$sql = "SELECT  `email_id`, `password` FROM `user_table` WHERE `email_id`='$emailid' AND `password`='$password' ";
$result = $conn->query($sql);
if($result->num_rows > 0){
    echo "<script>alert('Login successful');</script>";
}
else{
    echo "<script>alert('Invalid email or password!');</script>";
    
}

 
?>