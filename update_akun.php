<?php
// Koneksi ke database
include('koneksi.php');

// Ambil data pegawai untuk dropdown
$query_pegawai = "SELECT id_pegawai, username FROM pegawai";
$result_pegawai = $conn->query($query_pegawai);

// Ambil data akun berdasarkan id_pegawai yang dipilih
if (isset($_GET['id_pegawai'])) {
    $id_pegawai = $_GET['id_pegawai'];

    // Query untuk mengambil data pegawai
    $query = "SELECT * FROM pegawai WHERE id_pegawai = '$id_pegawai'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $pegawai = $result->fetch_assoc();
    } else {
        echo "Data pegawai tidak ditemukan!";
        exit;
    }
}

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Memastikan data yang diperlukan ada dalam $_POST
    if (isset($_POST['username'], $_POST['password'], $_POST['level'], $_POST['id_pegawai'])) {
        // Ambil data dari form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = $_POST['level'];
        $id_pegawai = $_POST['id_pegawai'];

        // Query untuk update data pegawai
        $query_update = "UPDATE pegawai SET username='$username', password='$password', level='$level' 
                         WHERE id_pegawai='$id_pegawai'";

        if ($conn->query($query_update) === TRUE) {
            echo "Akun berhasil diperbarui!";
        } else {
            echo "Error: " . $query_update . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Data yang dibutuhkan tidak lengkap!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Akun</title>
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
        <!-- End of Sidebar -->
        <!-- Main Content -->
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800"></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow" style=" max-height: 500px;">
                                <div class="card-header">
                                    <h5 class="m-0 font-weight-bold text-primary">Update Akun</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <!-- Dropdown untuk memilih id_pegawai -->
                                        <div class="form-row mb-3">
                                            <label for="id_pegawai" class="col-sm-2 col-form-label">Pilih Pegawai</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="id_pegawai" name="id_pegawai" required onchange="window.location.href='update_akun.php?id_pegawai=' + this.value">
                                                    <option value="">-- Pilih Pegawai --</option>
                                                    <?php while ($row = $result_pegawai->fetch_assoc()) { ?>
                                                        <option value="<?php echo $row['id_pegawai']; ?>" <?php echo isset($pegawai) && $pegawai['id_pegawai'] == $row['id_pegawai'] ? 'selected' : ''; ?>>
                                                            <?php echo $row['username']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <?php if (isset($pegawai)) { ?>
                                            <div class="form-row mb-3">
                                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $pegawai['username']; ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-row mb-3">
                                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $pegawai['password']; ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-row mb-3">
                                                <label for="level" class="col-sm-2 col-form-label">Level</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="level" name="level" required>
                                                        <option value="admin" <?php echo $pegawai['level'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                        <option value="kasir" <?php echo $pegawai['level'] == 'kasir' ? 'selected' : ''; ?>>Kasir</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="submit" class="btn btn-primary">Update Akun</button>
                                                </div>
                                            </div>
                                        <?php } ?>
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