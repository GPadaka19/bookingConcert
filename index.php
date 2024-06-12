<?php 
include("koneksi.php");
$konser = mysqli_query($koneksi, "SELECT * FROM concert");
session_start();
$queryHarga = "SELECT MIN(priceTicket) AS hargaTerkecil, MAX(priceTicket) AS hargaTerbesar FROM ticket";
$resultHarga = mysqli_query($koneksi, $queryHarga);
$harga = mysqli_fetch_assoc($resultHarga);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
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
    <div class="flex justify-center mt-4">
        <a href="tiket_saya.php" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Tiket Saya</a>
    </div>
    <section id="upcoming-concerts" class="mt-8">
        <h2 class="text-2xl font-bold text-center">Event yang Akan Datang</h2>
        <div class="flex flex-col justify-center mt-4">
        <?php 
        foreach ($konser as $key => $value) {
        ?>
            <div class="flex max-w-3/4 rounded overflow-hidden bg-white rounded-lg shadow-lg m-4">
                <img class="w-1/4 h-64" src="assets/img/<?= $value['imgConcert'] ?>" alt="Poster Konser">
                <div class="w-3/4 px-6 py-4">
                    <div class="font-bold text-xl mb-2"><?= $value['nameConcert'] ?></div>
                    <p class="text-gray-700 text-base"><?= date('d F Y', strtotime($value['dateConcert'])) ?></p>
                    <p class="text-gray-700 text-base"><?= $value['locProvConcert'] ?></p>
                    <p class="text-gray-700 text-base">Harga: Rp<?= number_format($harga['hargaTerkecil'], 0, ',', '.') ?> - Rp<?= number_format($harga['hargaTerbesar'], 0, ',', '.') ?></p>
                    <a href="<?= $value['detailConcert'] ?>" class="inline-block bg-blue-500 text-white rounded px-3 py-1 text-sm font-semibold mt-2">Lihat Detail</a>
                </div>
            </div>
        <?php
        }
        ?>
        </div>
    </section>

</body>
</html>


