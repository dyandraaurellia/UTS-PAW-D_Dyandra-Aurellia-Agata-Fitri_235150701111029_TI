<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $release_date = $_POST['release_date'];

    // Upload poster
    $poster = $_FILES['poster']['name'];
    $target = "uploads/" . basename($poster);
    move_uploaded_file($_FILES['poster']['tmp_name'], $target);

    $sql = "INSERT INTO movies (title, genre, director, release_date, poster_url) 
            VALUES ('$title', '$genre', '$director', '$release_date', '$target')";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
