<div class="row">
    <!-- Pemasukan Hari Ini -->
    <div class="col-lg-4 col-md-12 col-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="<?= base_url('aset/sneat')?>/assets/img/icons/unicons/line-chart-regular.png"
                            alt="chart success" class="rounded green-filter" style="width: 30px; height: 30px;" />
                    </div>
                </div>
                <span class="fw-semibold d-block mb-2">Total Pemasukan Hari Ini</span>
                <h3 class="text-success card-title mb-4"><i class="bx bx-up-arrow-alt"></i>Rp. <?= number_format($pemasukan, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>

    <!-- Pengeluaran Hari Ini -->
    <div class="col-lg-4 col-md-12 col-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="<?= base_url('aset/sneat')?>/assets/img/icons/unicons/line-chart-down-regular.png"
                            alt="chart success" class="rounded red-filter" style="width: 30px; height: 30px;" />
                    </div>
                </div>
                <span class="fw-semibold d-block mb-2">Total Pengeluaran Hari Ini</span>
                <h3 class="text-danger card-title mb-4"><i class="bx bx-down-arrow-alt"></i>Rp. <?= number_format($pengeluaran, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>

    <!-- Hutang Hari Ini -->
    <div class="col-lg-4 col-md-12 col-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="<?= base_url('aset/sneat')?>/assets/img/icons/unicons/line-chart-down-regular.png"
                            alt="chart success" class="rounded red-filter" style="width: 30px; height: 30px;" />
                    </div>
                </div>
                <span class="fw-semibold d-block mb-2">Total Pembayaran Yang Kurang Hari Ini</span>
                <h3 class="text-danger card-title mb-4"><i class="bx bx-down-arrow-alt"></i>Rp. <?= number_format($hutang, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
</div>


<div class="col-12">
	<?= $this->session->flashdata('notifikasi'); ?>
	<div class="d-flex justify-content-between">
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
			Tambah Penjualan
		</button>
		<button type="button" class="btn btn-dark ms-auto" data-bs-toggle="modal" data-bs-target="#laporan">
			Cetak Laporan
		</button>
	</div>
</div>

<div class="card mt-4">
	<div class="card-header d-flex justify-content-between align-items-center">
		<!-- Entries per Page Dropdown -->
		<div class="dataTables_length" style="width: auto;">
			<label class="mb-0">
				<span class="d-flex align-items-center">
					<span class="me-1">Show</span>
					<select id="entriesPerPage" class="form-select" onchange="updateTable()">
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					<span class="ms-1">entries</span>
				</span>
			</label>
		</div>

		<!-- Filter Status Dropdown placed next to the Search Input -->
		<form class="col-6 d-flex justify-content-end" id="searchForm">
			<!-- Filter Status -->
			<div style="margin-right: 10px;">
				<label class="mb-0">
					<span class="d-flex align-items-center">
						<select id="statusFilter" class="form-select" onchange="updateTable()">
							<option value="">Filter Status</option>
							<option value="Belum Lunas">Belum Lunas</option>
							<option value="Lunas">Lunas</option>
						</select>
					</span>
				</label>
			</div>

			<!-- Search Input -->
			<div class="input-group" style="width: 60%;">
				<span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
				<input type="text" class="form-control" id="searchInput" placeholder="Search..."
					onkeyup="filterTable()">
			</div>
		</form>
	</div>

	<div class="table-responsive text-nowrap">
		<table class="table" id="dataTable">
			<thead>
				<tr>
					<th>No</th>
					<th>No Pesanan</th>
					<th>Pelanggan</th>
					<th>Tanggal Pemesanan</th>
					<th>Total Harga</th>
					<th>Status</th>
					<th>Kurang</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody id="tableBody">
				<?php $no=1; foreach($penjualan as $row){ ?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= $row['kode_penjualan'] ?></td>
					<td><?= $row['nama_pelanggan'] ?></td>
					<td><?= $row['tanggal_penjualan'] ?></td>
					<td>Rp. <?= number_format($row['total_harga']) ?></td>
					<td>
						<?php 
                // Jika status pembayaran belum lunas
                if($row['status_pembayaran'] == 'Belum Lunas'){ 
                    echo "<span style='color: red;'>Belum Lunas</span>";
                } 
                // Jika status pembayaran lunas
                else if($row['status_pembayaran'] == 'Lunas') {
                    echo "<span style='color: green;'>Lunas</span>";
                }
            ?>
					</td>
					<td>Rp. <?= number_format($row['jumlah_kurang']) ?></td>
					<td>
						<a href="<?= base_url('penjualan/invoice/'.$row['kode_penjualan']) ?>"
							class="btn btn-info btn-sm text-white" target="_blank">Lihat detail</a>
						<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
							data-bs-target="#pembayaran-<?= $row['id_penjualan'] ?>">
							Edit Pembayaran
						</button>
					</td>
				</tr>
				<!-- edit -->
				<div class="modal fade" id="pembayaran-<?= $row['id_penjualan'] ?>" tabindex="-1"
					aria-labelledby="gantiprodukLabel" aria-hidden="true"
					data-status-pembayaran="<?= $row['status_pembayaran'] ?>">
					<div class="modal-dialog">
						<form action="<?= base_url('penjualan/update/' . $row['id_penjualan']) ?>" method="post">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="gantiproduk"><?= $row['kode_penjualan'] ?>
										(<?= $row['status_pembayaran'] ?>)</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal"
										aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="mb-3">
										<label class="form-label">Kekurangan</label>
										<input type="text" class="form-control"
											id="kekuranganInput-<?= $row['id_penjualan'] ?>"
											value="<?= $row['jumlah_kurang'] ?>" readonly>
									</div>
									<div class="mb-3" id="bayarInput">
										<label class="form-label">Bayar</label>
										<input type="number" class="form-control"
											id="bayarInput-<?= $row['id_penjualan'] ?>" name="uang_dibayar"
											value="<?= $row['uang_dibayar'] ?>"
											oninput="calculateTotalAkhir(<?= $row['id_penjualan'] ?>)" required>
									</div>
									<div class="mb-3" id="totalAkhirInput">
										<label class="form-label">Total Akhir</label>
										<input type="text" class="form-control"
											id="totalAkhirInput-<?= $row['id_penjualan'] ?>" name="total_akhir"
											readonly>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary"
										data-bs-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<?php $no++; } ?>
			</tbody>
		</table>
	</div>

	<!-- Pagination -->
	<nav aria-label="Page navigation" class="mt-3">
		<ul class="pagination justify-content-center" id="pagination"></ul>
	</nav>
</div>

<!-- Modal untuk Tambah Penjualan -->
<div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form action="<?= base_url('penjualan/simpan') ?>" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Pilih Pelanggan</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div class="dataTables_length" style="width: auto;">
							<label class="mb-0">
								<span class="d-flex align-items-center">
									<span>Show</span>
									<select id="entriesPerPageModal" class="form-select ms-1"
										onchange="updateTableModal()">
										<option value="10">10</option>
										<option value="25">25</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
									<span class="ms-1">entries</span>
								</span>
							</label>
						</div>
						<div class="d-flex" style="width: auto;">
							<div class="input-group">
								<span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
								<input type="text" class="form-control" id="searchInputModal" placeholder="Search..."
									onkeyup="filterTableModal()">
							</div>
						</div>
					</div>
					<table class="table" id="dataTableModal">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Telp</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="tableBodyModal">
							<?php $no=1; foreach($pelanggan as $row){ ?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= $row['nama_pelanggan'] ?></td>
								<td><?= $row['alamat'] ?></td>
								<td><?= $row['telp'] ?></td>
								<td>
									<a href="<?= base_url('penjualan/transaksi/'.$row['id_pelanggan']) ?>"
										class="btn-sm btn-warning text-white">Pilih</a>
								</td>
							</tr>
							<?php $no++; } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="laporan" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('penjualan/laporan') ?>" method="get" target="_blank">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">Laporan</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col mb-3">
							<label class="form-label">Rentang Tanggal Pertama</label>
							<input type="date" class="form-control" name="tanggal1" required />
						</div>
						<div class="col mb-3">
							<label class="form-label">Rentang Tanggal Kedua</label>
							<input type="date" class="form-control" name="tanggal2" required />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- JavaScript untuk Filter dan Jumlah Entri -->
<script>
	const rowsPerPageOptions = [10, 25, 50, 100];
	let currentPage = 1;
	let rowsPerPage = 10;

	function updateTable() {
		rowsPerPage = parseInt(document.getElementById('entriesPerPage').value);
		currentPage = 1;
		renderTable();
	}

	function renderTable() {
		const tableBody = document.getElementById('tableBody');
		const rows = Array.from(tableBody.getElementsByTagName('tr'));
		const searchInput = document.getElementById('searchInput').value.toLowerCase();
		const statusFilter = document.getElementById('statusFilter').value;

		// Filter rows based on search input and status filter
		const filteredRows = rows.filter(row => {
			const statusCell = row.cells[5].textContent.trim(); // Kolom status ada di index 5
			const matchesStatus = statusFilter === "" || statusCell === statusFilter;
			const matchesSearch = Array.from(row.cells).some((cell, index) => {
				const excludedColumns = [6]; // Kolom yang ingin diabaikan
				return !excludedColumns.includes(index) && cell.textContent.toLowerCase().includes(
					searchInput);
			});

			return matchesStatus && matchesSearch;
		});

		// Hide all rows initially
		rows.forEach(row => row.style.display = 'none');

		// Calculate start and end indices for the current page
		const start = (currentPage - 1) * rowsPerPage;
		const end = start + rowsPerPage;

		// Display filtered rows for the current page
		for (let i = start; i < end && i < filteredRows.length; i++) {
			filteredRows[i].style.display = '';
		}

		// Update pagination controls based on filtered rows
		displayPaginationControls(filteredRows.length);
	}


	function displayPaginationControls(totalRows) {
		const pagination = document.getElementById('pagination');
		pagination.innerHTML = ''; // Clear existing pagination
		const totalPages = Math.ceil(totalRows / rowsPerPage);

		// Create pagination buttons
		for (let i = 1; i <= totalPages; i++) {
			const li = document.createElement('li');
			li.className = 'page-item' + (i === currentPage ? ' active' : '');

			const link = document.createElement('a');
			link.className = 'page-link';
			link.innerText = i;
			link.href = '#';
			link.onclick = (e) => {
				e.preventDefault();
				goToPage(i);
			};

			li.appendChild(link);
			pagination.appendChild(li);
		}
	}

	function goToPage(pageNumber) {
		currentPage = pageNumber;
		renderTable();
	}

	// Event listener for search input
	document.getElementById('searchInput').addEventListener('keyup', function () {
		currentPage = 1; // Reset to first page on search
		renderTable(); // Call renderTable to update display
	});

	// Initialize the table on page load
	document.addEventListener('DOMContentLoaded', function () {
		renderTable();
	});
</script>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		document.querySelectorAll('.modal').forEach(function (modal) {
			const statusPembayaran = modal.getAttribute('data-status-pembayaran');
			const modalId = modal.id.split('-')[1];

			const bayarInput = modal.querySelector('#bayarInput');
			const totalAkhirInput = modal.querySelector('#totalAkhirInput');

			if (statusPembayaran === 'Lunas') {
				bayarInput.style.display = 'none';
				totalAkhirInput.style.display = 'none';
			} else {
				calculateTotalAkhir(modalId);
			}
		});
	});

	function calculateTotalAkhir(id) {
		const kekurangan = parseFloat(document.getElementById(`kekuranganInput-${id}`).value) || 0;
		const bayar = parseFloat(document.getElementById(`bayarInput-${id}`).value) || 0;
		let totalAkhir = kekurangan - bayar;

		if (totalAkhir < 0) {
			totalAkhir = 0;
		}

		document.getElementById(`totalAkhirInput-${id}`).value = totalAkhir;

		const statusLabel = document.querySelector(`#pembayaran-${id} .modal-title`);
		if (totalAkhir === 0) {
			statusLabel.textContent = statusLabel.textContent.replace(/Lunas|Belum Lunas/, "Lunas");
		}
	}
</script>