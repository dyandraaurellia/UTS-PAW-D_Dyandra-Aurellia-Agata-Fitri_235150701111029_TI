<?php
session_start();
include 'db.php';

$error = "";  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah email sudah terdaftar
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email sudah terdaftar. Silakan gunakan email lain.";
    } else {
        // Jika email belum terdaftar, lanjutkan pendaftaran
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            // Pendaftaran berhasil
            header("Location: login.php");
            exit();
        } else {
            $error = "Terjadi kesalahan saat pendaftaran. Silakan coba lagi.";
        }
        $stmt->close();
    }

    $checkStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .register-container {
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            input, button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
