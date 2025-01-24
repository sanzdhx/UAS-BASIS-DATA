<?php
// koneksi.php sudah include sebelumnya
include 'koneksi.php';

session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    echo "<div style='text-align:right;'><a href='login.php'>Login</a></div>";
}

// Query untuk mengambil data pegawai
$query_pegawai = "SELECT id_pegawai, username, password, level FROM pegawai";
$result_pegawai = $conn->query($query_pegawai);

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id_pegawai = $_GET['hapus'];

    // Query untuk menghapus data pegawai
    $query_hapus = "DELETE FROM pegawai WHERE id_pegawai = '$id_pegawai'";
    if ($conn->query($query_hapus) === TRUE) {
        echo "<script>alert('Data pegawai berhasil dihapus'); window.location='akun.php';</script>";
    } else {
        echo "Error: " . $query_hapus . "<br>" . $conn->error;
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

    <title>Apotek Kumarizz - Tabel Pegawai</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexfix.php">
                <div class="sidebar-brand-icon ">
                    <img src="img/pngegg.png" width="70" height="70">
                </div>
                <div class="sidebar-brand-text mx-3">Kumarizz</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="indexfix.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="obat.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Obat</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="penjualan.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Penjualan</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pembelian.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pembelian</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="supplier.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Supplier</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="akun.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Akun</span>
                </a>
            </li>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12">
                            <div class="card shadow h-100" style="margin-top: 20px; max-height: 500px;">
                                <div class=" card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Akun</h6>
                                    <div class="header-buttons d-flex justify-content-end">
                                        <a href="tambah_akun.php" class="btn btn-primary btn-sm ml-2">Tambah Akun</a>
                                        <a href="update_akun.php" class="btn btn-primary btn-sm ml-2">Update Akun</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID Pegawai</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                    <th>Level</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result_pegawai->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $row['id_pegawai']; ?></td>
                                                        <td><?php echo $row['username']; ?></td>
                                                        <td><?php echo $row['password']; ?></td>
                                                        <td><?php echo $row['level']; ?></td>
                                                        <td>
                                                            <!-- Tombol Hapus -->
                                                            <a href="?hapus=<?php echo $row['id_pegawai']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                                                Hapus
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Kumarizz 2024</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>