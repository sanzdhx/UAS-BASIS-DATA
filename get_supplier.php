<?php
// Include database connection
include('koneksi.php');

// Check if the supplier ID is set
if (isset($_POST['id_supplier'])) {
    $id_supplier = $_POST['id_supplier'];

    // Query to get the supplier data
    $query = "SELECT * FROM supplier WHERE id_supplier = '$id_supplier'";
    $result = $conn->query($query);

    // Check if a supplier was found
    if ($result->num_rows > 0) {
        $supplier = $result->fetch_assoc();
        // Return the supplier data as a JSON response
        echo json_encode($supplier);
    } else {
        echo json_encode([]);  // Return an empty array if no supplier found
    }
}
?>
