<?php
// search.php
require('koneksi.php');
session_start();

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);

    // Query untuk mencari keyword di kolom yang relevan
    $query = "SELECT * FROM concert 
              WHERE nameConcert LIKE '%$search%' 
              OR locProvConcert LIKE '%$search%' 
              OR dateConcert LIKE '%$search%' 
              OR guestConcert LIKE '%$search%' 
              OR descConcert LIKE '%$search%' 
              OR locationConcert LIKE '%$search%'";

    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika ditemukan hasil, arahkan ke halaman hasil pencarian
        $row = mysqli_fetch_assoc($result);
        // Misalnya, arahkan ke halaman detail konser
        $concertId = $row['idConcert'];
        header("Location: concert_detail.php?id=$concertId");
        exit();
    } else {
        // Jika tidak ada hasil, arahkan ke halaman tidak ditemukan
        header("Location: 404.php");
        exit();
    }
} else {
    // Jika tidak ada pencarian, arahkan kembali ke halaman utama
    header("Location: index.php");
    exit();
}