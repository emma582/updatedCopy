<?php
$conn=mysqli_connect("localhost","root","","files_uploading");
if(isset($_POST['submit'])){
  $fullName = $_POST['fullName'];
  $courseName = $_POST['courseName'];
     if(!empty($fullName) && !empty($courseName)){
      $query = "INSERT INTO students (fullName, courseName) VALUES('$fullName', '$courseName')";
      $result = $conn->query($query);
     
      if($result){
        echo "Student detail is inserted successfully";
      }  
    }
  }

if(isset($_POST['submit'])){
  $courseName = $_POST['courseName'];
  if(!empty($courseName)){
      $query = "INSERT INTO courses (courseName) VALUES('$courseName')";
      $result = $conn->query($query);
      if($result){
        echo "Course is inserted successfully";
      }  
    }
  }
?>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
<input type="text" name="fullName" value="">
<select name="courseName">
<select name="courseName">
  <option value="">Select Course</option>
  <option value="web Designing">Web Designing</option>
  <option value="web Development">Web Development</option>
  <option value="app Development">app development</option>
  <option value="game development">Game Development</option>
  <option value="graphic Designing">Graphic Desiging</option>
  <option value="digital marketing">Digital Marketing</option>
</select>
    <option value="">Select Course</option>
    <?php 
    $query ="SELECT courseName FROM courses";
    $result = $conn->query($query);
    if($result->num_rows> 0){
        while($optionData=$result->fetch_assoc()){
        $option =$optionData['courseName'];
    ?>
    <?php
    //selected option
    if(!empty($courseName) && $courseName== $option){
    // selected option
    ?>
    <option value="<?php echo $option; ?>" selected><?php echo $option; ?> </option>
    <?php 
continue;
   }?>
    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
   <?php
    }}
    ?>
</select>