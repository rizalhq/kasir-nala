<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk (<?= $penjualan->kode_penjualan?>)</title>
    <style>
        /* Pengaturan ukuran dan layout untuk struk */
        @media print {
            /* Mengatur ukuran kertas untuk pencetakan */
            @page {
                size: 80mm auto; /* Menentukan ukuran kertas struk (80mm lebar) */
                margin: 0;
            }
        }
        body {
            font-family: Arial, sans-serif;
        }
        .receipt {
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 35px;
        }
        .header p {
            margin: 3px 0;
            font-size: 15px;
        }
        .footer p {
            margin-bottom: -10px;
        }
        .details {
            font-size: 15px;
            margin-bottom: 5px;
        }
        .details p {
            margin: 3px 0;
        }
        /* Garis atas untuk No. Nota */
        .details p:first-child {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }
        table th, table td {
            padding: 5px;
            text-align: left;
        }
        table th {
            border-bottom: 1px solid #000;
            background-color: #f0f0f0;
        }
        .item {
            border-bottom: 1px dashed #000;
        }
        .total {
            font-weight: bold;
            padding-top: 5px;
        }
        .text-right {
            text-align: right;
        }
        /* Hilangkan border di bawah total */
        .total td {
            padding-top: 5px;
            border: none; /* Menghilangkan border bawah */
        }
        /* Styling untuk kotak pada bagian PERHATIAN */
        .attention-box {
            border: 1px solid #000;
            padding: 10px;
            background-color: #f8f8f8;
            margin-top: 25px;
            font-size: 12px;
            text-align: left;
        }
        .attention-box p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h2>NALAMEDIA</h2>
            <p>Jl. Prof. M Yamin No.14, RT04/RW02<br>Cirebonan - Karanganyar<br>(Timur Stadion 45)<br>081398727722</p>
        </div>
        <div class="details">
            <!-- Garis di atas No. Nota -->
            <p>No. Nota: <?= $penjualan->kode_penjualan?></p>
            <p>Tanggal: <?= date("d F Y", strtotime($penjualan->tanggal_penjualan)) ?></p>
            <p>Customer: <?= $penjualan->nama_pelanggan ?></p>
        </div>

        <table>
            <tr class="heading">
                <th>No</th>
                <th>Keterangan</th>
                <th>Produk</th>
                <th>Panjang</th>
                <th>Lebar</th>
                <th>Harga</th>
            </tr>
            
            <?php $total = 0; $no = 1; foreach($detail as $row) { ?>
            <tr class="item">
                <td><?= $no; ?></td>
                <td><?= $row['deskripsi']; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td><?= $row['panjang']; ?></td>
                <td><?= $row['lebar']; ?></td>
                <td><?= number_format($row['sub_total']); ?></td>
            </tr>
            <?php $total += $row['sub_total']; $no++; } ?>
            
            <tr class="total">
                <td colspan="5" class="text-right">Subtotal:</td>
                <td><?= number_format($total ?? 0); ?></td>
            </tr>
            
            <tr class="total">
                <?php if ($penjualan->uang_muka != 0): ?>
                <td colspan="5" class="text-right">DP:</td>
                <td><?= number_format($penjualan->uang_muka ?? 0); ?></td>
                <?php else: ?>
                <td colspan="5" class="text-right">Jumlah Uang:</td>
                <td><?= number_format($penjualan->uang_dibayar ?? 0); ?></td>
                <?php endif; ?>
            </tr>
            
            <tr class="total">
                <?php if ($penjualan->jumlah_kurang == 0): ?>
                    <td colspan="5" class="text-right">Kembalian:</td>
                    <td><?= number_format(($penjualan->uang_dibayar ?? $penjualan->uang_muka) - $total); ?></td>
                <?php else: ?>
                    <td colspan="5" class="text-right">Kurang:</td>
                    <td><?= number_format($penjualan->jumlah_kurang ?? 0); ?></td>
                <?php endif; ?>
            </tr>
        </table>

        <div class="footer">
            <p>Pembayaran Via Transfer</p>
            <p><strong>BRI: 670701028864537</strong></p>
            <p><strong>BCA: 0154361801</strong></p>
            <p><strong>BPD JATENG: 3142069325</strong></p>
            <p><strong>a/n Ariska Prima Diastari</strong></p>
        </div>

        <!-- Bagian PERHATIAN dengan kotak -->
        <div class="attention-box">
            <p><strong>PERHATIAN :</strong></p>
            <p>Mohon barang dicek terlebih dahulu,<br><strong>komplain lebih dari 1 hari tidak kami layani.</strong></p>
        </div>
    </div>
</body>
</html>
<script>
    window.print();
</script>