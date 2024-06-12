<?php

session_start();

//mengecek username pada session
if( !isset($_SESSION['username']) ){
  $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
  header('Location:login.php');
}

include("koneksi.php");
// Mengambil data konser
$queryKonser = "SELECT * FROM concert";
$resultKonser = mysqli_query($koneksi, $queryKonser);

// Mengambil data tiket
$queryTiket = "SELECT * FROM ticket";
$resultTiket = mysqli_query($koneksi, $queryTiket);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <section class="max-w-4xl mx-auto p-6 bg-white rounded shadow-md mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Pemesanan Tiket</h2>
        <?php if(isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-warning text-center">
                <?= $_SESSION['error_msg']; ?>
                <?php unset($_SESSION['error_msg']); ?>
            </div>
        <?php endif; ?>
        <form action="tiket_action.php" method="post" class="space-y-4">
            <div class="form-group">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap:</label>
                <input type="text" name="nameTransaction" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="form-group">
                <label for="nomor" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon:</label>
                <input type="text"  name="telpTransaction" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="form-group">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Alamat Email:</label>
                <input type="text" name="mailTransaction" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="form-group">
                <label for="konser" class="block text-gray-700 text-sm font-bold mb-2">Pilih Konser:</label>
                <select name="idConcert" id="konser" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <?php while ($row = mysqli_fetch_assoc($resultKonser)) { ?>
                        <option value="<?= $row['idConcert'] ?>"><?= $row['nameConcert'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tiket" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tiket:</label>
                <select name="idTicket" id="tiket" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <?php while ($row = mysqli_fetch_assoc($resultTiket)) { ?>
                        <option value="<?= $row['idTicket'] ?>"><?= $row['classTicket'] ?> - Rp <?= number_format($row['priceTicket'], 0, ',', '.') ?></option>
                        <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Tiket:</label>
                <input type="number" name="qtyTransaction" min="1" value="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex justify-between">
                <button type="button" onclick="window.location.href='index.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kembali ke Beranda</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pesan Tiket</button>
            </div>
        </form>
    </section>
</body>
</html>