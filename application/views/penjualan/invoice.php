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
                size: 80mm auto;
                margin: 0;
            }
            /* Sembunyikan elemen yang tidak diperlukan saat mencetak */
            header, title, .button-container {
                display: none;
            }
            .button-container, .button, header, title {
                display: none !important;
            }
            .button {
                display: none;
            }
            /* Mengurangi margin dan padding saat print */
            body {
                margin: 0;
                padding: 5px;
            }
            /* Menghindari pemutusan halaman pada tabel */
            table {
                page-break-inside: avoid;
            }
        }
        /* Gaya umum halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #f4f4f9;
        }

        .invoice-box {
            max-width: 1000px;
            margin: auto;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Mengatur tabel */
        table {
            width: 100%;
            font-size: 12px; /* Perkecil ukuran font */
            line-height: 1.2; /* Rapihkan spasi antar baris */
            text-align: left;
            border-collapse: collapse;
        }

        table tr.heading td {
            background: #f5f5f5;
            font-weight: bold;
            padding: 5px; /* Kurangi padding */
            border: 1px solid #ddd;
        }

        table tr.item td, table tr.total td {
            padding: 5px; /* Kurangi padding */
            border: 1px solid #ddd;
        }

        .total td:last-child {
            font-weight: bold;
        }

        .notes {
            margin-top: 10px;
            font-size: 0.85em; /* Perkecil ukuran font */
            color: black;
        }

        .text-right {
            text-align: right;
        }

        /* Tombol Cetak Struk dan Cetak Nota PDF */
        .button-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 10px;
        }

        .back-button {
            margin-right: auto;
        }

        .center-buttons {
            display: flex;
            gap: 10px;
            margin-left: auto;
        }

        .button {
            display: block;
            padding: 8px 15px;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 14px;
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
    </style>
</head>
<body>
    <table>
        <tr class="top">
            <td colspan="7">
                <table>
                    <tr>
                        <td class="title">
                            <h1 style="font-size: 30px; color: black; margin: 0;">Nala Media</h1>
                            <h3 style="font-size: 16px; color: #777; margin-top: -10px;">Digital Printing</h3>
                        </td>
                        <td style="text-align: right;">
                            <p style="font-size: 12px; line-height: 1.2;">
                                <strong>No Nota:</strong> <?= $penjualan->kode_penjualan?><br>
                                <strong>Tanggal:</strong> <?= date("d F Y", strtotime($penjualan->tanggal_penjualan)) ?><br>
                                <strong>Kepada:</strong> <?= $penjualan->nama_pelanggan ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 5px;">
                            <p style="font-size: 12px;">
                                <strong>Alamat:</strong> Jl. Prof M. Yamin, Cerbonan, Karanganyar (TIMUR STADION 45)<br>
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
            <td>Panjang</td>
            <td>Lebar</td>
            <td>Quantity</td>
            <td>Harga</td>
        </tr>

        <?php $total = 0; $no = 1; foreach($detail as $row) { ?>
        <tr class="item">
            <td><?= $no; ?></td>
            <td><?= $row['deskripsi']; ?></td>
            <td><?= $row['panjang']; ?></td>
            <td><?= $row['lebar']; ?></td>
            <td><?= $row['qty']; ?></td>
            <td>Rp <?= number_format($row['sub_total']); ?></td>
        </tr>
        <?php $total += $row['sub_total']; $no++; } ?>

        <tr class="total">
            <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
            <td colspan="2">Rp <?= number_format($total ?? 0); ?></td>
        </tr>

        <tr class="total">
            <?php if ($penjualan->uang_muka != 0): ?>
            <td colspan="5" class="text-right"><strong>DP:</strong></td>
            <td colspan="2">Rp <?= number_format($penjualan->uang_muka ?? 0); ?></td>
            <?php else: ?>
            <td colspan="5" class="text-right"><strong>Jumlah Uang:</strong></td>
            <td colspan="2">Rp <?= number_format($penjualan->uang_dibayar ?? 0); ?></td>
            <?php endif; ?>
        </tr>

        <tr class="total">
            <?php if ($penjualan->jumlah_kurang == 0): ?>
                <td colspan="5" class="text-right"><strong>Kembalian:</strong></td>
                <td colspan="2">Rp <?= number_format(($penjualan->uang_dibayar ?? $penjualan->uang_muka) - $total); ?></td>
            <?php else: ?>
                <td colspan="5" class="text-right"><strong>Kurang:</strong></td>
                <td colspan="2">Rp <?= number_format($penjualan->jumlah_kurang ?? 0); ?></td>
            <?php endif; ?>
        </tr>
    </table>

    <div class="notes">
        <p><strong>Perhatian:</strong> Mohon barang dicek terlebih dahulu. Komplain lebih dari 1 hari tidak akan dilayani.</p>
        <p>Pembayaran transfer ke Ariska Prima Diastari:</p>
        <ul>
            <li>BRI: 670-70-10-28864537</li>
            <li>BCA: 0154361801</li>
            <li>BPD JATENG: 3142069325</li>
        </ul>
    </div>

    <div class="button-container">
        <a href="<?= base_url('penjualan') ?>" class="button btn-warning back-button">< Kembali</a>
        <div class="center-buttons">
            <a href="<?= base_url('penjualan/struk/'.$nota) ?>" class="button button-print" target="_blank">Cetak Struk</a>
            <button class="button button-cetak" onclick="window.print()">Cetak Invoice</button>
        </div>
    </div>
</body>
</html>
