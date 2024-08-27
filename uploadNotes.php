<?php
$year=$_POST['year'];
$subject=$_POST['subject'];
$file=$_FILES['fileupload'];
$connection =  mysqli_connect("localhost","root","","wisdom");
if($connection -> connect_error){
    die('Connection Failed');
}
else{
    $stmt = $connection->prepare("INSERT INTO `notes_table`(`year`, `subject`, `file`) VALUES (?,?,?)");
    $stmt->bind_param("ssb",$year,$subject,$file);
    $stmt->execute();
    echo "<script>alert('Notes Uploaded Successfully!');</script>";
    $stmt->close();
    $connection->close();
}   

?>
