<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Dropdown Example</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form method="POST" action="">
    <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
            <option value=""></option>
            <option value="Semester-I">Semester-I</option>
            <option value="Semester-II">Semester-II</option>
            <option value="Semester-III">Semester-III</option>
        </select>

        <label for="subjects">Select Subject:</label>
        <select id="subjects" name="subjects">
            <!-- Subjects will be populated dynamically using JavaScript -->
        </select>
    </form>

    <script>
        $(document).ready(function () {
            // Handle semester dropdown change
            $('#semester').change(function () {
                const selectedSemester = $(this).val();

                // Send AJAX request to get subjects for the selected semester
                $.ajax({
                    url: 'get_subjects.php', // PHP script to retrieve subjects
                    method: 'POST',
                    data: { semester: selectedSemester },
                    success: function (response) {
                        // Update subjects dropdown
                        $('#subjects').html(response);
                    }
                });
            });
        });
        
    </script>
</body>
</html>
