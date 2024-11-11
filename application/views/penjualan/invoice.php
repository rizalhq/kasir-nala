<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice (<?= $penjualan->kode_penjualan?>)</title>
    <style>
        @media print {
            /* Mengatur ukuran kertas untuk pencetakan */
            @page {
                size: 80mm auto; /* Menentukan ukuran kertas struk (80mm lebar) */
                margin: 0;
            }
        }
        /* Gaya umum halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        .invoice-box {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Mengatur tabel */
        table {
            width: 100%;
            line-height: 1.6;
            text-align: left;
            border-collapse: collapse;
        }

        table tr.heading td {
            background: #f5f5f5;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tr.item td, table tr.total td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .total td:last-child {
            font-weight: bold;
        }

        .notes {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }

        .text-right {
            text-align: right;
        }

        /* Tombol Cetak Struk dan Cetak Nota PDF */
        .button-container {
    display: flex;
    justify-content: flex-start; /* Mulai dari kiri */
    align-items: center;
    margin-top: 20px;
}

.back-button {
    margin-right: auto; /* Letakkan tombol 'Kembali' di pojok kiri */
}

.center-buttons {
    display: flex;
    gap: 10px; /* Jarak antar tombol di tengah */
    margin-left: auto; /* Posisikan di tengah */
}

.button {
    display: block;
    padding: 10px 20px;
    color: #fff;
    text-align: center;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
}

.button-print {
    background-color: #4CAF50;
}

.button-print:hover {
    background-color: #45a049;
}

.button-cetak {
    background-color: #17a2b8;
}

.button-cetak:hover {
    background-color: #138496;
}

.btn-warning {
    background-color: #ffc107;
    color: #000;
}


        /* Media Print: Sembunyikan elemen yang tidak diinginkan saat mencetak */
        @media print {
            /* Menyembunyikan header judul dan tanggal */
            header, title, .button-container {
                display: none;
            }

            /* Menyembunyikan elemen lain seperti tombol-tombol cetak */
            .button {
                display: none;
            }
        }
    </style>
</head>
<body>
        <table>
            <tr class="top">
                <td colspan="7">
                    <table>
                        <tr>
                            <td class="title">
                                <!-- Logo atau Title yang lebih menarik dengan ukuran lebih besar untuk "Nala Media" -->
                                <h1 style="font-size: 38px; color: #333; margin: 0;">Nala Media</h1>
                                <h3 style="font-size: 20px; color: #777; margin-top: -20px;">Digital Printing</h3>
                            </td>
                            <td style="text-align: right;">
                                <p style="font-size: 14px; line-height: 1.5;">
                                    <strong>No Nota:</strong> <?= $penjualan->kode_penjualan?><br>
                                    <strong>Tanggal:</strong> <?= date("d F Y", strtotime($penjualan->tanggal_penjualan)) ?> <br>
                                    <strong>Kepada:</strong> <?= $penjualan->nama_pelanggan ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top: 10px;">
                                <p style="font-size: 12px; color: #555;">
                                    <strong>Alamat:</strong> No.14 RT 4 RW 2, Cerbonan Karanganyar<br>
                                    <strong>WA:</strong> 0813 9872 7722<br>
                                    <strong>Email:</strong> nalamedia.kra@gmail.com
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>No</td>
                <td>Keterangan</td>
                <td>Produk</td>
                <td>Panjang</td>
                <td>Lebar</td>
                <td>Quantity</td>
                <td>Harga</td>
            </tr>

            <?php $total = 0; $no = 1; foreach($detail as $row) { ?>
            <tr class="item">
                <td><?= $no; ?></td>
                <td><?= $row['deskripsi']; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td><?= $row['panjang']; ?></td>
                <td><?= $row['lebar']; ?></td>
                <td><?= $row['bahan_terpakai']; ?></td>
                <td>Rp <?= number_format($row['sub_total']); ?></td>
            </tr>
            <?php $total += $row['sub_total']; $no++; } ?>

            <tr class="total">
                <td colspan="6" class="text-right"><strong>Subtotal:</strong></td>
                <td colspan="2">Rp <?= number_format($total ?? 0); ?></td>
            </tr>

            <tr class="total">
                <?php if ($penjualan->uang_muka != 0): ?>
                <td colspan="6" class="text-right"><strong>DP:</strong></td>
                <td colspan="2">Rp <?= number_format($penjualan->uang_muka ?? 0); ?></td>
                <?php else: ?>
                <td colspan="6" class="text-right"><strong>Jumlah Uang:</strong></td>
                <td colspan="2">Rp <?= number_format($penjualan->uang_dibayar ?? 0); ?></td>
                <?php endif; ?>
            </tr>

            <tr class="total">
                <?php if ($penjualan->jumlah_kurang == 0): ?>
                    <td colspan="6" class="text-right"><strong>Kembalian:</strong></td>
                    <td colspan="2">Rp <?= number_format(($penjualan->uang_dibayar ?? $penjualan->uang_muka) - $total); ?></td>
                <?php else: ?>
                    <td colspan="6" class="text-right"><strong>Kurang:</strong></td>
                    <td colspan="2">Rp <?= number_format($penjualan->jumlah_kurang ?? 0); ?></td>
                <?php endif; ?>
            </tr>
        </table>

        <div class="notes">
            <p><strong>Perhatian:</strong> Mohon barang dicek terlebih dahulu. Komplain lebih dari 1 hari tidak akan
                dilayani. Pembayaran transfer ke Ariska Prima Diastari:</p>
            <ul>
                <li>BRI: 670-70-10-28864537</li>
                <li>BCA: 0154361801</li>
            </ul>
        </div>

    <!-- Tombol Cetak Struk -->
    <div class="button-container">
    <a href="<?= base_url('penjualan') ?>" class="button btn-warning back-button">< Kembali</a>
    <div class="center-buttons">
        <a href="<?= base_url('penjualan/struk/'.$nota) ?>" class="button button-print" target="_blank">Cetak Struk</a>
        <button class="button button-cetak" onclick="window.print()">Cetak Invoice</button>
    </div>
</div>


</body>
</html>
