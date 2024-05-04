<?php

session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $xml = new DOMDocument("1.0");
    $xml->load("movies.xml");

    $id = $_POST["movieID"];
    $fullTitle = $_POST["title"];
    $fullActor = $_POST["actor"];
    $fullGenre = $_POST["genre"];
    $fullDate = $_POST["date"];

    $movie = $xml->createElement("movie");
    $title = $xml->createElement("title", $fullTitle);
    $actor = $xml->createElement("actor", $fullActor);
    $genre = $xml->createElement("genre", $fullGenre);
    $date = $xml->createElement("date", $fullDate);

    $movie->setAttribute("id", $id);
    $movie->appendChild($title);
    $movie->appendChild($actor);
    $movie->appendChild($genre);
    $movie->appendChild($date);

    $xml->documentElement->appendChild($movie);

    // Save the changes back to the XML file
    $xml->save("movies.xml");

    // Redirect to read.php
    echo "<script>window.location.href = 'read.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <link rel="stylesheet" href="css/create.css">
</head>
<body>
    <form method="post" action="">
        Movie ID : <input type="text" name="movieID"><br>
        Title : <input type="text" name="title"><br>
        Actor : <input type="text" name="actor"><br>
        Genre : <input type="text" name="genre"><br>
        Date : <input type="date" name="date"><br>
        <input type="submit" name="submit" value="Save" id="save">
    </form>

</body>
</html>
