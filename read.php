<?php

session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

$xml = new DOMDocument();
$xml->load("movies.xml");

$movies = $xml->getElementsByTagName("movie");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>
    <link rel="stylesheet" href="css/read.css">
</head>
<body>
    <h1>Movie List</h1>
    <button id="addButton">Add Movie</button>
    <button id="logoutButton" class="edit-button" style="position:absolute; right: 40px">Logout</button>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Actor</th>
            <th>Genre</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($movies as $movie) : ?>
            <tr>
                <td><?php echo $movie->getAttribute("id"); ?></td>
                <td><?php echo $movie->getElementsByTagName("title")->item(0)->nodeValue; ?></td>
                <td><?php echo $movie->getElementsByTagName("actor")->item(0)->nodeValue; ?></td>
                <td><?php echo $movie->getElementsByTagName("genre")->item(0)->nodeValue; ?></td>
                <td><?php echo $movie->getElementsByTagName("date")->item(0)->nodeValue; ?></td>
                <td><button class="edit-button" onclick="window.location.href='update.php?id=<?php echo $movie->getAttribute("id"); ?>'">Edit</button></td>
                <td><button class="delete-button" onclick="window.location.href='delete.php?id=<?php echo $movie->getAttribute("id"); ?>'">Delete</button></td>

            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        // Redirect to create.php when Add Movie button is clicked
        document.getElementById("addButton").addEventListener("click", function() {
            window.location.href = "create.php";
        });

        document.getElementById("logoutButton").addEventListener("click", function() {
            window.location.href = "index.php";
        });
    </script>

</body>
</html>
