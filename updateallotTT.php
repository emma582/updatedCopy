<?php
session_start();
if(isset($_GET['id'])){
$_SESSION["timetableId"]=$_GET['id'];
}
require_once "config.php";

 //echo "**********************".$_SESSION["timetableId"]."<br>";
$num_session="";
$num_session_err="";

if($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    if(empty($_POST["nums"])){
        $num_session_err = "Please select Number of sessions.";     
    }
      else{
        // Prepare a select statement
      //  echo $num_session_err  = $_POST['nums'];
      $qr = "SELECT sum(no_session) FROM `allottime_table` where class=?";
      
      if($stmt = mysqli_prepare($link, $qr)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_class);
            
            // Set parameters
            $param_num_session = $_POST["nums"];
            $param_class = $_POST["class"];
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                 echo mysqli_stmt_num_rows($stmt);
                if($param_num_session >=  35){
                  
                    $num_session_err = "Number of session has reached the limit , couldnt insert now";
                } else{
                  
                  $num_session = $_POST["nums"];
                }
  
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
  
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
  if( empty($num_session_err) ){

    $sql = "UPDATE  `allottime_table` SET `no_session`=? WHERE id=?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $param_num_session, $param_id);

        $param_num_session = $num_session;
          $param_id = $_SESSION["timetableId"];
          if(mysqli_stmt_execute($stmt)){
            header("location: newallotTT.php");
              exit();
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }
       
      // Close statement
      mysqli_stmt_close($stmt);
  }
  
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
		  url: "adminHeader.php",  
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
          <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST"  >
          <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Allot Timetable</h4>
                    
                <!-- number of sessions -->
                  <div class="form-group">
                    <label for="numberofsession">Number of sessions</label>
                    <select
                        class="form-select <?php echo (!empty($num_session_err)) ? 'is-invalid' : ''; ?>"
                        name ="nums"
                      >
                     
                    
                    <option value=""> Select Number Sessions </option>
                
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      
                    
                      
                    
                    
                    </select>
                    <span class="invalid-feedback"><?php echo $num_session_err; ?></span>
                  </div>
                
                  <div class="card-body">
            <!-- <input type="hidden" name="id" value="<?php echo $id; ?>"/> -->
              <button type="submit" class="btn btn-success text-white" name="save_select">
                Post
              </button>
            </div>



					
					
        

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
