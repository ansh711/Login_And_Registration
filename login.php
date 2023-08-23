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
    <title>Lgin Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <?php
        if (isset($_POST["login"])) {
             $email = $_POST["email"];
             $password = $_POST["password"];
             require_once "database.php";
             $sql = "SELECT * FROM students WHERE email = '$email'";
             $result = mysqli_query($yo,$sql);
             $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
             if ($user) {
                if (password_verify($password,$user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("location: index.php");
                    die();
                }else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
             }else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
             }
        }
    ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email" name ="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password" name ="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name ="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>
                Not Registered Yet <a href="registration.php"> Register Here</a>
            </p>
        </div>
    </div>
</body>
</html>