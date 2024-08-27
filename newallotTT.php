<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$class = "" ;
$subject = "";
$num_session="";
// $result="";
$class_err ="";
$subject_err ="";
$num_session_err="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
        //class validation
    if(empty($_POST["class"])){
        $class_err = "Please select class.";     
    }
    else{
        $class = $_POST["class"];
    }

    //subject validation
    if(empty($_POST["subjects"]) ){
        $subject_err = "Please select subject.";     
    }
    
      else{
        // Prepare a select statement
      //  echo $subject_err  = $_POST['subjects'];
        $sql = "SELECT id FROM allottime_table WHERE subject = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_subject);
            
            // Set parameters
            $param_subject = $_POST["subjects"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                 echo mysqli_stmt_num_rows($stmt);
                if(mysqli_stmt_num_rows($stmt) >  0){
                    
                    $subject_err = "This subject already exists.";
                } else{
                  $subject = $_POST["subjects"];
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
       
    
    
    //number of session validation
   //   echo $num_session_err  = $_POST['nums'];
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
  
                       
    // Check input errors before inserting in database
    if(empty($class_err) && empty($subject_err) && empty($num_session_err) ){
        
          // Prepare an insert statement
            $sql = "INSERT INTO `allottime_table`(`class` , `subject`,`no_session` )  VALUES (?,?,?)";
           
          if($stmt = mysqli_prepare($link, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "sss",$class,$subject,$num_session);
               
              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){
                  // Redirect to login page
                  echo '<script>
                  alert("Registered Successful");
                  window.location.href="newallotTT.php";
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
                  <div class="form-group">
                    <label for="class"> Class</label>
                    <select
                        class="form-select <?php echo (!empty($class_err)) ? 'is-invalid' : ''; ?>" 
                        name ="class" id="class"
                      >
                     
                    
                    <option value=""> Select Class</option>
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
                    <span class="invalid-feedback"><?php echo $class_err; ?></span>
                  </div>
                
                

                        <!--Subject-->
                  <div class="form-group">
                    <label for="subject"
                      > Subject</label
                    >
                    <select
                        class="form-select <?php echo (!empty($subject_err)) ? 'is-invalid' : ''; ?>" 
                       name="subjects" id="subjects"
                    >
                      </select>
                      <span class="invalid-feedback"><?php echo $subject_err; ?></span>
</div>
                  
                   
                    
                    
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
                




                  <div class="border-top">
                  <div class="card-body">
                    <button type="submit" class="btn btn-success text-white">
                      Generate Timetable
                    </button>
                    <button type="cancel" class="btn btn-danger text-white">
                      Cancel
                    </button>
                    <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                 
                    <?php           
					$sql = "SELECT * FROM  `allottime_table` where class='sem-II'";
					// $squery = mysqli_query($link, $selectQuery);
          if($result = mysqli_query($link,$sql)){
            // mysqli_stmt_bind_param($stmt, "s", $param_class);
          
            // Set parameters
         
           // $param_class = $_POST["class"];
           
            // echo "<table>";
            echo "<table
                      id='zero_config'
                      class='table table-striped table-bordered'
                    >";
            echo "<tr>";
              echo  "<th>id</th>";
              //echo  "<th>class</th>";
              echo  "<th>subject</th>";
              echo  "<th>no_session</th>";
              echo  "<th>faculty</th>";
              echo "</tr>";
              while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['subject'] . "</td>";
                echo "<td>" . $row['no_session'] . "</td>";
                echo "<td>" . $row['faculty'] . "</td>";?>
                <td><button class="btn btn-success text-white" type="button" name="shift" id="shift"  onClick="window.location.href='updateallotTT.php?id=<?php echo $row['id'];?>'">
                Update
               </button></td>
               <?php
              echo "</tr>";
              }
              echo "</table>";
              ?>
              
           <?php       
          }
          else{
            echo "No records were inserted of tht class";
          }
           
          // Close connection
          mysqli_close($link);
          ?>
          

					
					
        
          </table>
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
    
      <script>
        $(document).ready(function () {
            // Handle semester dropdown change
            $('#class').change(function () {
                const selectedClass = $(this).val();

                // Send AJAX request to get subjects for the selected semester
                $.ajax({
                    url: 'subjects.php', // PHP script to retrieve subjects
                    method: 'POST',
                    data: { class : selectedClass },
                    success: function (response) {
                        // Update subjects dropdown
                        $('#subjects').html(response);
                    }
                });
            });
        });
        

      </script>
      
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- =============================foter================================= -->
  </body>
</html>
