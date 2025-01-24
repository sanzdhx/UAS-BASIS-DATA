<?php
include('koneksi.php');

if (isset($_GET['id_obat'])) {
    $id_obat = $_GET['id_obat'];

    $query = "SELECT * FROM obat WHERE id_obat = '$id_obat'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
}
?>
