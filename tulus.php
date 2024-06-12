<?php
include("koneksi.php");
$konser = mysqli_query($koneksi, "SELECT * FROM concert WHERE idConcert = 3");
$queryTicket = "SELECT * FROM ticket";
$resultTicket = mysqli_query($koneksi, $queryTicket);
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konser</title>
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
    <section class="max-w-4xl mx-auto text-center p-5">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Detail Konser</h2>
        <div class="concert-info bg-white shadow-lg rounded-lg overflow-hidden">
            <?php while($row = mysqli_fetch_assoc($konser)) { ?>
                <img class="w-3/4 h-1/2 mx-auto" src="assets/img/<?= $row['imgConcert'] ?>" alt="Poster Konser">
                <div class="p-5">
                    <h3 class="text-2xl font-bold text-gray-700"><?= $row['nameConcert'] ?></h3>
                    <p class="mt-3"><span class="font-semibold">Penyanyi:</span> <?= $row['guestConcert'] ?></p>
                    <p class="mt-1"><span class="font-semibold">Event Dimulai:</span> <?= date('d F Y', strtotime($row['dateConcert'])) ?></p>
                    <p class="mt-1"><span class="font-semibold">Deskripsi:</span> <?= $row['descConcert'] ?></p>
                    <p class="mt-1"><span class="font-semibold">Lokasi:</span> <?= $row['locationConcert'] ?></p>
                </div>
                <img class="mt-3 mx-auto" src="assets/img/rowseat.jpg" alt="Seating Plan">
                <?php

                $tickets = [];
                while ($ticket = mysqli_fetch_assoc($resultTicket)) {
                    $tickets[] = $ticket;
                }
                echo "<table class='table-auto w-1/2 mt-4 mx-auto border-collapse border border-gray-300 my-5'>";
                echo "<thead class='bg-gray-200'><tr><th class='border px-4 py-2'>Kelas Tiket</th><th class='border px-4 py-2'>Tiket Tersedia</th></tr></thead>";
                echo "<tbody>";
                foreach ($tickets as $ticket) {
                    echo "<tr><td class='border px-4 py-2'>" . $ticket['classTicket'] . "</td><td class='border px-4 py-2'>" . $ticket['stockTicket'] . "</td></tr>";
                }
                echo "</tbody></table>";
                ?>
            <?php } ?>
            <div class="p-5 bg-gray-200 flex justify-between items-center">
                <a href="index.php" class="text-blue-500 hover:text-blue-700">Kembali ke Menu Utama</a>
                <a href="pesan_tiket.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pesan Tiket</a>
            </div>
        </div>
    </section> 
</body>
</html>



