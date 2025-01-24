<?php
// Koneksi ke database
include('koneksi.php');

function hitungTotalPembelian($jumlahList, $hargaSatuanList)
{
    $total = 0;

    foreach ($jumlahList as $key => $jumlah) {
        $hargaSatuan = $hargaSatuanList[$key];
        $subTotal = $jumlah * $hargaSatuan;
        $total += $subTotal;
    }

    return $total;
}

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = date('Y-m-d'); // Ambil tanggal saat ini

    // Data dari form
    $jumlahList = $_POST['jumlah'];
    $hargaSatuanList = $_POST['harga_satuan'];

    // Hitung total pembelian
    $totalPembelian = hitungTotalPembelian($jumlahList, $hargaSatuanList);

    echo "Total Penjualan: Rp " . number_format($totalPembelian, 2, ',', '.');

    // Proses transaksi seperti menyimpan ke database dapat dilanjutkan di sini
    try {
        $conn->begin_transaction();

        foreach ($_POST['id_obat'] as $key => $id_obat) {
            $jumlah = (int)$jumlahList[$key];
            $hargaSatuan = (float)$hargaSatuanList[$key];
            $subTotal = $jumlah * $hargaSatuan;

            // Query untuk menyimpan data penjualan
            $query_insert = "INSERT INTO penjualan (id_obat, jumlah, harga_satuan, sub_total, tanggal)
                             VALUES ('$id_obat', '$jumlah', '$hargaSatuan', '$subTotal', '$tanggal')";

            if (!$conn->query($query_insert)) {
                throw new Exception("Error saat menyimpan data penjualan: " . $conn->error);
            }

            // Query untuk memperbarui stok
            $query_update_stok = "UPDATE obat SET stok = stok - $jumlah WHERE id_obat = '$id_obat' AND stok >= $jumlah";

            if (!$conn->query($query_update_stok)) {
                throw new Exception("Stok tidak cukup untuk obat ID $id_obat atau error dalam update: " . $conn->error);
            }

            // Query untuk mencatat log stok
            $query_insert_log = "INSERT INTO stok_log (id_obat, tanggal, perubahan_stok, keterangan)
                                 VALUES ('$id_obat', '$tanggal', -$jumlah, 'Penjualan')";

            if (!$conn->query($query_insert_log)) {
                throw new Exception("Error saat mencatat log stok: " . $conn->error);
            }
        }

        $conn->commit();
        echo "Penjualan berhasil ditambahkan. Total: Rp " . number_format($totalPembelian, 2, ',', '.');
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
}

// Query untuk mengambil data nama_obat dan id_obat dari tabel obat, diurutkan berdasarkan nama_obat
$query_obat = "SELECT id_obat, nama_obat, harga FROM obat ORDER BY nama_obat ASC";
$result_obat = $conn->query($query_obat);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penjualan</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        #total_pembelian {
            margin-bottom: 15px;
            /* Jarak bawah input total pembelian */
        }

        .form-row.mt-3 {
            margin-top: 20px;
            /* Jarak atas antara input total dan tombol */
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexfix.php">
                <div class="sidebar-brand-icon">
                    <img src="img/pngegg.png" width="70" height="70">
                </div>
                <div class="sidebar-brand-text mx-3">Kumarizz</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="indexfix.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
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
            <li class="nav-item active">
                <a class="nav-link" href="akun.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Akun</span></a>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800"></h1>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header">
                                    <h5 class="m-0 font-weight-bold text-primary">Tambah Penjualan</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div id="obat-container">
                                            <div class="form-row mb-4 obat-item">
                                                <label for="id_obat" class="col-sm-2 col-form-label">Nama Obat</label>
                                                <div class="col-sm-10 mb-3">
                                                    <select class="form-control custom-select" name="id_obat[]" required>
                                                        <option value="" disabled selected>Pilih Obat</option>
                                                        <?php while ($row = $result_obat->fetch_assoc()) : ?>
                                                            <option value="<?= $row['id_obat'] ?>" data-harga="<?= $row['harga'] ?>">
                                                                <?= $row['nama_obat'] ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                                <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                                                <div class="col-sm-4 mb-3">
                                                    <input type="number" class="form-control" name="jumlah[]" required>
                                                </div>
                                                <label for="harga_satuan" class="col-sm-2 col-form-label">Harga Satuan</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="harga_satuan[]" readonly required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="total_pembelian" class="col-form-label">Total Pembelian</label>
                                            <input type="text" class="form-control form-control-sm" id="total_pembelian" readonly>
                                        </div>

                                        <div class="form-row mt-3">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" class="btn btn-secondary" onclick="tambahObat()">Tambah Obat</button>
                                                <button type="button" id="reset-page" class="btn btn-warning mr-2" onclick="location.reload()">Reset</button>
                                                <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function tambahObat() {
                    const container = document.getElementById('obat-container');
                    const item = document.querySelector('.obat-item').cloneNode(true);
                    item.querySelectorAll('input').forEach(input => input.value = '');
                    container.appendChild(item);
                }

                document.addEventListener('change', function(e) {
                    if (e.target.matches('[name="id_obat[]"]')) {
                        const harga = e.target.selectedOptions[0].getAttribute('data-harga');
                        e.target.closest('.form-row').querySelector('[name="harga_satuan[]"]').value = harga;
                    }
                });

                document.addEventListener('input', function() {
                    let total = 0;
                    document.querySelectorAll('.obat-item').forEach(item => {
                        const jumlah = parseFloat(item.querySelector('[name="jumlah[]"]').value) || 0;
                        const hargaSatuan = parseFloat(item.querySelector('[name="harga_satuan[]"]').value) || 0;
                        total += jumlah * hargaSatuan;
                    });
                    document.getElementById('total_pembelian').value = `Rp ${total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace("Rp", "")}`;
                });
            </script>

            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <script src="js/sb-admin-2.min.js"></script>
        </div>
    </div>
</body>

</html>