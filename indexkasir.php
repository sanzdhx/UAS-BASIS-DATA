<?php
// koneksi.php sudah include sebelumnya
include 'koneksi.php';


session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id_pegawai'])) {
    header("Location: login.php");  // Jika belum login, arahkan ke halaman login
    exit();
}

// Ambil data pengguna dari session
$user_name = $_SESSION['username'];
$user_level = $_SESSION['level'];  // Misalnya, 'kasir'

// Lanjutkan dengan operasi lainnya (query dan tampilan data seperti di kode Anda sebelumnya)


// Ambil data pengguna dari session (misalnya, nama dan level)
$user_name = $_SESSION['username']; // Nama pengguna
$user_level = $_SESSION['level']; // Misalnya, 'kasir'

// Query untuk mengambil data obat
$query_obat = "SELECT id_obat, nama_obat, jenis_obat, kategori, stok, harga, tanggal_kadaluarsa FROM obat";
$result_obat = $conn->query($query_obat);

// Ambil total penjualan untuk bulan Desember
$bulan = date('m'); // Bulan Desember
$tahun = date('Y'); // Tahun saat ini
$query = "
    SELECT SUM(sub_total) AS total_penjualan 
    FROM penjualan 
    WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $bulan, $tahun);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Jika data ada, ambil nilai totalnya, jika tidak, set ke 0
$total_penjualan = $row['total_penjualan'] ?? 0;


// Ambil total pembelian untuk bulan ini
$bulan_ini = date('m'); // Bulan ini
$tahun_ini = date('Y'); // Tahun ini
$query_pembelian = "
    SELECT SUM(sub_total) AS total_pembelian 
    FROM pembelian 
    WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
";

$stmt_pembelian = $conn->prepare($query_pembelian);
$stmt_pembelian->bind_param("ii", $bulan_ini, $tahun_ini);
$stmt_pembelian->execute();
$result_pembelian = $stmt_pembelian->get_result();
$row_pembelian = $result_pembelian->fetch_assoc();

// Jika data ada, ambil nilai totalnya, jika tidak, set ke 0
$total_pembelian = $row_pembelian['total_pembelian'] ?? 0;

$pendapatan_bulan_ini = $total_penjualan - $total_pembelian;

$data_penjualan = [];
$grafik_penjualan = "SELECT tanggal, SUM(jumlah) AS total_penjualan FROM penjualan GROUP BY tanggal";
$result_grafik_penjualan = $conn->query($grafik_penjualan);
while ($row = $result_grafik_penjualan->fetch_assoc()) {
    $data_penjualan[] = [
        'tanggal' => $row['tanggal'],
        'total_penjualan' => $row['total_penjualan']
    ];
}

// Query total jumlah pembelian per bulan
$query_pembelian_bulanan = "
    SELECT 
        DATE_FORMAT(tanggal, '%Y-%m') AS bulan,
        SUM(jumlah) AS total_pembelian
    FROM pembelian
    GROUP BY bulan
    ORDER BY bulan ASC";
$result_pembelian_bulanan = $conn->query($query_pembelian_bulanan);

// Simpan data dalam array untuk JavaScript
$data_pembelian_bulanan = [];
while ($row = $result_pembelian_bulanan->fetch_assoc()) {
    $data_pembelian_bulanan[] = [
        'bulan' => $row['bulan'],
        'total_pembelian' => $row['total_pembelian']
    ];
}
//Ambil Stok Log
$querystoklog = "
    SELECT 
        stok_log.id_stok_log, 
        obat.nama_obat, 
        stok_log.tanggal, 
        stok_log.perubahan_stok, 
        stok_log.keterangan
    FROM 
        stok_log
    INNER JOIN 
        obat 
    ON 
        stok_log.id_obat = obat.id_obat
    ORDER BY 
        stok_log.tanggal DESC";
$result = $conn->query($querystoklog);
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexkasir.php">
                <div class="sidebar-brand-icon ">
                    <img src="img/pngegg.png" width="70" height="70">
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

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

                        <nav class="navbar ">

                            <div class="container-fluid">
                                <!-- Username di pojok kanan atas -->
                                <span>Welcome, <?php echo htmlspecialchars($user_name); ?> <a class="btn btn-danger" href="logout.php">Logout</a>
                                </span>
                            </div>
                        </nav>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Penjualan (Bulanan)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Rp.<?php echo number_format($total_penjualan, 2); ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Annual) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pembelian (Bulanan)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Rp. <?php echo number_format($total_pembelian, 2); ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example for Net Earnings -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pendapatan (Bulanan)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Rp. <?php echo number_format($pendapatan_bulan_ini, 2); ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Content Row -->

                        <div class="col-6">
                            <div class="card shadow h-100">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan Bulanan</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area" style="height: 335px;">
                                        <canvas id="chartpenjualan"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card shadow h-100">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pembelian Bulanan</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area" style="height: 200px;">
                                        <canvas id="grafikPembelianBulanan"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stok Log -->
                        <div class="col-12">
                            <div class="card shadow h-100" style="height: 300px; margin-top: 20px; overflow-y: auto;">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Log Stok</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body" style="height: 240px; overflow-y: auto;">
                                    <div class="table-responsive" style="height: 240px; overflow-y: auto;">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID Stok Log</th>
                                                    <th>Nama Obat</th>
                                                    <th>Tanggal</th>
                                                    <th>Perubahan Stok</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $row['id_stok_log']; ?></td>
                                                        <td><?php echo $row['nama_obat']; ?></td>
                                                        <td><?php echo $row['tanggal']; ?></td>
                                                        <td><?php echo $row['perubahan_stok']; ?></td>
                                                        <td><?php echo $row['keterangan']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Obat -->
                        <div class="col-12">
                            <div class="card shadow h-100" style="height: 300px; margin-top: 40px; overflow-y: auto;">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Obat</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body" style="height: 240px; overflow-y: auto;">
                                    <div class="table-responsive" style="height: 240px; overflow-y: auto;">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID Obat</th>
                                                    <th>Nama Obat</th>
                                                    <th>Jenis Obat</th>
                                                    <th>Kategori</th>
                                                    <th>Stok</th>
                                                    <th>Harga</th>
                                                    <th>Tanggal Kadaluarsa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result_obat->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $row['id_obat']; ?></td>
                                                        <td><?php echo $row['nama_obat']; ?></td>
                                                        <td><?php echo $row['jenis_obat']; ?></td>
                                                        <td><?php echo $row['kategori']; ?></td>
                                                        <td><?php echo $row['stok']; ?></td>
                                                        <td>Rp. <?php echo number_format($row['harga'], 2); ?></td>
                                                        <td><?php echo $row['tanggal_kadaluarsa']; ?></td>
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
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
        const dataPenjualan = <?php echo json_encode($data_penjualan); ?>;
        const labelsPenjualan = dataPenjualan.map(item => item.tanggal);
        const totalPenjualan = dataPenjualan.map(item => item.total_penjualan);

        // Grafik Penjualan (Area Chart)
        new Chart(document.getElementById('chartpenjualan').getContext('2d'), {
            type: 'line', // Grafik area chart
            data: {
                labels: labelsPenjualan,
                datasets: [{
                    label: 'Total Penjualan',
                    data: totalPenjualan,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true, // Untuk membuat area chart
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 6,
                        }
                    }
                }
            }
        });
    </script>

    <script>
        // Ambil data pembelian bulanan dari PHP
        const dataPembelianBulanan = <?php echo json_encode($data_pembelian_bulanan); ?>;

        // Ekstrak label (bulan) dan data (total pembelian)
        const labelsPembelian = dataPembelianBulanan.map(item => item.bulan);
        const dataPembelian = dataPembelianBulanan.map(item => item.total_pembelian);

        // Buat grafik menggunakan Chart.js
        new Chart(document.getElementById('grafikPembelianBulanan').getContext('2d'), {
            type: 'line',
            data: {
                labels: labelsPembelian,
                datasets: [{
                    label: 'Pembelian Bulanan',
                    data: dataPembelian,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true, // Mengisi area di bawah garis
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Pembelian',
                        },
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>




</body>

</html>