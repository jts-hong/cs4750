<?php
// Initialize the session
session_start();
require("config.php");
require("car-db.php");
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$amount_error = "";
$length=$start_date=$amount="";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Submit')
  {
    
    $amount_error = insertNewFinance($_SESSION["user_id"], $_POST["amount"], $_POST["finance_length"], $_POST["interest_rate_form"], $_POST["start_date"]);
    echo $amount_error; 
    
    $length = $_POST["finance_length"];
    $start_date = $_POST["start_date"];
    $amount = $_POST["amount"];
    if ($amount_error == ""){
        header("location: account.php");
    }
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

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }


    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Finance Application</h2>
        <p>Please fill this form to apply for a loan</p>
        <ul>
            <p>User Notice</p>
            <li> This application will potentially grant a loan to <?php echo $_SESSION["username"]; ?>'s account and could be used in any purchase on this website</li>

        </ul>
        This application will potentially grant a loan to this user account and could be used in any purchase in this website
            
        </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Amount</label>
                <input type="hidden" name="interest_rate_form" id = "hidden_interest"/>
                <input oninput="amountFunc()" id = "amountButton" type="number" name="amount" class="form-control <?php echo (!empty($amount_error)) ? 'is-invalid' : ''; ?>" value= <?php echo $amount; ?>>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
                <script>
                // $("#amountButton"){

                // }
                // document.getElementsById("   interest_rate")[0].innerHTML = 222;
                function amountFunc(){
                    // alert("11111aaaaa");
                    // document.getElementById('interest_rate').innerHTML = document.getElementById('amountButton').value;
                    if(document.getElementById('amountButton').value <= 5000){
                        // alert("aaa");
                        document.getElementById('interest_rate').innerHTML = 3.5;
                        document.getElementById('hidden_interest').value = 3.5;
                    }else if(document.getElementById('amountButton').value <= 10000){
                        document.getElementById('interest_rate').innerHTML = 6.3;
                        document.getElementById('hidden_interest').value = 6.3;
                    }else if(document.getElementById('amountButton').value <= 30000){
                        document.getElementById('interest_rate').innerHTML = 8.3;
                        document.getElementById('hidden_interest').value = 8.3;
                    }else{
                        document.getElementById('interest_rate').innerHTML = 9.5;
                        document.getElementById('hidden_interest').value = 9.5;
                    }
                    
                }
                </script>
                <span class="invalid-feedback">Finance amount must be >= 2000</span>
            </div> 
            
            <div class="form-group">
                <label>Finance Length in Days</label>
                <input required type="number" min = "30" name="finance_length" class="form-control <?php echo (!empty($length_err)) ? 'is-invalid' : ''; ?>" value = <?php echo $length; ?> >
                <span class="invalid-feedback"><?php echo $length_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Start Date</label>
                <input required type="date" name="start_date" class="form-control <?php echo (!empty($start_date_err)) ? 'is-invalid' : ''; ?>" value = <?php echo $start_date; ?> >
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
                <script>
                    var today = new Date().toISOString().split('T')[0];
                    document.getElementsByName("start_date")[0].setAttribute('min', today);
                </script>
                <span class="invalid-feedback"><?php echo $start_date_err; ?></span>
       
           
            <p>Interest Rate (%):</p>
            <p id = "interest_rate"> 0 </p>

            
            <div class="form-group">
                <input name="btnAction" type="submit" class="btn btn-primary" value="Submit">
               
            </div>

        </form>
    </div>    
</body>
</html>