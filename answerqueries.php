<?php
$year = $_POST['year'];
$answer = $_POST['answer'];

$connection =  mysqli_connect("localhost","root","","wisdom");
if($connection -> connect_error){
    die('Connection Failed');
}
else{
    $stmt = $connection->prepare("INSERT INTO `answer_table`(`year`, `answer`) VALUES (?,?)");
    $stmt->bind_param("ss",$year,$answer);
    $stmt->execute();
    echo "<script>alert('Answer Posted Successfully!');</script>";
    $stmt->close();
    $connection->close();
}   
?>