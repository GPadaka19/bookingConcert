<?php
// concert_detail.php
require('koneksi.php');

if (isset($_GET['id'])) {
    $idConcert = intval($_GET['id']);

    $query = "SELECT * FROM concert WHERE idConcert = $idConcert";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $concert = mysqli_fetch_assoc($result);
        // Tentukan ke mana harus dialihkan berdasarkan idConcert
        $detailConcert = '';
        if ($idConcert == 1) {
            $detailConcert = 's07.php';
        } elseif ($idConcert == 2) {
            $detailConcert = 'guyonwaton.php';
        } elseif ($idConcert == 3) {
            $detailConcert = 'tulus.php';
        } else {
            // Jika idConcert tidak cocok dengan yang diharapkan, tangani secara sesuai
            echo "Konser tidak ditemukan.";
            exit();
        }
        // Redirect ke halaman detail konser yang sesuai
        header("Location: $detailConcert");
        exit();
    } else {
        echo "Konser tidak ditemukan.";
    }
} else {
    echo "ID konser tidak diberikan.";
}
?>
