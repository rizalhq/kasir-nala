<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Invoice (<?= $penjualan->kode_penjualan?>)</title>
	<style>
		@media print {
			@page {
				size: 9.5in 5.5in;
				margin: 0;
			}

			/* Sembunyikan elemen tertentu */
			.no-print {
				display: none !important;
			}

			body {
				margin: 0;
				font-family: "Courier", monospace;
				font-size: 10px;
			}

			table {
				page-break-inside: avoid;
				width: 100%;
			}

			header,
			.button-container {
				display: none !important;
			}
		}

		body {
			font-family: "Courier", monospace;
			font-size: 12px;
			line-height: 1.2;
			margin: 0;
			padding: 10px;
			background-color: #f4f4f9;
		}

		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 10px;
			border: 1px solid #ddd;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		table {
			width: 100%;
			font-size: 10px;
			border-collapse: collapse;
		}

		table tr.heading td {
			background: #f5f5f5;
			font-weight: bold;
			padding: 3px;
			border: 1px solid black;
		}

		table tr.item td {
			padding: 3px;
			border: 1px solid black;
		}

		.text-right {
			text-align: right;
		}

		.button-container {
			display: flex;
			justify-content: space-between;
			margin-top: 10px;
		}

		.button {
			padding: 5px 10px;
			color: #fff;
			border: none;
			border-radius: 3px;
			font-size: 12px;
			text-align: center;
			cursor: pointer;
			text-decoration: none;
		}

		.button.btn-warning {
			background-color: #ffc107;
			color: black;
		}

		.button.button-print {
			background-color: #4CAF50;
		}

		.button.button-cetak {
			background-color: #17a2b8;
		}

		.notes {
			margin-top: 10px;
			font-size: 0.85em;
			/* Perkecil ukuran font */
			color: black;
		}
	</style>
</head>

<body>
	<div class="invoice-box">
		<table>
			<tr class="top">
				<td colspan="6">
					<table>
						<tr>
							<td class="title">
								<h1 style="font-size: 20px; margin: 0;">Nala Media</h1>
								<h3 style="font-size: 12px; margin: 0;">Digital Printing</h3>
							</td>
							<td style="text-align: right;">
								<p>
									<strong>No Nota:</strong> <?= $penjualan->kode_penjualan ?><br>
									<strong>Tanggal:</strong>
									<?= date("d F Y", strtotime($penjualan->tanggal_penjualan)) ?><br>
									<strong>Kepada:</strong> <?= $penjualan->nama_pelanggan ?>
								</p>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<p>
									<strong>Alamat:</strong> Jl. Prof M. Yamin, Cerbonan, Karanganyar (TIMUR STADION
									45)<br>
									<strong>WA:</strong> 0813 9872 7722<br>
									<strong>Email:</strong> nalamedia.kra@gmail.com
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr class="heading">
				<td style="width: 5%;">No</td>
				<td style="width: 45%;">Keterangan</td>
				<td style="width: 10%;">Panjang</td>
				<td style="width: 10%;">Lebar</td>
				<td style="width: 10%;">Qty</td>
				<td style="width: 20%;">Harga</td>
			</tr>

			<?php $total = 0; $no = 1; foreach($detail as $row): ?>
			<tr class="item">
				<td><?= $no; ?></td>
				<td><?= $row['deskripsi']; ?></td>
				<td><?= $row['panjang']; ?></td>
				<td><?= $row['lebar']; ?></td>
				<td><?= $row['qty']; ?></td>
				<td>Rp.<?= number_format($row['sub_total']); ?></td>
			</tr>
			<?php $total += $row['sub_total']; $no++; endforeach; ?>

			<tr class="total">
				<td colspan="4" class="text-right"><strong>Subtotal</strong></td>
				<td colspan="1"></td>
				<td class="text-left"> Rp.<?= number_format($total ?? 0); ?></td>
			</tr>

			<tr class="total">
				<?php if ($penjualan->uang_muka != 0): ?>
				<td colspan="4" class="text-right"><strong>DP (Uang Muka)</strong></td>
				<td colspan="1"></td>
				<td class="text-left"> Rp.<?= number_format($penjualan->uang_muka ?? 0); ?></td>
				<?php else: ?>
				<td colspan="4" class="text-right"><strong>Jumlah Uang</strong></td>
				<td colspan="1"></td>
				<td class="text-left"> Rp.<?= number_format($penjualan->uang_dibayar ?? 0); ?></td>
				<?php endif; ?>
			</tr>

			<tr class="total">
				<?php if ($penjualan->jumlah_kurang == 0): ?>
				<td colspan="4" class="text-right"><strong>Kembalian</strong></td>
				<td colspan="1"></td>
				<td class="text-left"> Rp.<?= number_format(($penjualan->uang_dibayar ?? $penjualan->uang_muka) - $total); ?></td>
				<?php else: ?>
				<td colspan="4" class="text-right"><strong>Kurang</strong></td>
				<td colspan="1"></td>
				<td class="text-left"> Rp.<?= number_format($penjualan->jumlah_kurang ?? 0); ?></td>
				<?php endif; ?>
			</tr>


		</table>
		<div class="notes">
			<p><strong>Perhatian:</strong> Mohon barang dicek terlebih dahulu. Komplain lebih dari 1 hari tidak akan
				dilayani.</p>
			<p>Pembayaran transfer ke Ariska Prima Diastari:</p>
			<ul>
				<li>BRI: 670-70-10-28864537</li>
				<li>BCA: 0154361801</li>
				<li>BPD JATENG: 3142069325</li>
			</ul>
		</div>
		<div class="button-container">
			<a href="<?= base_url('penjualan') ?>" class="button btn-warning">Kembali</a>
			<div class="center-buttons">
				<button class="button button-cetak" onclick="window.print()">Cetak Invoice</button>
				<a href="<?= base_url('penjualan/struk/'.$nota) ?>" class="button button-print" target="_blank">Cetak
					Struk</a>
			</div>
		</div>
	</div>
</body>

</html>