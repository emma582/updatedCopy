<?php
$role=$_POST['role'];
$firstname=$_POST['firstname'];
$middlename=$_POST['middlename'];
$lastname=$_POST['lastname'];
$gender=$_POST['gender'];
$dateofbirth=$_POST['dateofbirth'];
$phonenumber=$_POST['Phonenumber'];
$emailid=$_POST['emailid'];
$password=$_POST['password'];

$connection = mysqli_connect("localhost","root","","wisdom");
if($connection->connect_error){
    die('Connection Failed');
}
    else{
        $stmt = $connection->prepare("INSERT INTO `usertable`(`role`,`first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `contact_no`,`email_id`,`password`) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("isssssiss",$role,$firstname,$middlename,$lastname,$gender,$dateofbirth,$phonenumber,$emailid,$password);
     $stmt->execute();
     echo "<script>alert('Registered Successfully!');</script>";
     echo "<script>document location = 'index.php'; </script>";
     $stmt->close();
    $connection->close();
    } 

?>
