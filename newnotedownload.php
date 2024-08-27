<?php
$connection = mysqli_connect("localhost","root","","wisdom");
if(!$connection){
    die('Connection Failed');
}
$sqlquery="SELECT `id`, `year`, `subject`, `file_dir` FROM `notes_table`";
$result = $connection->query($sqlquery);

?>    


<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, initial-sccale=1">
    <title>Private Education Portal</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="./assets/images/favicon.png"
    />
    <!-- Custom CSS -->
    <link href="./assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <!-- Custom CSS -->
     <!-- <script src="https://code.jquery"></script> -->
    <link href="./dist/css/style.min.css" rel="stylesheet" />
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script>
      //get header and menu
      $(function(){     
		$.ajax({  
		  type: "GET",
		  url: "header.php",  
		  dataType: "html",
		  success: function(menuHTML) { 
     
			$(".page-wrapper").before(menuHTML);  
		  },
		  error: function(){
			
		  } 
		}); 
		return false;  
	});
  //get footer scripts
  $(function(){     
		$.ajax({  
		  type: "GET",
		  url: "footer.html",  
		  dataType: "html",
		  success: function(footerHtml) { 
        
			$(".page-wrapper").after(footerHtml);  
		  },
		  error: function(){
			alert("failed call!!!");
		  } 
		}); 
		return false;  
	});
    </script>

  </head>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
    
    <!-- include header here -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data">
          <div class="container-fluid">
                
                <div class="card">
              <div class="card-body">
                  <h4 class="card-title">Uploaded NOTES</h4>
          
        
               <div>
            </div>
       
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Year</th>
                            <th>Subject</th>
                            <th>Notes</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                </tbody>
                <?php
                //Display the uploaded files n download links
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $file_path="pdf/". $row['file_dir'];
                        ?>
                        <tr>
                            <td><?php echo $row['id'];?></td>       
                            <td><?php echo $row['year'];?></td>
                            <td><?php echo $row['subject'];?></td>
                            <td><?php echo $row['file_dir'];?></td>
                            <td><a href="<?php echo $file_path;?>" class="btn btn-primary" download>Download</a></td>
                    </tr>
                    <?php
                    }
                } else{
                    ?>
                    <tr>
                        <td colspan="4">NO files uploaded yet.</td>
                </tr>
                <?php
                }           
?>
</tbody>
            </table>
            
</form>      
</div>

                
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- =============================foter================================= -->
  </form>
  </body>
</html>
<?php
$connection->close();
?>