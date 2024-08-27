<?php
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$database = 'files_uploading';

	$con = mysqli_connect($host, $user, $password, $database);

	if (!$con){
		?>
			<script>alert("Connection Unsuccessful!!!");</script>
		<?php
	}
?>

<?php
	if (isset($_POST['submit'])) {

		$name = $_POST['name'];

		if (isset($_FILES['pdf_file']['name']))
		{
		$file_name = $_FILES['pdf_file']['name'];
		$file_tmp = $_FILES['pdf_file']['tmp_name'];

		move_uploaded_file($file_tmp,"./pdf/".$file_name);

		$insertquery = 
		"INSERT INTO pdf_data(username,filename) VALUES('$name','$file_name')";
		$iquery = mysqli_query($con, $insertquery);
		}
		else
		{
		?>
			<div class=
			"alert alert-danger alert-dismissible 
			fade show text-center">
			<a class="close" data-dismiss="alert"
				aria-label="close">×</a>
			<strong>Failed!</strong> 
				File must be uploaded in PDF format!
			</div>
		<?php
		}
	}
?>
<form method="POST" action="" enctype="multipart/form-data">
	<div class="form-input py-2">
		<div class="form-group">
		<input type="text" class="form-control" name="name"
				placeholder="Enter your name" required>
		</div>								 
		<div class="form-group">
		<input type="file" name="pdf_file"
				class="form-control" accept=".pdf"
				title="Upload PDF"/>
		</div>
		<div class="form-group">
		<input type="submit" class="btnRegister"
				name="submit" value="Submit">
		</div>
</div>
</form>

