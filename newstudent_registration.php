<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$role="";
$firstname = $middlename ="";
$lastname="";
$year="";
$gender="";
$dob="";
$contact="";
$email="";
$password="";
$confirm_password="";

$firstname_err="";
$middlename_err="";
$lastname_err="";
$year_err="";
$gender_err ="";              
$dob_err="";
$contact_err="";
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

    //validate year
    if(empty($_POST["year"])){
      $year_err = "Please select year.";     
  }
  else{
      $year = $_POST["year"];
  }
   // Validate gender
   //$gender_err = $_POST["gender"];     
   if(empty($_POST["gender"])){
    $gender_err = "Please select gender.";     
   // echo "<script>alert('$_POST['gender']');</script>";
   //echo $_POST['gender'];
}
else{
    $gender = $_POST["gender"];
}
 // Validate dob
 if(empty(trim($_POST["date_of_birth"]))){
    $dob_err = "Please select date pf birth.";     
}
else{
    $dob= trim($_POST["date_of_birth"]);
}
//validate contact no
if(empty(trim($_POST["contact_no"]))){
    $contact_err = "Please enter a contact number.";     
} elseif(!preg_match('/^[0-9]{10}+$/', trim($_POST["contact_no"]))){
    $contact_err =  "contact must contain numbers only";
} else{
    $contact = trim($_POST["contact_no"]);
}



    // Validate username or email
    if(empty(trim($_POST["email_id"]))){
        $email_err = "Please enter a email.";
     } elseif(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', trim($_POST["email_id"]))){
         $email_err = "Please enter valid email.";
    } else{
        // Prepare a select statement
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
                
                if(mysqli_stmt_num_rows($stmt) > 0){
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
    if(empty($firstname_err) && empty($middlename_err) && empty($lastname_err) && empty($year_err) && empty($gender_err) && empty($dob_err) && empty($contact_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
       $role=$_POST['role']; 
        // Prepare an insert statement
        $sql = "INSERT INTO user_table (role , first_name , middle_name , last_name , year, gender , date_of_birth , contact_no , email_id , password) VALUES (?,?,?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issssssiss",$role,$firstname,$middlename,$lastname,$year,$gender,$dob,$contact,$email,$password);
            
            // Set parameters
            //$param_username = $username;
            //$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo '<script>
                alert("Registered Successful");
                window.location.href="newlogin.php";
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
<html dir="ltr">
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
    <title>Student-Register-form</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="./assets/images/favicon.png"
    />
    <!-- Custom CSS -->
    <link href="./dist/css/style.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="main-wrapper">
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
      <!-- Preloader - style you can find in spinners.css -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Login box.scss -->
      <!-- ============================================================== -->
      <div
        class="
          auth-wrapper
          d-flex
          no-block
          justify-content-center
          align-items-center
          bg-dark
        "
      >
        <div class="auth-box bg-dark border-top border-secondary">
          <div>
            <div class="text-center pt-3 pb-3">
              <span class="db"
                ><img src="./assets/images/logo-text1.png" alt="logo"
              /></span>
            </div>
            <!-- Form -->
            <form class="form-horizontal mt-3" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

              <!-- role -->
              <div class="form-group">
                 
                <input type="hidden" name="role" id="role" value="1" />
            </div>
           
              <!--firstname-->
              <div class="row pb-4">
                <div class="col-12">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-success text-white h-100"
                        id="basic-addon1"
                        ><i class="mdi mdi-account fs-4"></i
                      ></span>
                    </div>
                    
                    <input
                      type="text"
                      class="form-control form-control-lg <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>"
                      placeholder="firstname"
                      aria-label="firstname"
                      aria-describedby="basic-addon1"
                      name="firstname"
                      id="firstname"
                    
                      
                    />
                    <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                    </div>
                  
                       <!--Middle Name-->
                    <div class="row pb-4">
                      <div class="col-12">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span
                              class="input-group-text bg-success text-white h-100"
                              id="basic-addon1"
                              ><i class="mdi mdi-account fs-4"></i
                            ></span>
                          </div>
                          
                          <input
                            type="text"
                            class="form-control form-control-lg  <?php echo (!empty($middlename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middlename; ?>"
                            placeholder="middlename"
                            aria-label="middlename"
                            aria-describedby="basic-addon1"
                            name="middlename"
                            id="middlename"
                           
                          />
                          <span class="invalid-feedback"><?php echo $middlename_err; ?></span>
                          </div>

                    

                    <!--Last Name-->
                    <div class="row pb-4">
                      <div class="col-12">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span
                              class="input-group-text bg-success text-white h-100"
                              id="basic-addon1"
                              ><i class="mdi mdi-account fs-4"></i
                            ></span>
                          </div>
                          
                          <input
                            type="text"
                            class="form-control form-control-lg <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>"
                            placeholder="lastname"
                            aria-label="lastname"
                            aria-describedby="basic-addon1"
                            name="lastname"
                            id="lastname"
                           
                          />
                          <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                         </div>
                         <!--year-->
                         <div class="row pb-4">
                            <div class="col-12">
                              <div class="input-group mb-3 ">
                                <div class="input-group-prepend">
                                 
                                  <span
                                    class="input-group-text bg-success text-white h-100"
                                    id="basic-addon1"
                                    ><i class="mdi mdi-calendar"></i
                                  ></span>
                                 
                               </div>

                           
                         <select name="year" class="form-control form-control-lg  <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>"  >
                         <option >select year</option>
                         <optgroup label="BCA-I">
                         <option value="sem-I">Semester-I</option>
                         <option value="sem-II">Semester-II</option>   
                          </optgroupt>
                          <optgroup label="BCA-II">
                         <option value="sem-III">Semester-III</option>
                         <option value="sem-IV">Semester-IV</option>   
                          </optgroupt>
                          <optgroup label="BCA-III">
                         <option value="sem-V">Semester-V</option>
                         <option value="sem-VI">Semester-VI</option>   
                          </optgroupt>
                      </select>
                      <span class="invalid-feedback"><?php echo $year_err; ?></span>
                    </div>
                         
                    
                          <!--gender-->
                          <div class="row pb-4">
                            <div class="col-12">
                              <div class="input-group mb-3 ">
                                <div class="input-group-prepend">
                                 
                                  <span
                                    class="input-group-text bg-success text-white h-100"
                                    id="basic-addon1"
                                    ><i class="mdi mdi-human-male-female fs-4"></i
                                  ></span>
                                 
                               </div>

                           
                         <select name="gender" class="form-control form-control-lg  <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>"  >
                         <option value="" >select gender</option>
                         <option value="female">female</option>
                         <option value="male">male</option>   
                      </select>
                      <span class="invalid-feedback"><?php echo $gender_err; ?></span>
                    </div>
                         
                    
                    
                        
                          <!--DOB-->
                    <div class="row pb-4">
                      <div class="col-12">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span
                              class="input-group-text bg-success text-white h-100"
                              id="basic-addon1"
                              ><i class="mdi mdi-calendar-text"></i
                            ></span>
                          </div>
                          
                          <input
                            type="date"
                            class="form-control form-control-lg  <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dob; ?>"
                            aria-label="date"
                            aria-describedby="basic-addon1"
                            name="date_of_birth"
                            id="date_of_birth"
                           
                          />
                          <span class="invalid-feedback"><?php echo $dob_err; ?></span>
                          </div>

                          <!--Contact NO-->
                    <div class="row pb-4">
                      <div class="col-12">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span
                              class="input-group-text bg-success text-white h-100"
                              id="basic-addon1"
                              ><i class="mdi mdi-account-circle"></i
                            ></span>
                          </div>
                          
                          <input
                            type="text"
                            class="form-control form-control-lg <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>"
                            placeholder="contact_no"
                            aria-label="contact_no"
                            aria-describedby="basic-addon1"
                            name="contact_no"
                            id="contact_no"
                           
                          />
                          <span class="invalid-feedback"><?php echo $contact_err; ?></span>
                          </div>


                  <!-- email -->
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-danger text-white h-100"
                        id="basic-addon1"
                        ><i class="mdi mdi-email fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="text"
                      class="form-control form-control-lg <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>"
                      placeholder="Enter email_id"
                      name="email_id"
                      id="email_id"
                      aria-label="email_id"
                      aria-describedby="basic-addon1"
                      
                    /><span class="invalid-feedback"><?php echo $email_err; ?></span>
                  </div>
                  <!--password-->
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-warning text-white h-100"
                        id="basic-addon2"
                        ><i class="mdi mdi-lock fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="password"
                      class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"
                      placeholder="Enter Password"
                      aria-label="password"
                      name="password"
                      id="password"
                      aria-describedby="basic-addon1"
                     
                    />
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                  </div>
                  <!--ConfirmPassoword-->
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-info text-white h-100"
                        id="basic-addon2"
                        ><i class="mdi mdi-lock fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="password"
                      name="confirm_password"
                      class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>"
                      placeholder="Enter Confirm Password"
                      aria-label="confirmPassword"
                      aria-describedby="basic-addon1"
                     
                    />
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                  </div>
                </div>
              </div>
              <div class="row border-top border-secondary">
                <div class="col-12">
                  <div class="form-group">
                    <div class="pt-3 d-grid">

                      <button
                      name="register_btn"
                        class="btn btn-block btn-lg btn-info"
                        type="submit"
                      >
                        Sign Up
                      </button>

                      <br>
                      <div class="text-center text-primary fw-bold"><small>Already Registered? <a href="newlogin.php"
                        class="text-white">Login Now</a></small>
                    </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- Login box.scss -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper scss in scafholding.scss -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper scss in scafholding.scss -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right Sidebar -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right Sidebar -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
      $(".preloader").fadeOut();
    </script>
    </form>
  </body>
</html>
