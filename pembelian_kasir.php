<?php
// Koneksi ke database
include 'koneksi.php';



// Ambil data pembelian dengan JOIN antara pembelian, supplier, dan obat
$query_pembelian = "
    SELECT pb.id_pembelian, s.nama_supplier, o.nama_obat, pb.tanggal, pb.jumlah, pb.harga_satuan, pb.sub_total
    FROM pembelian pb
    JOIN supplier s ON pb.id_supplier = s.id_supplier
    JOIN obat o ON pb.id_obat = o.id_obat
";
$result_pembelian = $conn->query($query_pembelian);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Pembelian</title>
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexkasir.php">
                <div class="sidebar-brand-icon ">
                    <img src = "img/pngegg.png" width="70" height="70">
                </div>
                <div class="sidebar-brand-text mx-3">Kumarizz</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="indexkasir.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            

           

            <!-- Nav Item - Pages Collapse Menu -->
            
            <!-- Nav Item - Utilities Collapse Menu -->
            
            <li class="nav-item active">
                <a class="nav-link" href="penjualan_kasir.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Penjualan</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pembelian_kasir.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pembelian</span></a>
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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Pembelian</h6>
                        <div class="header-buttons d-flex justify-content-end">
                            <a href="cetak_pembelian.php" class="btn btn-primary btn-sm ml-2">Cetak Pembelian</a>
                            <a href="tambah_pembelian.php" class="btn btn-primary btn-sm ml-2">Tambah Pembelian</a>
                        </div>
                    </div>

                                <div class="card-body" style="padding: 10px;">
                                    <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID Pembelian</th>
                                                    <th>Nama Supplier</th>
                                                    <th>Nama Obat</th>
                                                    <th>Tanggal</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result_pembelian->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $row['id_pembelian']; ?></td>
                                                        <td><?php echo $row['nama_supplier']; ?></td>
                                                        <td><?php echo $row['nama_obat']; ?></td>
                                                        <td><?php echo $row['tanggal']; ?></td>
                                                        <td><?php echo $row['jumlah']; ?></td>
                                                        <td><?php echo $row['harga_satuan']; ?></td>
                                                        <td><?php echo $row['sub_total']; ?></td>
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

            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <script src="js/sb-admin-2.min.js"></script>
        </body>
    </html>
