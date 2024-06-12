<?php
//menyertakan file program koneksi.php pada register
require('koneksi.php');
session_start();

// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data username dan password dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Membuat query untuk memeriksa username dan password di database
    $query = "SELECT * FROM account WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);

    // Mengecek hasil query
    if (mysqli_num_rows($result) == 1) {
        // Jika ditemukan, set session dan redirect ke halaman utama
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['idAccount'] = $row['idAccount'];
        header("location: index.php");
    } else {
        // Jika tidak ditemukan, tampilkan pesan error
        $error = "Username atau Password salah";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<nav class="bg-white shadow-md">
        <ul class="flex justify-between items-center p-4">
            <li class="flex-grow">
                <form action="search.php" method="get" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari..." class="px-4 py-2 border rounded">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Cari</button>
                </form>
            </li>
            <li>
                <a href="index.php" class="text-blue-500 hover:text-blue-700">Beranda</a>
                <?php if(isset($_SESSION['username'])): ?>
                    <a href="logout.php" class="ml-4 text-blue-500 hover:text-blue-700">Logout (<?= $_SESSION['username'] ?>)</a>
                <?php else: ?>
                    <a href="login.php" class="ml-4 text-blue-500 hover:text-blue-700">Login</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
    <section id="login-section" class="max-w-lg mx-auto p-6 bg-white rounded shadow-md mt-10">
    <form action="login.php" method="post">
        <div class="form-group-login mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
            <input type="text" id="username" name="username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="form-group-login mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
            <input type="password" id="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex justify-center">
            <button id="login-button" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</button>
        </div>
    </form>
    </section>
</body>
</html>

