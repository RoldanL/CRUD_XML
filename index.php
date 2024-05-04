<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST["username-bar"];
    $password = $_POST["password-bar"];

    $xml = simplexml_load_file("account.xml");

    $loggedIn = false;

    // Loop through each <information> element in the XML
    foreach ($xml->information as $info) {
        // Check if username and password match
        if ($info->username == $username && $info->password == $password) {
            // Login successful, set session variable and redirect
            $_SESSION['loggedin'] = true;
            $loggedIn = true;
            header('location: read.php');
            exit;
        }
    }

    // If no matching user found, display error message
    if (!$loggedIn) {
        echo '<script>updateErrorMessage("Invalid username or password");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="bg">
        <div class="div1">
            <p class="inside">Roldan's Login Form</p>
            <form method="post">
                <p class="username">Username</p>
                <input type="text" class="username-bar" name="username-bar">
                <p class="password">Password</p>
                <input type="password" class="password-bar" name="password-bar">
                <input type="checkbox" class="check" name="check">
                <p class="remember">Remember me</p>
                <button type="submit">Login</button>
                <h4 name="check" id="error-message"></h4>
            </form>
            <a href="signup.php" class="create">Create an Account</a>
        </div>
        <p class="design">2022 Login Form. All Right Reserved | Design by Roldan</p>
    </div>

    <script>
    // JavaScript code to change the content of the h4 element
    // Get the h4 element
    var errorMessage = document.getElementById('error-message');

    // Function to update the error message
    function updateErrorMessage(message) {
        errorMessage.textContent = message;
    }

    // Update error message only if login attempt fails
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"): ?>
        updateErrorMessage("Invalid username or password");
    <?php endif; ?>
    </script>

</body>
</html>
