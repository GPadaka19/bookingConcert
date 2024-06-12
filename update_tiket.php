<?php
require('koneksi.php');

// Memeriksa apakah ID transaksi ada dalam parameter GET dan data form ada dalam POST
if (isset($_GET['idTransaction']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $idTransaction = $_GET['idTransaction'];
    $nameTransaction = $_POST['nameTransaction'];
    $telpTransaction = $_POST['telpTransaction'];
    $mailTransaction = $_POST['mailTransaction'];

    // Query untuk memperbarui data transaksi
    $query = "UPDATE transactions SET 
              nameTransaction = ?, 
              telpTransaction = ?, 
              mailTransaction = ? 
              WHERE idTransaction = ?";

    // Mempersiapkan statement untuk mencegah SQL injection
    if ($stmt = $koneksi->prepare($query)) {
        $stmt->bind_param("sssi", $nameTransaction, $telpTransaction, $mailTransaction, $idTransaction);
        if ($stmt->execute()) {
            // Mengarahkan kembali ke halaman tiket_saya.php setelah pembaruan
            header("Location: tiket_saya.php");
            exit();
        } else {
            echo "Gagal memperbarui data transaksi: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        echo "Gagal mempersiapkan statement: " . htmlspecialchars($koneksi->error);
    }
}

// Mengambil data transaksi yang ada untuk ditampilkan di form
$idTransaction = $_GET['idTransaction'];
$query = "SELECT * FROM transactions WHERE idTransaction = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $idTransaction);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <section class="max-w-4xl mx-auto p-6 bg-white rounded shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-4">Update Form</h1>
        <form action="update_tiket.php?idTransaction=<?= htmlspecialchars($idTransaction) ?>" method="post" class="space-y-4">
            <div class="form-group">
                <label for="nameTransaction" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap:</label>
                <input type="text" name="nameTransaction" value="<?= htmlspecialchars($transaction['nameTransaction']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="form-group">
                <label for="telpTransaction" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon:</label>
                <input type="text" name="telpTransaction" value="<?= htmlspecialchars($transaction['telpTransaction']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="form-group">
                <label for="mailTransaction" class="block text-gray-700 text-sm font-bold mb-2">Alamat Email:</label>
                <input type="email" name="mailTransaction" value="<?= htmlspecialchars($transaction['mailTransaction']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex justify-between">
                <button type="button" onclick="window.location.href='index.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kembali ke Beranda</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Tiket</button>
            </div>
        </form>
    </section>
</body>
</html>