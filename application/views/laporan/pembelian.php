<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nala Media</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 150px; /* Sesuaikan ukuran logo */
        }
        h1 {
            margin-bottom: 0;
        }
        h4 {
            margin-top: 0;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Nala Media</h1>
            <h4>Laporan Pembelian</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    <?php 
                    $no = 1; 
                    $totalHargaBeli = 0; // Inisialisasi total harga beli
                    foreach ($laporan as $row) { 
                        $totalHargaBeli += $row['harga_beli']; // Jumlahkan harga beli setiap baris
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $row['nama_produk'] ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_pembelian'])) ?></td> <!-- Format tanggal -->
                        <td><?= $row['jumlah_stok'] ?> Meter</td>
                        <td>Rp. <?= number_format($row['harga_beli'], 2, ',', '.') ?></td> <!-- Format harga -->
                    </tr>
                    <?php $no++; } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-weight-bold">Total Harga Beli</td>
                        <td class="font-weight-bold">Rp. <?= number_format($totalHargaBeli, 2, ',', '.') ?></td> <!-- Tampilkan total -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</body>
</html>
<script>
    window.print();
</script>
