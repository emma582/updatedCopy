<?php
session_start();

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$year = "" ;
$subject = "";
$file = "";

$year_err ="";
$subject_err ="";
$file_err ="";


if($_SERVER["REQUEST_METHOD"] == "POST"){
        //year validation
    if(empty($_POST["year"])){
        $year_err = "Please select year.";     
    }
    else{
        $year = $_POST["year"];
    }

    //subject validation
    if(empty($_POST["subject"])){
        $subject_err = "Please select subject.";     
    }
    else{
        $subject = $_POST["subject"]  ;
    }
    //file validation
    if (isset($_POST['submit'])) {

     // $name = $_POST['name'];
  
      if (isset($_FILES['file']['name']))
      {
      $file = $_FILES['file']['name'];
      $file_tmp = $_FILES['file']['tmp_name'];
  
      move_uploaded_file($file_tmp,"./pdf/".$file);
  
      $insertquery = 
      "SELECT `id` FROM `notes_table` WHERE file_dir = ?";
     // $iquery = mysqli_query($link, $insertquery);
      }
      else
      {
        
        if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $param_file);
          
          // Set parameters
          $param_file = trim($_POST["file"]);
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              /* store result */
              mysqli_stmt_store_result($stmt);
              
              if(mysqli_stmt_num_rows($stmt) > 0){
                  $file_err = "This file already exists.";
              } else{
                  $file = trim($_POST["file"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }
  }
                        
    // Check input errors before inserting in database
    if(empty($year_err) && empty($subject_err) && empty($file_err) ){
        $_POST['role'];
          // Prepare an insert statement
            $sql = "INSERT INTO `notes_table`( `year`, `subject`, `file_dir`) VALUES (?,?,?)";
           
          if($stmt = mysqli_prepare($link, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "sss",$year,$subject,$file);
               
              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){
                  // Redirect to login page
                  echo '<script>
                  alert("Uploaded Successful");
                  window.location.href="newfilesUpload.php";
                  </script>';
                  
              } else{
                  echo "Oops! Something went wrong. Please try again later.";
              }
  
              // Close statement
              mysqli_stmt_close($stmt);
            }
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
      url:header ,
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
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data">
        <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Upload Notes</h4>
                        <!--Year-->
                  <div class="form-group">
                    <label for="year">Select Year</label>
                    <select
                        class="form-select <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>"
                        name ="year" 
                      >
                     
                    
                    <option value="">--- Select Year and Semester ---</option>
                    <optgroup label="BCA-I" >
                      <option value="semester-I">Semester-I</option>
                      <option value="semester-II">Semester-II</option>
                    </optgroup>
                    <optgroup label="BCA-II">
                      <option value="semester-III">Semester-III</option>
                      <option value="semester-IV">Semester-IV</option>
                      
                    </optgroup>
                    <optgroup label="BCA-III">
                      <option value="semester-V">Semester-V</option>
                      <option value="semester-VI">Semester-VI</option>
                      
                    </optgroup>
                    
                    </select>
                    <span class="invalid-feedback"><?php echo $year_err; ?></span>
                  </div>
                
                

                        <!--Subject-->
                  <div class="form-group">
                    <label for="subject"
                      >Select Subject</label
                    >
                    <select
                        class="form-select <?php echo (!empty($subject_err)) ? 'is-invalid' : ''; ?>"
                       name="subject" 
                    >
                    <option value="">--- Select Subject ---</option>
                    <optgroup label="Semester-I">
                      <option value="Eng">English</option>
                      <option value="FC">Fundamentals of Computer</option>
                      <option value="C">Logic Development With 'C' Programming</option>
                      <option value="WP">Basics of Web Programming-I</option>
                      <option value="SE">Software Engineering-I</option>
                      <option value="Maths">Basics of Mathematics-I</option>
                      <option value="Stats">Statistical Methods-I</option>
                      <option value="DE">Digital Electronics</option>
                      <option value="DHS">Development of Human Skills</option>
                    </optgroup>
                    <optgroup label="Semester-II">
                      <option value="Eng">English</option>
                      <option value="ACP">Advanced Programming in C</option>
                      <option value="WP">Basics of Web Programming-II</option>
                      <option value="OA">Office Automation</option>
                      <option value="Maths">Basics of Mathematics-II</option>
                      <option value="Stats">Statistical Methods-II</option>
                      <option value="SE">Software Engineering-II</option>
                      <option value="Micro">Introduction to Microprocessor</option>
                      
                    </optgroup>
                    <optgroup label="Semester-III">
                      <option value="CPP">OOPs with C++-I</option>
                      <option value="DS">Data Structure Using C-I</option>
                      <option value="CN">Computer Network-I</option>
                      <option value="PHP">Web Development Using Php</option>
                      <option value="Tally">Financial Accounting with Tally</option>
                      <option value="DBMS">Database Management System</option>
                      <option value="ST">Software Testing</option>
                      </optgroup>
                    <optgroup label="Semester-IV">
                      <option value="CPP">OOPs with C++-II</option>
                      <option value="DS">Data Structure Using C-II</option>
                      <option value="MS">MySQL</option>
                      <option value="CL">Ethics and Cyber Law</option>
                      <option value="AJS">Angular JS</option>
                      <option value="ACN">Advanced Computer Network</option>
                      <option value="PP">Python Programming</option>
                      <option value="ES">Environment Studies</option>
                     
                    </optgroup>
                    <optgroup label="Semester-V">
                      <option value="Eng">English (Business English)</option>
                      <option value="Java">Core Java</option>
                      <option value="VP">Visual Programming</option>
                      <option value="CG">Computer Graphics</option>
                      <option value="RTIT">Recent Trends in IT</option>
                      <option value="LSP">Linux and ShellProgramming</option>
                      
                    </optgroup>
                    <optgroup label="Semester-VI">
                      <option value="Eng">English (Business English)</option>
                      <option value="AJ">Advanced Java</option>
                      <option value="VP">Dot Net Technology</option>
                      <option value="DWDM">Data Warehouse and Data Mining</option>
                      <option value="CNS">Cryptography and Network Security</option>
                      <option value="AP">Advanced Python</option>
                      
                    </optgroup>
                    
                  </select>

                  <span class="invalid-feedback"><?php echo $subject_err; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="position-top-right">Select File</label>
                    <input
                      type="file"
                      id="file"
                      class="form-control demo <?php echo (!empty($file_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $file; ?>"
                      data-position="top right"
                      name="file"
                      accept=".pdf"
				              title="Upload PDF"
                      required
                    />
                    <span class="invalid-feedback"><?php echo $file_err; ?></span>
                  </div>
                  <div class="border-top">
                  <div class="card-body">
                    <button type="submit" class="btn btn-success text-white" name="submit">
                      Upload file
                    </button>
                    <button type="cancel" class="btn btn-danger text-white">
                      Cancel
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
    <!-- =============================foter================================= -->
  </body>
</html>
