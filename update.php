<?php

session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Check if the movie ID is provided in the URL
if (isset($_GET['id'])) {
    $movieId = $_GET['id'];

    // Load the XML file and fetch the movie information based on the ID
    $xml = new DOMDocument();
    $xml->load("movies.xml");

    // Get all movie elements
    $movies = $xml->getElementsByTagName("movie");

    // Iterate through each movie element to find the one with the matching ID
    $found = false;
    foreach ($movies as $movie) {
        if ($movie->getAttribute("id") == $movieId) {
            $found = true;
            $title = $movie->getElementsByTagName("title")->item(0);
            $actor = $movie->getElementsByTagName("actor")->item(0);
            $genre = $movie->getElementsByTagName("genre")->item(0);
            $date = $movie->getElementsByTagName("date")->item(0);

            // Now you can display the movie information for editing
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Movie</title>
                <link rel="stylesheet" href="css/update.css">
            </head>
            <body>
                <form method="post" action="">
                    <!-- <label for="id">Movie ID:</label><br>
                    <input type="text" name="id" value="<?php echo $movieId; ?>"><br> -->
                    <label for="title">Title:</label><br>
                    <input type="text" id="title" name="title" value="<?php echo $title->nodeValue; ?>"><br>
                    <label for="actor">Actor:</label><br>
                    <input type="text" id="actor" name="actor" value="<?php echo $actor->nodeValue; ?>"><br>
                    <label for="genre">Genre:</label><br>
                    <input type="text" id="genre" name="genre" value="<?php echo $genre->nodeValue; ?>"><br>
                    <label for="date">Date:</label><br>
                    <input type="date" id="date" name="date" value="<?php echo $date->nodeValue; ?>"><br><br>
                    <input type="submit" name="submit" value="Update">
                </form>
            </body>
            </html>
            <?php
            break; // Exit the loop once the movie is found
        }
    }

    // If the movie with the provided ID is not found
    if (!$found) {
        echo "Movie not found!";
    }
} else {
    echo "Movie ID not provided!";
}

// Process the form submission
if (isset($_POST['submit'])) {
    // Get the movie ID and updated details from the form
    $updatedTitle = $_POST['title'];
    $updatedActor = $_POST['actor'];
    $updatedGenre = $_POST['genre'];
    $updatedDate = $_POST['date'];

    // Find the movie element with the provided ID
    foreach ($movies as $movie) {
        if ($movie->getAttribute("id") == $movieId) {
            // Update the movie details
            $movie->getElementsByTagName("title")->item(0)->nodeValue = $updatedTitle;
            $movie->getElementsByTagName("actor")->item(0)->nodeValue = $updatedActor;
            $movie->getElementsByTagName("genre")->item(0)->nodeValue = $updatedGenre;
            $movie->getElementsByTagName("date")->item(0)->nodeValue = $updatedDate;

            // Save the changes back to the XML file
            $xml->save("movies.xml");

            // Redirect back to the movies list after updating
            header("Location: read.php");
            exit;
        }
    }
}
?>
