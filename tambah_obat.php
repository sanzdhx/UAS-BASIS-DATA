<?php
// Koneksi ke database
include 'koneksi.php';

// Proses tambah obat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_tambah_obat'])) {
    // Cek apakah semua form terisi
    if (!empty($_POST['nama_obat']) && !empty($_POST['jenis_obat']) && !empty($_POST['harga']) && !empty($_POST['kategori']) && !empty($_POST['tanggal_kadaluarsa'])) {
        // Ambil data dari form
        $nama_obat = $_POST['nama_obat'];
        $jenis_obat = $_POST['jenis_obat'];
        $harga = $_POST['harga'];
        $kategori = $_POST['kategori'];
        $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];
        $stok = 0;  // Set stok otomatis menjadi 0

        // Query untuk menyimpan data obat
        $query_insert = "INSERT INTO obat (nama_obat, jenis_obat, harga, stok, kategori, tanggal_kadaluarsa)
                         VALUES ('$nama_obat', '$jenis_obat', '$harga', '$stok', '$kategori', '$tanggal_kadaluarsa')";

        if ($conn->query($query_insert) === TRUE) {
            header("Location: obat.php");
        } else {
            echo "Error: " . $query_insert . "<br>" . $conn->error;
        }
    } else {
        echo "Semua form harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Obat</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
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
        <!-- end sidebar-->

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid">
                    <h1 class="h3 mb-0 text-gray-800"> </h1>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow" style="margin-top: 20px; max-height: 500px;">
                                <div class="card-header">
                                    <h5 class="m-0 font-weight-bold text-primary">Tambah Obat</h5>
                                </div>
                                <div class="card-body" style="padding: 20px;">
                                    <form method="POST" action="" class="form-horizontal">
                                        <div class="row mb-3">
                                            <label for="nama_obat" class="col-sm-2 col-form-label">Nama Obat</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                                            </div>
                                            <label for="jenis_obat" class="col-sm-2 col-form-label">Jenis Obat</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="jenis_obat" name="jenis_obat" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" id="harga" name="harga" required>
                                            </div>
                                            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="kategori" name="kategori" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tanggal_kadaluarsa" class="col-sm-2 col-form-label">Tanggal Kadaluarsa</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" required>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit_tambah_obat" class="btn btn-primary float-right">Tambah Obat</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>