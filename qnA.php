<?php
$roll = $_POST['roll_no'];
$year = $_POST['year'];
$query = $_POST['query'];

$connection = mysqli_connect("localhost","root","","wisdom");
if($connection -> connect_error){
    die('Connection Failed');
}
else{
    $stmt = $connection->prepare("INSERT INTO `qna_table`(`roll_no`, `class`, `query`) VALUES (?,?,?)");
    $stmt->bind_param("iss",$roll,$year,$query);
    $stmt->execute();
    echo "<script>alert('Queriess Posted Successfully!');</script>";
    $stmt->close();
    $connection->close();
}   
?>