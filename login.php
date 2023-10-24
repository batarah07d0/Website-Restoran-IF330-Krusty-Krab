<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/krusty-krab.png">
    <title>Krusty Krab | Login Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch'
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">
    #buttn {
        color: #fff;
        background-color: #ff3300;
    }
    </style>

</head>

<body>
    <?php
include("connection/connect.php"); // INCLUDE CONNECTION
error_reporting(0); // Hide undefined index errors
session_start(); // Start session

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Use a prepared statement to prevent SQL injection
        $loginquery = "SELECT u_id, username, password FROM users WHERE username = ?";
        $stmt = $db->prepare($loginquery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($u_id, $db_username, $db_password);
            $stmt->fetch();

            // Verify the hashed password
            if (password_verify($password, $db_password)) {
                $_SESSION["user_id"] = $u_id;
                header("Location: index.php");
                exit;
            } else {
                $message = "Invalid Username or Password!";
            }
        } else {
            $message = "Invalid Username or Password!";
        }

        $stmt->close();
    }
}
?>

    <!-- Form Mixin-->
    <!-- Input Mixin-->
    <!-- Button Mixin-->
    <!-- Pen Title-->
    <div class="pen-title">
        <h1>Login Form</h1>
    </div>
    <!-- Form Module-->
    <div class="module form-module">
        <div class="toggle">

        </div>
        <div class="form">
            <h2>Login to your account</h2>
            <span style="color:red;"><?php echo $message; ?></span>
            <span style="color:green;"><?php echo $success; ?></span>
            <form action="" method="post">
                <input type="text" placeholder="Username" name="username" />
                <input type="password" placeholder="Password" name="password" />
                <input type="submit" id="buttn" name="submit" value="login" />
            </form>
        </div>

        <div class="cta">Not registered?<a href="registration.php" style="color:#f30;"> Create an account</a></div>
        <div class="cta">Login as Admin<a href="admin/index.php" style="color:#f30;"> Admin page</a></div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>

</html>