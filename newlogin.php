<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location: studentLanding.html");
//     exit;
// }
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
      //  $role=$_POST['role']; 
        // Prepare a select statement
        $sql = "SELECT id,first_name,role,email_id, password FROM user_table WHERE email_id = ? AND password = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss",$email,$password);
            
            // Set parameters
            // $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) > 0){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id,$firstname, $role,$email, $password);
                    if(mysqli_stmt_fetch($stmt)){
                        // if(password_verify($password, $hashed_password)){
                        //     // Password is correct, so start a new session
                          //  session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            $_SESSION["role"] = $role;
                            $_SESSION['first_name']=$firstname;
                            
                            // Redirect user to welcome page
                            if($_SESSION['role']==1){
                                echo '<script>alert("Login Successfully!!");
                                window.location.href="studentLanding.html"
                                </script>';
                            }
                             elseif($_SESSION['role']==2){
                                echo '<script>alert("Login Successfully faculty !!");
                                window.location.href="facultyLanding.html"
                                </script>';
                            }
                            else{
                                echo '<script>alert("Login Successfully admin!!");
                                window.location.href="admin.html"
                                </script>';
                            }
                           
                        // } else{
                        //     // Password is not valid, display a generic error message
                        //     $login_err = "Invalid username or password.";
                        // }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
    <link href="./dist/css/style.min.css" rel="stylesheet" />
    
  </head>

  <body>
    <div class="main-wrapper">
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
          <div id="loginform">
            <div class="text-center pt-3 pb-3">
              <span class="db"
                ><img src="./assets/images/logo-text1.png" alt="logo"
              /></span>
            </div>
            <!-- Form -->
            <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
            <form
              method="POST"
              id="loginform"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            >
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
                  placeholder="Email Address"
                  aria-label="Username"
                  aria-describedby="basic-addon1"
                  name="email"
                />
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
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
                      class="form-control form-control-lg  <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                      placeholder="Password"
                      aria-label="Password"
                      aria-describedby="basic-addon1"
                      name="password"
                    />
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                  </div>
                </div>
              
              
              <div class="row border-top border-secondary">
                <div class="col-12">
                  <div class="form-group">
                    <div class="pt-3">
                      <button
                        class="btn btn-info"
                        id="redirect"
                        name="redirect"
                        type="button"
                      >
                        <i class="mdi mdi fs-4 me-1"></i> Register
    
                      </button>
                      <button
                        class="btn btn-success float-end text-white"
                        id="toredirect"
                        name="toredirect"
                        type="submit"
                      >
                        Login
                      </button>
                    </div>
                  </div>
                </div>
    </form>
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
      // ==============================================================
      // Login and Recover Password
      // ==============================================================
      $("#redirect").click(function () {
       location.href='newstudent_registration.php';
      });
    //   $("#toredirect").click(function () {
    //     location.href='mainBody.html';
    //   });
    </script>
  </body>
</html>