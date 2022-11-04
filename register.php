<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $firstname =$lastname = $address =$confirm_password =$phone =$gender=$email= "";
$username_err = $password_err = $confirm_password_err = "";
 
// email phone gender separate table 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
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
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $username =  trim($_POST["username"]);
        $first_name= trim($_POST["firstname"]);
        $last_name = trim($_POST["lastname"]);
        $address = trim($_POST["address"]);
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Prepare an insert statement
        $sql = "INSERT INTO users(username, password, first_name, last_name, address)  VALUES (?,?,?,?,?)";
        //  INSERT INTO users(username, password, first_name, last_name, address) 
        //  VALUES('uname', 'pword', 'fname', 'lname', '102 street, city, 293854');
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $username, $password,$first_name,$last_name,$address);

             // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page

                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                echo $stmt->error;
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    //Adding user email to user_email

    $em = "SELECT user_id FROM users WHERE username = '$username'";
    $q = mysqli_query($link,$em);
    $n = mysqli_fetch_array($q);
    $user_id = intval($n['user_id']);
    $email = trim($_POST["email"]);
    $sql = "INSERT INTO user_email  VALUES (?,?)";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $user_id, $email);
        
        // Set parameters
        $param_user_id = $user_id;
        $param_email = $email;

        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: login.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    //Adding user phone to user_phone

    $em = "SELECT user_ FROM users WHERE username = '$username'";
    $q = mysqli_query($link,$em);
    $n = mysqli_fetch_array($q);
    $id = intval($n['user_id']);
    $phone = trim($_POST["phone"]);
    $sql = "INSERT INTO user_phone  VALUES (?,?)";

    //echo gettype($phone)."\n";
    //echo  $phone;

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $user_id, $phone);
        
        // Set parameters
        $param_user_id = $user_id;
        $param_phone = $phone;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: login.php");
        } else{
            echo $stmt->error;
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    //Adding user gender to user_gender

    $em = "SELECT user_id FROM users WHERE username = '$username'";
    $q = mysqli_query($link,$em);
    $n = mysqli_fetch_array($q);
    $id = intval($n['user_id']);
    $gender = trim($_POST["gender"]);
    $sql = "INSERT INTO user_gender  VALUES (?,?)";

    //echo gettype($phone)."\n";
    //echo  $phone;

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $user_id, $gender);
        
        // Set parameters
        $param_user_id = $user_id;
        $param_gender = $gender;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: login.php");
        } else{
            echo $stmt->error;
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control ">
                <span class="invalid-feedback"></span>
            </div> 
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control ">
                <span class="invalid-feedback"></span>
            </div> 

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control ">
                <span class="invalid-feedback"></span>
            </div> 

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control ">
                <span class="invalid-feedback"></span>
            </div> 

            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control ">
                <span class="invalid-feedback"></span>
            </div> 
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control ">
                <span class="invalid-feedback"></span>
            </div> 
            <div class="form-group">
                <label>Gender</label>
                <input type="text" name="gender" class="form-control ">
                <span class="invalid-feedback"></span>
            </div> 

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>