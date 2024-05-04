<?php

session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm_delete"])) {
    // Check if the movie ID is provided
    if (isset($_GET['id'])) {
        $movieId = $_GET['id'];

        // Load the XML file
        $xml = new DOMDocument();
        $xml->load("movies.xml");

        // Get all movie elements
        $movies = $xml->getElementsByTagName("movie");

        // Iterate through each movie element to find the one with the matching ID
        $found = false;
        foreach ($movies as $movie) {
            if ($movie->getAttribute("id") == $movieId) {
                $found = true;
                // Remove the movie element
                $movie->parentNode->removeChild($movie);
                // Save the changes back to the XML file
                $xml->save("movies.xml");
                break; // Exit the loop once the movie is found and deleted
            }
        }

        // Redirect back to the movies list after deletion
        header("Location: read.php");
        exit;
    } else {
        echo "Movie ID not provided!";
    }
}

if (isset($_POST['cancel'])) {
    header('Location: read.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Movie</title>
    <link rel="stylesheet" href="css/delete.css">
</head>
<body>
    <div class="container">
        <h1>Are you sure you want to delete this movie?</h1>
        <form method="post" action="">
            <button name="confirm_delete" id="delete">Yes</button>
            <button name="cancel">Cancel</button>
        </form>
    </div>
</body>
</html>
