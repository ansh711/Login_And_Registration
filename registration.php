<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
             $fullname = $_POST["fullname"];
             $email = $_POST["email"];
             $stream = $_POST["stream"];
             $year = $_POST["year"];
             $password = $_POST["password"];
             $repeatpassword = $_POST["repeat_password"];
             $passwordhash = password_hash($password, PASSWORD_DEFAULT);
             $errors = array();
            if (empty($fullname) OR empty($email) or empty($stream) or empty($year) or empty($password) or empty($repeatpassword) ) {
                array_push($errors,"All fields are required ");
            }
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                array_push($errors,"Email is not valid");
            }
            if (strlen($password)<8) {
                array_push($errors,"password must be at least 8 characters long ");
            }
            if ($password!==$repeatpassword) {
                array_push($errors,"password does not match ");

            }
            require_once "database.php";
            $sql= "SELECT * FROM students WHERE email = '$email'";
            $result = mysqli_query($yo,$sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors,"Email already exists .");
            }

            if (count($errors)>0) {
               foreach ($errors as  $error) {
                  echo "<div class='alert alert-=danger'>$error</div>";
               }
                
            }
            else {
                //we will enter the data then 
                
                $sql = "INSERT INTO students (full_name,email,stream,year,password) VALUES (?,?,?,?,?)";
                 $stmt = mysqli_stmt_init($yo);
                $preparestmt= mysqli_stmt_prepare($stmt,$sql);
                if ($preparestmt) {
                    mysqli_stmt_bind_param($stmt,"sssis",$fullname,$email,$stream,$year,$passwordhash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class= 'alert alert-success'>You are registered successfully.</div>";
                }
                else {
                    die("something went wrong.");
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="stream" placeholder="Stream:">
            </div>
            <div class="form-group">
                <input type="integer" class="form-control" name="year" placeholder="year:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
            <p>
                Already Registered<a href="login.php"> Login Here</a>
            </p>
        </div>

    </div>
    
</body>
</html>