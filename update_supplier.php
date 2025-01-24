<?php
// Koneksi ke database
include('koneksi.php');

// Ambil data obat untuk dropdown
$query_supplier = "SELECT id_supplier, nama_supplier FROM supplier ORDER BY nama_supplier ASC";
$result_supplier = $conn->query($query_supplier);

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_supplier = $_POST['id_supplier'];
    $nama_supplier = $_POST['nama_supplier'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];

    // Query untuk mengupdate data obat
    $query_update = "UPDATE supplier
                     SET nama_supplier = '$nama_supplier', alamat = '$alamat', telepon = '$telepon', 
                         email = '$email'
                     WHERE id_supplier = '$id_supplier'";

    if ($conn->query($query_update) === TRUE) {
        header("Location: supplier.php");
    } else {
        echo "Error: " . $query_update . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Apotek Kumarizz</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexfix.php">
                <div class="sidebar-brand-icon ">
                    <img src="img/pngegg.png" width="70" height="70">
                </div>
                <div class="sidebar-brand-text mx-3">Kumarizz</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="indexfix.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>





            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="obat.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Obat</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="penjualan.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Penjualan</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pembelian.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pembelian</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="supplier.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Supplier</span></a>
            </li>

            </li>
            <li class="nav-item active">
                <a class="nav-link" href="akun.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Akun</span></a>
            </li>

            <!-- Divider -->


            <!-- Heading -->


            <!-- Nav Item - Pages Collapse Menu -->


            <!-- Nav Item - Charts -->



        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow h-100" style="margin-top: 20px; max-height: 500px;">
                                <div class="card-header">
                                    <h5 class="m-0 font-weight-bold text-primary">Update Supplier</h5>
                                </div>
                                <div class="card-body" style="padding: 10px;">
                                    <form method="POST" action="" class="form-horizontal">
                                        <div class="row mb-3">
                                            <label for="id_supplier" class="col-sm-2 col-form-label">Pilih Supplier</label>
                                            <div class="col-sm-4">
                                                <select class="form-select custom-select" id="id_supplier" name="id_supplier" required>
                                                    <option value="" disabled selected>Pilih Nama Supplier</option>
                                                    <?php while ($row = $result_supplier->fetch_assoc()) : ?>
                                                        <option value="<?= $row['id_supplier'] ?>" <?= isset($id_supplier) && $id_supplier == $row['id_supplier'] ? 'selected' : '' ?>>
                                                            <?= $row['nama_supplier'] ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="nama_supplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" id="telepon" name="telepon" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>



                                        <button type="submit" class="btn btn-primary float-right">Update Supplier</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <script>
                $(document).ready(function() {
                    // When a supplier is selected from the dropdown
                    $('#id_supplier').change(function() {
                        var supplierId = $(this).val(); // Get the selected supplier ID

                        // If a valid supplier is selected
                        if (supplierId) {
                            $.ajax({
                                type: 'POST',
                                url: 'get_supplier.php', // This is the PHP script to fetch the supplier data
                                data: {
                                    id_supplier: supplierId
                                },
                                success: function(response) {
                                    var supplier = JSON.parse(response); // Parse the JSON response
                                    if (supplier) {
                                        // Populate the form fields with the supplier's data
                                        $('#nama_supplier').val(supplier.nama_supplier);
                                        $('#alamat').val(supplier.alamat);
                                        $('#telepon').val(supplier.telepon);
                                        $('#email').val(supplier.email);
                                    }
                                }
                            });
                        }
                    });

                    // Trigger change event on page load to fill in data if editing
                    if ($('#id_supplier').val()) {
                        $('#id_supplier').change();
                    }
                });
            </script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>