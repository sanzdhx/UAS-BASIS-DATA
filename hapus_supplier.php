<?php
// Koneksi ke database
include 'koneksi.php';

// Pastikan ID supplier dikirim melalui URL dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_supplier = $_GET['id'];

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Hapus data terkait di tabel pembelian
        $query_hapus_pembelian = "DELETE FROM pembelian WHERE id_supplier = ?";
        if ($stmt = $conn->prepare($query_hapus_pembelian)) {
            $stmt->bind_param("i", $id_supplier);
            $stmt->execute();
            $stmt->close();
        }

        // Hapus data dari tabel supplier
        $query_hapus_supplier = "DELETE FROM supplier WHERE id_supplier = ?";
        if ($stmt = $conn->prepare($query_hapus_supplier)) {
            $stmt->bind_param("i", $id_supplier);
            $stmt->execute();
            $stmt->close();
        }

        // Commit transaksi jika semua query berhasil
        $conn->commit();

        // Redirect setelah penghapusan berhasil
        header("Location: supplier.php?status=success");
        exit;

    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $conn->rollback();
        echo "Gagal menghapus supplier dan data terkait. Error: " . $e->getMessage();
    }
} else {
    echo "ID supplier tidak valid.";
}

// Menutup koneksi
$conn->close();
?>
