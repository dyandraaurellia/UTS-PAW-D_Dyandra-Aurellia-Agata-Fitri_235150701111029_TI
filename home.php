<?php
// Cek apakah sesi sudah dimulai sebelum memanggil session_start
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Hapus film
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitasi input untuk mencegah SQL injection
    $sql = "DELETE FROM movies WHERE id = $id";
    $conn->query($sql);
    header("Location: index.php?page=home");
    exit();
}

// Ambil data film dari database
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            color: #333;
        }
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .movie-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            text-align: center;
        }
        .movie-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .movie-details {
            padding: 15px;
        }
        .movie-details h3 {
            font-size: 20px;
            margin: 10px 0;
            color: #333;
        }
        .movie-details p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }
        .action-buttons {
            margin-top: 15px;
            display: flex;
            justify-content: space-around;
        }
        .action-buttons a {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            color: white;
        }
        .view-btn {
            background-color: #007bff;
        }
        .edit-btn {
            background-color: #28a745;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .button-container a {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            color: white;
            margin: 0 10px;
        }
        .add-movie-btn {
            background-color: #007bff;
        }
        .logout-btn {
            background-color: #dc3545;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .add-movie-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Movie List</h2>

        <div class="movie-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="movie-card">
                    <img src="<?php echo htmlspecialchars($row['poster_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?> Poster">
                    <div class="movie-details">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                        <p><strong>Director:</strong> <?php echo htmlspecialchars($row['director']); ?></p>
                        <p><strong>Release Date:</strong> <?php echo htmlspecialchars($row['release_date']); ?></p>
                        <div class="action-buttons">
                            <a href="index.php?page=detail&id=<?php echo $row['id']; ?>" class="view-btn">View</a>
                            <a href="index.php?page=update&id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="index.php?page=home&action=delete&id=<?php echo $row['id']; ?>" 
                               class="delete-btn" 
                               onclick="return confirm('Are you sure you want to delete this movie?');">
                               Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="button-container">
            <a href="index.php?page=add_movie" class="add-movie-btn">Add Movies</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
