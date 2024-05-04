<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST["username-bar"];
    $password = $_POST["password-bar"];

    // Load existing XML file or create a new one if it doesn't exist
    $xml = file_exists("account.xml") ? simplexml_load_file("account.xml") : new SimpleXMLElement('<informations></informations>');

    // Append a new <information> element with username and password
    $info = $xml->addChild('information');
    $info->addChild('username', $username);
    $info->addChild('password', $password);

    // Save the updated XML to the file
    $xml->asXML("account.xml");

    // Redirect to login page
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
<div class="bg">
    <div class="div1">
        <p class="inside">Create an Account</p>

        <form method="post" action="">
            <p class="username">Username</p>
            <input type="text" class="username-bar" name="username-bar" required>

            <p class="password">Password</p>
            <input type="password" class="password-bar" name="password-bar" required>

            <button type="submit">Sign Up</button>
        </form>

        <a href="login.php" class="create">Already have an account? Login here</a>
    </div>
    <p class="design">2022 Signup Form. All Right Reserved | Design by Roldan</p>
</div>
</body>
</html>
