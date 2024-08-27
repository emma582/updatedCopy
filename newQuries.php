<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$roll = "";
$year = "" ;
$query="";

$roll_err="";
$year_err="";
$query_err="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  //roll validation
  if(empty(trim($_POST["roll"]))){
    $roll_err = "Please enter your rollno.";     
}
else{
    $roll = trim($_POST["roll"]);
}
  
  
  //year validation
if(trim($_POST["year"])){
    $year_err = "Please select year.";     
}
else{
    $year = trim($_POST["year"]);
}
//query validation
if(empty(trim($_POST["query"]))){
    $query_err = "Please write  your query first.";     
}
else{
    $query= trim($_POST["query"]);
}
if(empty($roll_err) && empty($year_err) && empty($query_err) ){
        
    // Prepare an insert statement
      $sql = "INSERT INTO `question_table`(`roll_no`, `class`, `query`) VALUES (?,?,?)";
     
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iss",$roll,$year,$query);
         
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            echo '<script>
            alert("Query Posted Successful");
            window.location.href="newQuries.php";
            </script>';
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
      }
}
// Close connection
mysqli_close($link);
}




?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template"
    />
    <meta
      name="description"
      content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework"
    />
    <meta name="robots" content="noindex,nofollow" />
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
    <link href="./dist/css/style.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script>
      //get header and menu
      $(function(){     
		$.ajax({  
		  type: "GET",
		  url: "header.html",  
		  dataType: "html",
		  success: function(menuHTML) { 
     
			$(".page-wrapper").before(menuHTML);  
		  },
		  error: function(){
			alert("failed call!!!");
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
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
       <!-- <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Dashboard</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Library
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>-->
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group row">  
              
        <div class="card">
          
          <div class="card-body">
            <h4 class="card-title">Answer Queries</h4>
            <div class="form-group row">
              <div class="form-group">
                <label
                for="rollno"
                class="col-md-3 mt-3"
                >Enter Your Roll number</label>
            
                <input type="text" class="form-control form-control-lg <?php echo (!empty($roll_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $roll; ?>" name="roll" id="rollno"  placeholder=" roll no"/>
                <span class="invalid-feedback"><?php echo $roll_err; ?></span>
            </div>  
              <label class="col-md-3 mt-3">Year And Semester</label>
              <div class="col-md-9">
                <select name="year"
                  class="select2 form-select shadow-none <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>"
                  style="width: 100%; height: 36px"
                >
                  <option>Select Year and Semester</option>
                  <optgroup label="BCA-I" >
                    <option value="sem-I">Semester-I</option>
                    <option value="sem-II">Semester-II</option>
                  </optgroup>
                  <optgroup label="BCA-II">
                    <option value="sem-III">Semester-III</option>
                    <option value="sem-IV">Semester-IV</option>
                    
                  </optgroup>
                  <optgroup label="BCA-III">
                    <option value="sem-V">Semester-V</option>
                    <option value="sem-VI">Semester-VI</option>
                    
                  </optgroup>
                  </select>
                  <span class="invalid-feedback"><?php echo $year_err; ?></span>
                  </div>
                  </div>
            <div> 
            <label
                for="cono1"
                class="col-md-3 mt-3"
                >Ask Queries Here</label>
              <div class="form-row ">
                <textarea class="form-control  <?php echo (!empty($query_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $query; ?>" name="query"></textarea>
                <span class="invalid-feedback"><?php echo $query_err; ?></span>   
              </div>
            </div>
          </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-success text-white" name="save_select">
                Save
              </button>
            </div>
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
  </body>
</html>
