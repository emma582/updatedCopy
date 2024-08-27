<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$role = "" ;
$firstname = "";
$middlename ="";
$lastname="";
$gender="";
$dob="";
$contact="";
$qualify="";
$subject="";
$email="";
$password="";
$confirm_password="";

$firstname_err="";
$middlename_err="";
$lastname_err="";
$gender_err ="";              
$dob_err="";
$contact_err="";
$qualify_err="";
$subject_err="";
$email_err="";
$password_err="";
$confirm_password_err="";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate firstname
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a firstname.";     
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["firstname"]))){
        $firstname_err =  "firstname can only contain letters, numbers, and underscores.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }
 
    // Validate middlename
    if(empty(trim($_POST["middlename"]))){
        $middlename_err = "Please enter a middlename.";     
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["middlename"]))){
        $middlename_err =  "firstname can only contain letters, numbers, and underscores.";
    } else{
        $middlename = trim($_POST["middlename"]);
    }

    // Validate lastname
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter a lastname.";     
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["lastname"]))){
        $lastname_err =  "lastname can only contain letters, numbers, and underscores.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }

   // Validate gender
   if(empty($_POST["gender"])){
    $gender_err = "Please select gender.";     
}
else{
    $gender = $_POST["gender"];
}
 // Validate dob
 if(empty(trim($_POST["dateofbirth"]))){
    $dob_err = "Please select date of birth.";     
}
else{
    $dob= trim($_POST["dateofbirth"]);
}
//validate contact no
if(empty(trim($_POST["contact_no"]))){
    $contact_err = "Please enter a contact number.";   
} elseif(!preg_match('/^[0-9]{10}+$/', trim($_POST["contact_no"]))){
    $contact_err =  "contact must contain numbers only";
} else{
    $contact = trim($_POST["contact_no"]);
}
  // Validate qualication
  if(empty(trim($_POST["qualify"]))){
    $qualify_err = "Please enter a your Qualification.";     
} elseif(!preg_match('/^[a-zA-Z0-9.]+$/', trim($_POST["qualify"]))){
    $qualify_err =  "Qualification can only contain letters, numbers, and dot.";
} else{
    $qualify = trim($_POST["qualify"]);
}
// Validate subject
if(empty(trim($_POST["subject"]))){
  $subject_err = "Please enter a subject.";     
} elseif(!preg_match('/^[a-zA-Z0-9]+$/', trim($_POST["subject"]))){
  $subject_err =  "subject can only contain letters and underscores.";
} else{
  $subject = trim($_POST["subject"]);
}



    // Validate username or email
    if(empty(trim($_POST["email_id"]))){
        $email_err = "Please enter a email.";
     } elseif(!preg_match( "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", trim($_POST["email_id"]))){
         $email_err = "Please enter valid email.";
    } else{
        // Prepare a select statement
       // $email_err = $_POST["email_id"];
        $sql = "SELECT id FROM user_table WHERE email_id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email_id"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                 echo mysqli_stmt_num_rows($stmt);
                if(mysqli_stmt_num_rows($stmt) >  0){

                    $email_err = "This email already exists.";
                } else{
                    $email = trim($_POST["email_id"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($middlename_err) && empty($lastname_err) && empty($gender_err) && empty($dob_err) && empty($contact_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($qualify_err)&& empty($subject_err)){
      $role = $_POST["role"];
        // Prepare an insert statement
          $sql = "INSERT INTO user_table (role , first_name , middle_name , last_name , gender , date_of_birth , contact_no , email_id , password) VALUES (?,?,?,?,?,?,?,?,?)";
          $sql2 = "INSERT INTO `faculty_mast`( `first_name`, `middle_name`, `last_name`, `gender`, `contact_no`, `qualification`, `subject`,`email_id`) VALUES (?,?,?,?,?,?,?,?)";
          if($stmt2 = mysqli_prepare($link,$sql2)){
          mysqli_stmt_bind_param($stmt2 , "ssssisss",$firstname,$middlename,$lastname,$gender,$contact,$qualify,$subject,$email);
        mysqli_stmt_execute($stmt2);  
        }

          if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssssiss",$role,$firstname,$middlename,$lastname,$gender,$dob,$contact,$email,$password);
            // mysqli_stmt_bind_param($stmt1 , "ssssisss",);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo '<script>
                alert("Registered Successful");
                </script>';
                //window.location.href="index.php";
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
         
          <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-row">
              <div class="form-group">
                 
                  <input type="hidden" name="role" id="role" value="2" class = "value= <?php echo $role ;?> "/>
              </div>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Faculty Registration</h4>
              <div class="form-group">
                <label for="fullname">Full name</label>
                <input
                  type="text"
                  id="firstname"
                  class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>"
                  data-control="hue"
                  name="firstname"
                  placeholder="first name*"
                />
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
              </div>
              <div class="form-group">
                
                <input
                  type="text"
                  id="middlename"
                  class="form-control <?php echo (!empty($middlename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middlename; ?>"
                  data-control="hue"
                  name="middlename"
                  placeholder="middle name*"
                />
                <span class="invalid-feedback"><?php echo $middlename_err; ?></span>
              </div>
              <div class="form-group">
            
                <input
                  type="text"
                  id="lastname"
                  class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>"
                  data-control="hue"
                  name="lastname"
                  placeholder="last name*"
                />
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Gender</label>
                <div class="col-md-9">
                 
                    <input
                      type="radio"
                      class="form-check-input <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>"
                      id="female"
                      value="female"
                      name="gender"
                      
                    />
                    <label
                      class="form-check-label mb-0"
                      for="customControlValidation1"
                      >Female</label
                    >
                  
                 
                    <input
                      type="radio"
                      class="form-check-input"
                      id="male"
                      value="male"
                      name="gender"
                      
                    />
                    <label
                      class="form-check-label mb-0"
                      for="customControlValidation2"
                      >Male</label
                    >
                  
                  
                    
                    <span class="invalid-feedback"><?php echo $gender_err; ?></span>
                </div>
              </div>
              <label class="mt-3">Date of Birth</label>
              <div class="input-group">
                <input
                  type="date"
                  class="form-control  <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dob; ?>"
                  id="dateofbirth"
                  name="dateofbirth"
                  
                /><span class="invalid-feedback"><?php echo $dob_err; ?></span>
                <div class="input-group-append">
                  <span class="input-group-text h-100"
                    >
                  </span>
                </div>
              </div>
            
            <div class="form-group">
              <label class="mt-3">Contact details</label>
              <input
                type="text"
                class="form-control<?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>"
                id="contact_no"
                name="contact_no"
                placeholder="mobile number*"
              />
              <span class="invalid-feedback"><?php echo $contact_err; ?></span>
              </div>
<!-- qualification -->
              <div class="form-group">
                <label for="qualification">Qualification</label>
                <input
                  type="text"
                  id="qualification"
                  class="form-control <?php echo (!empty($qualify_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $qualify; ?>"
                  data-control="hue"
                  name="qualify"
                  placeholder="Qualification*"
                />
                <span class="invalid-feedback"><?php echo $qualify_err; ?></span>
              </div>
              <div class="form-group">
                <label class="mt-3">Subject</label>
                <input
                  type="text"
                  class="form-control  <?php echo (!empty($subject_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject; ?>"
                  id="subject"
                  name="subject"
                  placeholder="subject name*"
                /><span class="invalid-feedback"><?php echo $subject_err; ?></span>
                </div>
              <div class="form-group">
                <label class="mt-3">email_id</label>
                <input
                  type="text"
                  class="form-control  <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>"
                  id="email_id"
                  name="email_id"
                  placeholder="email address*"
                /><span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input
                    type="password"
                    id="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"
                    placeholder="enter password*"
                    name="password"
                  /><span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                  <label for="confirmpassword">Confirm Password</label>
                  <input
                    type="password"
                    id="confirm_password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>"
                    placeholder="re-enter password*"
                    name="confirm_password"
                  />
                  <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <div class="border-top">
              <div class="card-body">
                <button type="submit" class="btn btn-success text-white" name="save_select">
                  Save
                </button>
                <button type="reset" class="btn btn-primary">Reset</button>
                
                <button type="reset" class="btn btn-danger text-white">
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
  </form>
  </body>
</html>
