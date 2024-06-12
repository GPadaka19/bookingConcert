<?php
include("koneksi.php");
session_start();

$nameTransaction = $_POST['nameTransaction'];
$telpTransaction = $_POST['telpTransaction'];
$mailTransaction = $_POST['mailTransaction'];
$idConcert = $_POST['idConcert'];
$idAccount = $_SESSION['idAccount']; // Mengambil idAccount dari session
$idTicket = $_POST['idTicket'];
$qtyTransaction = $_POST['qtyTransaction'];

// Cek stok tiket sebelum memproses transaksi
$queryCheckStock = "SELECT stockTicket, soldTicket FROM ticket WHERE idTicket = '$idTicket'";
$resultCheckStock = mysqli_query($koneksi, $queryCheckStock);
$row = mysqli_fetch_assoc($resultCheckStock);

if ($row['stockTicket'] >= $qtyTransaction) {
    // Proses transaksi jika stok mencukupi
    $query = "INSERT INTO transactions (nameTransaction, telpTransaction, mailTransaction, idConcert, idAccount, idTicket, qtyTransaction) VALUES ('$nameTransaction', '$telpTransaction', '$mailTransaction', '$idConcert', '$idAccount', '$idTicket', '$qtyTransaction')";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    // Update stok tiket dan jumlah tiket terjual
    $newStock = $row['stockTicket'] - $qtyTransaction;
    $newSold = $row['soldTicket'] + $qtyTransaction;
    $queryUpdateStock = "UPDATE ticket SET stockTicket = '$newStock', soldTicket = '$newSold' WHERE idTicket = '$idTicket'";
    mysqli_query($koneksi, $queryUpdateStock) or die(mysqli_error($koneksi));

    header("Location:tiket_saya.php");
} else {
    // Jika stok tidak mencukupi, kirim pesan error
    $_SESSION['error_msg'] = 'Maaf, stok tiket tidak mencukupi. Tersedia hanya ' . $row['stockTicket'] . ' tiket.';
    header("Location:pesan_tiket.php");
}

