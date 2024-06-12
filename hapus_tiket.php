    <?php 
include("koneksi.php");

if (isset($_GET['id'])) {
    $idTransaction = $_GET['id'];

    // Ambil idTicket dan qtyTransaction sebelum menghapus
    $queryGetDetails = "SELECT idTicket, qtyTransaction FROM transactions WHERE idTransaction = '$idTransaction'";
    $detailsResult = mysqli_query($koneksi, $queryGetDetails);
    $details = mysqli_fetch_assoc($detailsResult);

    if ($details) {
        // Query untuk menghapus transaksi berdasarkan idTransaction
        $queryDelete = "DELETE FROM transactions WHERE idTransaction = '$idTransaction'";
        $resultDelete = mysqli_query($koneksi, $queryDelete);

        if ($resultDelete) {
            // Update stok tiket dan jumlah tiket terjual
            $idTicket = $details['idTicket'];
            $qtyTransaction = $details['qtyTransaction'];
            $queryUpdateTicket = "UPDATE ticket SET stockTicket = stockTicket + $qtyTransaction, soldTicket = soldTicket - $qtyTransaction WHERE idTicket = '$idTicket'";
            $resultUpdateTicket = mysqli_query($koneksi, $queryUpdateTicket);

            if ($resultUpdateTicket) {
                // Redirect ke halaman tiket_saya.php setelah berhasil menghapus dan mengupdate
                header("Location: tiket_saya.php");
                exit();
            } else {
                echo "Gagal mengupdate stok tiket.";
            }
        } else {
            echo "Gagal menghapus transaksi.";
        }
    } else {
        echo "Detail transaksi tidak ditemukan.";
    }
} else {
    echo "ID transaksi tidak ditemukan.";
}
