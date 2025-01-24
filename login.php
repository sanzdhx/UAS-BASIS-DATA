<?php
session_start();
include 'koneksi.php'; // File koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username, password, dan level pengguna
    $query = "SELECT * FROM pegawai WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error pada query: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pegawai = $result->fetch_assoc();
        $_SESSION['id_pegawai'] = $pegawai['id_pegawai']; // Simpan ID pengguna
        $_SESSION['username'] = $pegawai['username']; // Simpan username
        $_SESSION['level'] = $pegawai['level']; // Simpan level

        // Redirect berdasarkan level
        if ($pegawai['level'] === 'admin') {
            header('Location: indexfix.php');
        } elseif ($pegawai['level'] === 'kasir') {
            header('Location: indexkasir.php');
        } else {
            echo "Level tidak dikenali.";
        }
        exit;
    } else {
        echo "Login gagal! Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e9ecef;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: #496fdb; /* Background color */
            color: white; /* White text */
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }
        .login-card img {
            width: 100px; /* Adjust logo size */
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: white;
            color: #496fdb; /* Text color matching background */
            border: 2px solid #496fdb;
        }
        .btn-login:hover {
            background-color: #496fdb;
            color: white;
            border-color: #496fdb;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="img/pngegg.png" alt="Logo"> <!-- Logo added here -->
        <h3 class="mb-4">Login Kumarizz</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login w-100">Login</button> <!-- White button with blue border -->
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
