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
            <h4>Laporan Penjualan</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered" id="dataTable">
            <thead>
				<tr>
					<th>No</th>
					<th>No Pesanan</th>
					<th>Pelanggan</th>
					<th>Tanggal Pemesanan</th>
					<th>Total Harga</th>
				</tr>
			</thead>
			<tbody id="tableBody">
				<?php $no=1;
                $totalHargaBeli = 0;
                foreach($laporan as $row){
                    $totalHargaBeli += $row['total_harga']; ?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= $row['kode_penjualan'] ?></td>
					<td><?= $row['nama_pelanggan'] ?></td>
					<td><?= $row['tanggal_penjualan'] ?></td>
					<td>Rp. <?= number_format($row['total_harga']) ?></td>
				</tr>
				<?php $no++; } ?>
			</tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-weight-bold">Total Harga Beli</td>
                        <td class="font-weight-bold">Rp. <?= number_format($totalHargaBeli, 2, ',', '.') ?></td> <!-- Tampilkan total -->
                    </tr>
                </tfoot>
        </div>
    </div>

    
</body>
</html>
<script>
    window.print();
</script>
