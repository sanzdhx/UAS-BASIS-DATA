<?php
// Koneksi ke database
include 'koneksi.php';

// Pastikan ID obat dikirim melalui URL dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_obat = $_GET['id'];

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Hapus data terkait di tabel stok_log
        $query_hapus_stok_log = "DELETE FROM stok_log WHERE id_obat = ?";
        if ($stmt = $conn->prepare($query_hapus_stok_log)) {
            $stmt->bind_param("i", $id_obat);
            $stmt->execute();
            $stmt->close();
        }

        // Hapus data terkait di tabel penjualan
        $query_hapus_penjualan = "DELETE FROM penjualan WHERE id_obat = ?";
        if ($stmt = $conn->prepare($query_hapus_penjualan)) {
            $stmt->bind_param("i", $id_obat);
            $stmt->execute();
            $stmt->close();
        }

        // Hapus data terkait di tabel pembelian
        $query_hapus_pembelian = "DELETE FROM pembelian WHERE id_obat = ?";
        if ($stmt = $conn->prepare($query_hapus_pembelian)) {
            $stmt->bind_param("i", $id_obat);
            $stmt->execute();
            $stmt->close();
        }

        // Hapus data dari tabel obat
        $query_hapus_obat = "DELETE FROM obat WHERE id_obat = ?";
        if ($stmt = $conn->prepare($query_hapus_obat)) {
            $stmt->bind_param("i", $id_obat);
            $stmt->execute();
            $stmt->close();
        }

        // Commit transaksi jika semua query berhasil
        $conn->commit();

        // Redirect setelah penghapusan berhasil
        header("Location: obat.php?status=success");
        exit;

    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $conn->rollback();
        echo "Gagal menghapus obat dan data terkait. Error: " . $e->getMessage();
    }
} else {
    echo "ID obat tidak valid.";
}

// Menutup koneksi
$conn->close();
?>
