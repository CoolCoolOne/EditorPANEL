<?php 

//LOGIN PAGE TAMPLATE & FUNCTIONALITY


// Include config file
require "vendor/config.php";
// // Initialize the session
session_start();

// echo ($_SESSION['TempId']);
// echo ($_SESSION['TempUser']);
// echo ($_SESSION['goToPrevious']);



 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ 
    if(isset($_SESSION["role"]) && $_SESSION["role"] == 'admin'){
        header("location: welcome-marko.php");
    } else {
        $username_role_ = mysqli_query($db, "SELECT * FROM `users` WHERE `username` LIKE '$username'");
        $username_role = mysqli_fetch_assoc($username_role_);
        
        $_SESSION["role"] = $username_role['role'];
        

        require "./revRedir/reverseRedir.php";
    }
    exit;
}


 
// Define variables and initialize with empty values


// if (isset($_SESSION['TempUser'])) {
//     $username = $_SESSION['TempUser'];
//     echo 'hello';
// }else{
//     $username = $password = "";
// }
$username = $password = "";

$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;    
                            
                            $username_role_ = mysqli_query($db, "SELECT * FROM `users` WHERE `username` LIKE '$username'");
                            $username_role = mysqli_fetch_assoc($username_role_);


                            $_SESSION["role"] = $username_role['role'];
                            if(isset($_SESSION["role"]) && $_SESSION["role"] == 'admin'){
                                    header("location: welcome-marko.php");
                                } else {
                                    require "./revRedir/reverseRedir.php";
                                }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
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
    mysqli_close($db);
}
?>

<!DOCTYPE html>

<html lang="fi" >

<head>

  <meta charset="UTF-8">

  <title>WF työmaaeditori</title>

  <link rel="stylesheet" href="/css/style.css">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="user-scalable=yes">
  <link rel="apple-touch-icon" sizes="180x180" href="/css/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/css/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/css/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/css/favicon-16x16.png">
  <link rel="icon" type="image/x-icon" href="/css/favicon.ico">

<style>
    main {
      display: none;
    }

    .showpwd {
        padding: 0px;
        width: 100%;
        display: inline-block;
        line-height: 2;
        margin-top: 0px;
        background: gray;
        color: white;

    }
 </style>
</head>

<body>

<section id="login__form">

    <h1>Tervetuloa levyeditoriin!</h1>

      <div class="container">

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php 
        echo htmlspecialchars($_SERVER["PHP_SELF"]); 
        // code for redirect to previous prj page
        if (isset($_SESSION['TempUser'])) {
                    $username = $_SESSION['TempUser'];
                    $_SESSION['goToPrevious'] = true;
                }
        ?>" method="post">
            <div class="form-group">
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"  placeholder="Tunnus">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>


            </div>    
            <div class="form-group">
                <input id="passwd" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"  placeholder="Salasana">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <div class="form-group">
                    
                    <input type="checkbox" onclick="showpassword();" id="showpwd">
                    <label for="showpwd" class="showpwd">Näytä salasana</label>
                </div>
                

            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Kirjaudu sisään">
            </div>
            <!-- <p>Eikö tiliä löydy? <a href="register.php">Rekisteröidy</a>. <br> Mikäli et muista salasanaasi, ota yhteyttä Koodariin</p> -->
        </form>
      </div>

</section>
<script>
    function showpassword() {
        var x = document.getElementById("passwd");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?php 

include('./footer.php') ?>