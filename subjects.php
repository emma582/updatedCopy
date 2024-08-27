<?php
require_once "config.php";
// Assuming you've already connected to your database
$selectedClass = $_POST['class']; // Get the selected semester from the form

// Query to fetch subjects for the selected semester
$query = "SELECT subject_name FROM subject_table WHERE semester = '$selectedClass'";
$result = mysqli_query($link, $query);

// Create the second dropdown with subjects
echo '<label for="subjects">Select Subject:</label>';
echo '<select name="subjects" id="subjects">';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<option value="' . $row['subject_name'] . '">' . $row['subject_name'] . '</option>';
}
echo '</select>';
?>
