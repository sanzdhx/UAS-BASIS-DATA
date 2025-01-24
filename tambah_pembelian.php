<?php
// Koneksi ke database
include('koneksi.php');

// Query untuk mengambil data nama_obat dan id_obat dari tabel obat
$query_obat = "SELECT id_obat, nama_obat FROM obat ORDER BY nama_obat ASC";
$result_obat = $conn->query($query_obat);

// Query untuk mengambil data id_supplier dan nama_supplier dari tabel supplier
$query_supplier = "SELECT id_supplier, nama_supplier FROM supplier";
$result_supplier = $conn->query($query_supplier);

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_supplier = $_POST['id_supplier'];
    $tanggal = date('Y-m-d'); // Ambil tanggal saat ini
    $data_obat = $_POST['obat'];

    try {
        $conn->begin_transaction(); // Mulai transaksi

        foreach ($data_obat as $obat) {
            $id_obat = $obat['id_obat'];
            $jumlah = $obat['jumlah'];
            $harga_satuan = $obat['harga_satuan'];
            $sub_total = $jumlah * $harga_satuan;

            // Query untuk menyimpan data pembelian
            $query_insert = "INSERT INTO pembelian (id_obat, id_supplier, jumlah, harga_satuan, sub_total, tanggal)
                             VALUES ('$id_obat', '$id_supplier', '$jumlah', '$harga_satuan', '$sub_total', '$tanggal')";
            if (!$conn->query($query_insert)) {
                throw new Exception("Error saat menyimpan data pembelian: " . $conn->error);
            }

            // Update stok obat
            $query_update_stok = "UPDATE obat 
                                  SET stok = stok + $jumlah 
                                  WHERE id_obat = '$id_obat'";
            if (!$conn->query($query_update_stok)) {
                throw new Exception("Error saat memperbarui stok: " . $conn->error);
            }

            // Catat log stok
            $query_insert_log = "INSERT INTO stok_log (id_obat, tanggal, perubahan_stok, keterangan)
                                 VALUES ('$id_obat', '$tanggal', '$jumlah', 'Pembelian')";
            if (!$conn->query($query_insert_log)) {
                throw new Exception("Error saat mencatat log stok: " . $conn->error);
            }
        }

        $conn->commit(); // Komit transaksi jika semua berhasil
        echo "Pembelian berhasil ditambahkan!";
    } catch (Exception $e) {
        $conn->rollback(); // Rollback jika ada error
        echo "Transaksi gagal: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexfix.php">
                <div class="sidebar-brand-icon">
                    <img src="img/pngegg.png" width="70" height="70">
                </div>
                <div class="sidebar-brand-text mx-3">Kumarizz</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active"><a class="nav-link" href="indexfix.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li class="nav-item active"><a class="nav-link" href="obat.php"><i class="fas fa-fw fa-folder"></i><span>Obat</span></a></li>
            <li class="nav-item active"><a class="nav-link" href="penjualan.php"><i class="fas fa-fw fa-folder"></i><span>Penjualan</span></a></li>
            <li class="nav-item active"><a class="nav-link" href="pembelian.php"><i class="fas fa-fw fa-folder"></i><span>Pembelian</span></a></li>
            <li class="nav-item active"><a class="nav-link" href="supplier.php"><i class="fas fa-fw fa-folder"></i><span>Supplier</span></a></li>
            <li class="nav-item active"><a class="nav-link" href="akun.php"><i class="fas fa-fw fa-users"></i><span>Akun</span></a></li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800"></h1>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header">
                                    <h5 class="m-0 font-weight-bold text-primary">Tambah Pembelian</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="form-row mb-3">
                                            <label for="id_supplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                                            <div class="col-sm-10">
                                                <select class="form-control custom-select" name="id_supplier" id="id_supplier" required>
                                                    <option value="" disabled selected>Pilih Nama Supplier</option>
                                                    <?php while ($row = $result_supplier->fetch_assoc()) : ?>
                                                        <option value="<?= $row['id_supplier'] ?>"><?= $row['nama_supplier'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="obat-container">
                                            <div class="form-row mb-3 obat-item">
                                                <label for="id_obat" class="col-sm-2 col-form-label">Nama Obat</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control custom-select" name="obat[0][id_obat]" required>
                                                        <option value="" disabled selected>Pilih Nama Obat</option>
                                                        <?php while ($row = $result_obat->fetch_assoc()) : ?>
                                                            <option value="<?= $row['id_obat'] ?>"><?= $row['nama_obat'] ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                                <label for="jumlah" class="col-sm-1 col-form-label">Jumlah</label>
                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control" name="obat[0][jumlah]" required>
                                                </div>
                                                <label for="harga_satuan" class="col-sm-1 col-form-label">Harga Satuan</label>
                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control" name="obat[0][harga_satuan]" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <label for="total_pembelian" class="col-sm-2 col-form-label">Total Pembelian</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="total_pembelian" name="total_pembelian" readonly>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" id="add-obat" class="btn btn-secondary mr-2">Tambah Obat</button>
                                                <button type="button" id="reset-page" class="btn btn-warning mr-2" onclick="location.reload()">Reset</button>
                                                <button type="submit" class="btn btn-primary">Tambah Pembelian</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        let obatIndex = 1;
        document.getElementById('add-obat').addEventListener('click', () => {
            const container = document.getElementById('obat-container');
            const newItem = container.firstElementChild.cloneNode(true);
            newItem.querySelectorAll('select, input').forEach((input) => {
                input.name = input.name.replace(/\[\d+\]/, `[${obatIndex}]`);
                input.value = '';
            });
            container.appendChild(newItem);
            obatIndex++;
        });

        document.addEventListener('input', function() {
            let total = 0;
            document.querySelectorAll('.obat-item').forEach(item => {
                const jumlah = parseFloat(item.querySelector('[name*="[jumlah]"]').value) || 0;
                const harga = parseFloat(item.querySelector('[name*="[harga_satuan]"]').value) || 0;
                total += jumlah * harga;
            });
            document.getElementById('total_pembelian').value = total.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
        });
    </script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>