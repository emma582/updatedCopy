<?php


$role = $_POST['role'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$contactno = $_POST['contact_no'];
$year = $_POST['year'];
$semester = $_POST['semester'];
$email = $_POST['email_id'];
$password = $_POST['password'];

$connection = mysqli_connect("localhost","root","","wisdom");
if($connection->connect_error){
    die('Connection Failed');
}
    else{
        $stmt= $connection->prepare("INSERT INTO `usertable`( `role`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `contact_no`, `year`, `semester`, `email_id`, `password`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isssssissss",$role,$firstname,$middlename,$lastname,$gender,$date_of_birth,$contactno,$year,$semester,$email,$password);
        $stmt->execute();
        echo "<script>alert('Registered Successfully')</script>";
        //header('Location: index.html');
        $stmt->close();
       $connection->close();
    }
 header('Location : index.html');
     
    
?>