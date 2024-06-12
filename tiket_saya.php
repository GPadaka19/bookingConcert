<?php
require('koneksi.php');
session_start();

// Cek apakah user sudah login dengan memeriksa session idAccount
if (isset($_SESSION['idAccount'])) {
    $idAccount = $_SESSION['idAccount'];

    // Query untuk mengambil data transaksi berdasarkan idAccount
    $query = "SELECT transactions.*, ticket.classTicket,concert.imgConcert, concert.nameConcert 
              FROM transactions 
              JOIN ticket ON transactions.idTicket = ticket.idTicket 
              JOIN concert ON transactions.idConcert = concert.idConcert 
              WHERE transactions.idAccount = '$idAccount'";
    $result = mysqli_query($koneksi, $query);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Transaksi Saya</title>
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
        <div class="container mx-auto p-4">
            <h2 class="text-3xl text-center mt-3 font-bold mb-4">Tiket Saya</h2>
            <?php
            if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <?php
                    // Output data setiap baris
                    while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="flex flex-col justify-center mt-4">
                            <div class="flex max-w-3/4 rounded overflow-hidden bg-white rounded-lg shadow-lg m-4">
                                <div class="w-full px-6 py-4 flex flex-row space-y-5">
                                    <img src="assets/img/<?php echo $row['imgConcert']; ?>" alt="Gambar Konser" class="w-1/4 h-50 mb-4">
                                    <div class="flex flex-col ml-4">
                                        <div class="font-bold text-xl mb-2">Nama Konser: <?php echo $row["nameConcert"]; ?></div>
                                        <p class="text-gray-700 text-base">Kelas Tiket: <?php echo $row["classTicket"]; ?></p>
                                        <p class="text-gray-700 text-base">Nama Transaksi: <?php echo $row["nameTransaction"]; ?></p>
                                        <p class="text-gray-700 text-base">Telepon: <?php echo $row["telpTransaction"]; ?></p>
                                        <p class="text-gray-700 text-base">Email: <?php echo $row["mailTransaction"]; ?></p>
                                        <p class="text-gray-700 text-base">Tanggal Transaksi: <?php echo $row["transactionDate"]; ?></p>
                                        <p class="text-gray-700 text-base">Jumlah Tiket: <?php echo $row["qtyTransaction"]; ?></p>
                                        <div class="flex space-x-4 mt-4">
                                            <a href="update_tiket.php?idTransaction=<?= $row['idTransaction']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-4 rounded">Update</a>
                                            <a href="hapus_tiket.php?id=<?= $row['idTransaction']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-4 rounded">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                    <?php
            } else {
                echo "<p class='text-red-500'>Tidak ada transaksi yang ditemukan.</p>";
            }
            ?>
        </div>
    </body>
    </html>
    <?php
} else {
    // Jika tidak ada session idAccount, redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>
