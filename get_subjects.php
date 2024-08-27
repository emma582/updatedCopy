<?php
$link = mysqli_connect("localhost","root","","files_uploading");
// Assuming you've already connected to your database
$selectedSemester = $_POST['semester']; // Get the selected semester from the form

// Query to fetch subjects for the selected semester
$query = "SELECT name FROM subjects WHERE semester = '$selectedSemester'";
$result = mysqli_query($link, $query);

// Create the second dropdown with subjects
echo '<label for="subjects">Select Subject:</label>';
echo '<select name="subjects" id="subjects">';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select>';
?>
