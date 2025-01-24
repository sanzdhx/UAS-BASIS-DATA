<?php
// Koneksi ke database
include('koneksi.php');

// Ambil data obat untuk dropdown
$query_obat = "SELECT id_obat, nama_obat FROM obat ORDER BY nama_obat ASC";
$result_obat = $conn->query($query_obat);

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_obat = $_POST['id_obat'];
    $nama_obat = $_POST['nama_obat'];
    $jenis_obat = $_POST['jenis_obat'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];

    // Query untuk mengupdate data obat
    $query_update = "UPDATE obat
                     SET nama_obat = '$nama_obat', jenis_obat = '$jenis_obat', harga = '$harga', 
                         kategori = '$kategori', tanggal_kadaluarsa = '$tanggal_kadaluarsa'
                     WHERE id_obat = '$id_obat'";

    if ($conn->query($query_update) === TRUE) {
        header("Location: obat.php");
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

    <title>Update Obat</title>

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

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow" style="margin-top: 20px; max-height: 500px;">
                                <div class=" card-header">
                                    <h5 class="m-0 font-weight-bold text-primary">Update Obat</h5>
                                </div>
                                <div class="card-body" style="padding: 30px;">
                                    <form method="POST" action="" class="form-horizontal">
                                        <div class="row mb-3">
                                            <label for="id_obat" class="col-sm-2 col-form-label">Pilih Obat</label>
                                            <div class="col-sm-4">
                                                <select class="form-select custom-select" id="id_obat" name="id_obat" required onchange="fetchObatData(this.value)">
                                                    <option value="" disabled selected>Pilih Nama Obat</option>
                                                    <?php while ($row = $result_obat->fetch_assoc()) : ?>
                                                        <option value="<?= $row['id_obat'] ?>"><?= $row['nama_obat'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="nama_obat" class="col-sm-2 col-form-label">Nama Obat</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
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
                                        </div>
                                        <div class="row mb-3">
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
                                        <button type="submit" class="btn btn-primary float-right">Update Obat</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        function fetchObatData(id) {
            if (id) {
                fetch(`get_obat.php?id_obat=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.error) {
                            document.getElementById('nama_obat').value = data.nama_obat || '';
                            document.getElementById('jenis_obat').value = data.jenis_obat || '';
                            document.getElementById('harga').value = data.harga || '';
                            document.getElementById('kategori').value = data.kategori || '';
                            document.getElementById('tanggal_kadaluarsa').value = data.tanggal_kadaluarsa || '';
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            } else {
                document.getElementById('nama_obat').value = '';
                document.getElementById('jenis_obat').value = '';
                document.getElementById('harga').value = '';
                document.getElementById('kategori').value = '';
                document.getElementById('tanggal_kadaluarsa').value = '';
            }
        }
    </script>
</body>

</html>