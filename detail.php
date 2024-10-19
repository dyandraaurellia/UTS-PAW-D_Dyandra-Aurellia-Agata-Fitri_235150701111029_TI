<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $movie_id = intval($_GET['id']); 
    $sql = "SELECT * FROM movies WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "Movie not found.";
        exit();
    }
} else {
    echo "Invalid movie ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .movie-container {
            background-color: #fff;
            padding: 20px;
            width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 20px;
        }
        .movie-poster {
            width: 150px;
            height: 225px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }
        .movie-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }
        p {
            font-size: 14px;
            margin: 5px 0;
            color: #555;
        }
        p strong {
            color: #333;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            align-self: start;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="movie-container">
        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
             alt="Poster of <?php echo htmlspecialchars($movie['title']); ?>" 
             class="movie-poster">
        
        <div class="movie-details">
            <div>
                <h2><?php echo htmlspecialchars($movie['title']); ?></h2>
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($movie['duration']); ?> minutes</p>
                <p><strong>Synopsis:</strong> <?php echo htmlspecialchars($movie['synopsis']); ?></p>
            </div>
            <a href="index.php?page=home" class="back-btn">Back to Movie List</a>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
