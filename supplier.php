    <?php
    // Koneksi ke database
    include 'koneksi.php';



    // Ambil data supplier untuk ditampilkan di tabel
    $query_supplier = "SELECT id_supplier, nama_supplier, alamat, telepon, email FROM supplier";
    $result_supplier = $conn->query($query_supplier);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Daftar Supplier</title>
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
                        <img src = "img/pngegg.png" width="70" height="70">
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
                            <div class="col-12">
                                <div class="card shadow h-100" style="margin-top: 20px; max-height: 500px;">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 font-weight-bold text-primary">Daftar Supplier</h6>
                                        <div class="header-buttons">
                                            <a href="tambah_supplier.php" class="btn btn-primary btn-sm">Tambah Supplier</a>
                                            <a href="update_supplier.php" class="btn btn-warning btn-sm">Update Supplier</a>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding: 10px;">
                                        <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID Supplier</th>
                                                        <th>Nama Supplier</th>
                                                        <th>Alamat</th>
                                                        <th>Telepon</th>
                                                        <th>Email</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = $result_supplier->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?php echo $row['id_supplier']; ?></td>
                                                            <td><?php echo $row['nama_supplier']; ?></td>
                                                            <td><?php echo $row['alamat']; ?></td>
                                                            <td><?php echo $row['telepon']; ?></td>
                                                            <td><?php echo $row['email']; ?></td>
                                                            <td><a href="hapus_supplier.php?id=<?php echo $row['id_supplier']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?');">Hapus</a></td>
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

                <!-- Footer -->
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
