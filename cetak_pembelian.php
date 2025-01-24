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

// Query untuk mengambil data pembelian dalam 1 bulan terakhir
$query = "
    SELECT 
        pembelian.id_pembelian,
        pembelian.tanggal,
        pembelian.jumlah,
        pembelian.harga_satuan,
        pembelian.sub_total,
        obat.nama_obat,
        supplier.nama_supplier
    FROM 
        pembelian
    JOIN 
        obat ON pembelian.id_obat = obat.id_obat
    JOIN 
        supplier ON pembelian.id_supplier = supplier.id_supplier
    WHERE 
        pembelian.tanggal >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ORDER BY 
        pembelian.tanggal DESC;
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
    <title>Laporan Pembelian</title>
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
        <h2>Laporan Pembelian</h2>
        <p>Data pembelian dalam 1 bulan terakhir:</p>

        <table>
            <thead>
                <tr>
                    <th>ID Pembelian</th>
                    <th>Tanggal</th>
                    <th>Nama Obat</th>
                    <th>Nama Supplier</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_pembelian'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['nama_obat'] ?></td>
                            <td><?= $row['nama_supplier'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td><?= number_format($row['harga_satuan'], 2, ',', '.') ?></td>
                            <td><?= number_format($row['sub_total'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tidak ada data pembelian dalam 1 bulan terakhir.</td>
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
