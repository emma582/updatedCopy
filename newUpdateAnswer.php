<?php
session_start();
if(isset($_GET['id'])){
$_SESSION["questionId"]=$_GET['id'];
}
// Include config file
require_once "config.php";

// echo "**********************".$_SESSION["id"]."<br>";
// echo "**********************".$_SESSION["questionId"]."<br>";
 
// Define variables and initialize with empty values

$answer="";

$answer_err="";


  // Get hidden input value
 
//   $parts = parse_url($url);
// parse_str($parts['query'], $query);
// echo $query['id'];

 
  
 if($_SERVER["REQUEST_METHOD"] == "POST") 
  {// Validate answer
    //$id = $_GET['id'];
    // echo $_POST['id'];
  

  // $input_answer = trim($_POST["answer"]);
  if(empty(trim($_POST['answer']))){
      $answer_err = "Please enter an answer.";     
  } else{
      $answer = trim($_POST['answer']);
  }
  
  
  // Check input errors before inserting in database
  if(empty($answer_err)){
      // Prepare an update statement
      $sql = "UPDATE question_table SET f_id=?, answer=? WHERE id=?";
       
      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "isi", $param_f_id, $param_answer, $param_id);
          
          // Set parameters
          $param_f_id = $_SESSION["id"];
          $param_answer = $answer;
          $param_id = $_SESSION["questionId"];
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              // Records updated successfully. Redirect to landing page
              header("location: adminQnA.php");
              exit();
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }
       
      // Close statement
      mysqli_stmt_close($stmt);
  }
  
  // Close connection
  mysqli_close($link);
}
?> 
 <!-- html form -->
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
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
    
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
              
            <div> 
            <label
                for="cono1"
                class="col-md-3 mt-3"
                >Update Answers Here</label>
              <div class="form-row ">
                <textarea class="form-control  <?php echo (!empty($answer_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $answer; ?>" name="answer"></textarea>
                <span class="invalid-feedback"><?php echo $answer_err; ?></span>   
              </div>
            </div>
          </div>
          </div>
          <div class="border-top">
            <div class="card-body">
            <!-- <input type="hidden" name="id" value="<?php echo $id; ?>"/> -->
              <button type="submit" class="btn btn-success text-white" name="save_select">
                Post
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
