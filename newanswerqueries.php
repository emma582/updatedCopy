<?php
// Include config file
require_once "config.php";
session_start();
 
// Define variables and initialize with empty values
$year = "" ;
$answer="";

$year_err="";
$answer_err="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //year validation
if(empty($_POST["year"])){
    $year_err = "Please select year.";     
}
else{
    $year = $_POST["year"];
}
if(empty(trim($_POST["answer"]))){
    $answer_err = "Please write  your answer.";     
}
else{
    $answer= trim($_POST["answer"]);
}
if(empty($year_err) && empty($answer_err) ){
        
    // Prepare an insert statement
      $sql = "INSERT INTO `answer_table`(`year`, `answer`) VALUES (?,?)";
     
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss",$year,$answer);
         
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            echo '<script>
            alert("Registered Successful");
            window.location.href="newanswerqueries.php";
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
        var header="";   
        var sessName='<?php echo $_SESSION['role']?>';
       // alert(sessName);
        if(sessName==2){
        header= "facultyHeader.php"; 
       }
      else if(sessName==3){
        header="adminHeader.php";
      } else{
        header="header.php";
      }
		$.ajax({  
		  type: "GET",
		  url: header,  
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
      <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
          <div class="form-group row">    
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Answer Queries</h4>
          <div class="form-group row">
            <label class="col-md-3 mt-3">Year And Semester</label>
            <div class="col-md-9">
              <select name="year"
                class="select2 form-select shadow-none <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" 
                style="width: 100%; height: 36px"
              >
                <option value="">Select Year and Semester</option>
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
              >Answer Here</label>
            <div class="form-row ">
              <textarea class="form-control <?php echo (!empty($answer_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $answer; ?>" name="answer"></textarea>
              <span class="invalid-feedback"><?php echo $answer_err; ?></span>    
            </div>
          </div>
          
        </div>
      
        <div class="text-end">
          <div class="card-body">
            <button type="submit" class="btn btn-success text-white">
              Save
            </button>
          </div>
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
    <!-- =============================footer================================= -->
  </form>
  </body>
</html>
