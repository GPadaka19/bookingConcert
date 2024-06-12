<?php 
include("koneksi.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
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
        <h1 class="text-center mt-32 text-3xl" >Data tidak ditemukan</h1>

</body>
</html>