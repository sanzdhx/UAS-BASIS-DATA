<?php
// Koneksi ke database
include('koneksi.php');

// Query Data Penjualan
$query_penjualan = "SELECT tanggal, jumlah, harga_satuan, sub_total FROM penjualan";
$result_penjualan = $conn->query($query_penjualan);

// Query Data Pembelian
$query_pembelian = "SELECT tanggal, jumlah, harga_satuan, sub_total FROM pembelian";
$result_pembelian = $conn->query($query_pembelian);

// Query Data Stok Obat
$query_stok = "SELECT nama_obat, jenis_obat, stok, harga FROM obat";
$result_stok = $conn->query($query_stok);

// Untuk Grafik Penjualan
$data_penjualan = [];
$grafik_penjualan = "SELECT tanggal, SUM(jumlah) AS total_penjualan FROM penjualan GROUP BY tanggal";
$result_grafik_penjualan = $conn->query($grafik_penjualan);
while ($row = $result_grafik_penjualan->fetch_assoc()) {
    $data_penjualan[] = [
        'tanggal' => $row['tanggal'],
        'total_penjualan' => $row['total_penjualan']
    ];
}

// Untuk Grafik Pembelian
$data_pembelian = [];
$grafik_pembelian = "SELECT tanggal, SUM(jumlah) AS total_pembelian FROM pembelian GROUP BY tanggal";
$result_grafik_pembelian = $conn->query($grafik_pembelian);
while ($row = $result_grafik_pembelian->fetch_assoc()) {
    $data_pembelian[] = [
        'tanggal' => $row['tanggal'],
        'total_pembelian' => $row['total_pembelian']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Apotek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Dashboard Apotek</h1>

        <!-- Tabel dan Grafik dalam Row -->
        <div class="row">
            <!-- Tabel Penjualan -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Tabel Penjualan</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_penjualan->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td><?= $row['jumlah'] ?></td>
                                        <td><?= $row['harga_satuan'] ?></td>
                                        <td><?= $row['sub_total'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Grafik Penjualan -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Grafik Penjualan</div>
                    <div class="card-body">
                        <canvas id="chartPenjualan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Tabel Pembelian -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">Tabel Pembelian</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_pembelian->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td><?= $row['jumlah'] ?></td>
                                        <td><?= $row['harga_satuan'] ?></td>
                                        <td><?= $row['sub_total'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Grafik Pembelian -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">Grafik Pembelian</div>
                    <div class="card-body">
                        <canvas id="chartPembelian"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Tabel Stok Obat -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">Tabel Stok Obat</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Jenis Obat</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_stok->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $row['nama_obat'] ?></td>
                                        <td><?= $row['jenis_obat'] ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td><?= $row['harga'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Grafik -->
    <script>
        const dataPenjualan = <?php echo json_encode($data_penjualan); ?>;
        const labelsPenjualan = dataPenjualan.map(item => item.tanggal);
        const totalPenjualan = dataPenjualan.map(item => item.total_penjualan);

        const dataPembelian = <?php echo json_encode($data_pembelian); ?>;
        const labelsPembelian = dataPembelian.map(item => item.tanggal);
        const totalPembelian = dataPembelian.map(item => item.total_pembelian);

        // Grafik Penjualan
        new Chart(document.getElementById('chartPenjualan').getContext('2d'), {
            type: 'line',
            data: {
                labels: labelsPenjualan,
                datasets: [{
                    label: 'Total Penjualan',
                    data: totalPenjualan,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }]
            }
        });

        // Grafik Pembelian
        new Chart(document.getElementById('chartPembelian').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelsPembelian,
                datasets: [{
                    label: 'Total Pembelian',
                    data: totalPembelian,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                }]
            }
        });
    </script>
</body>

</html>