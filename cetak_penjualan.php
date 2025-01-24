<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'apotek';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data penjualan dalam 1 bulan terakhir
$query = "
    SELECT 
        penjualan.id_penjualan,
        penjualan.tanggal,
        penjualan.jumlah,
        penjualan.harga_satuan,
        penjualan.sub_total,
        obat.nama_obat
    FROM 
        penjualan
    JOIN 
        obat ON penjualan.id_obat = obat.id_obat
    WHERE 
        penjualan.tanggal >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ORDER BY 
        penjualan.tanggal DESC;
";

$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #1a73e8;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header img {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
        }
        header h1 {
            margin: 0;
            font-size: 2em;
        }
        .container {
            padding: 20px;
            max-width: 1100px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            background-color: #fafafa;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #1a73e8;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .footer p {
            margin: 0;
        }
        .back-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <!-- Ganti dengan logo yang sesuai -->
        <img src="img/pngegg.png" alt="Logo Kumarizz">
        <h1>Kumarizz</h1>
    </header>

    <div class="container">
        <h2>Laporan Penjualan</h2>
        <p>Data penjualan dalam 1 bulan terakhir:</p>

        <table>
            <thead>
                <tr>
                    <th>ID Penjualan</th>
                    <th>Tanggal</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_penjualan'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['nama_obat'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td><?= number_format($row['harga_satuan'], 2, ',', '.') ?></td>
                            <td><?= number_format($row['sub_total'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Tidak ada data penjualan dalam 1 bulan terakhir.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Tombol Kembali -->
        <a href="javascript:window.history.back();" class="back-button">Kembali</a>

    </div>

    <script>
        // Cetak otomatis setelah halaman selesai dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
