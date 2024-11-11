<div class="row">
	<!-- Pemasukan -->
	<div class="col-lg-4 col-md-12 col-4 mb-4">
		<div class="card">
			<div class="card-body">
				<div class="card-title d-flex align-items-start justify-content-between">
					<div class="avatar flex-shrink-0">
						<img src="<?= base_url('aset/sneat')?>/assets/img/icons/unicons/line-chart-regular.png"
							alt="chart success" class="rounded green-filter" style="width: 30px; height: 30px;" />
					</div>
				</div>
				<span class="fw-semibold d-block mb-2">Total Pemasukan</span>
				<h3 class="text-success card-title mb-4"><i class="bx bx-up-arrow-alt"></i>Rp.
					<?= number_format($pemasukan, 0, ',', '.') ?></h3>
			</div>
		</div>
	</div>

	<!-- Pengeluaran -->
	<div class="col-lg-4 col-md-12 col-4 mb-4">
		<div class="card">
			<div class="card-body">
				<div class="card-title d-flex align-items-start justify-content-between">
					<div class="avatar flex-shrink-0">
						<img src="<?= base_url('aset/sneat')?>/assets/img/icons/unicons/line-chart-down-regular.png"
							alt="chart success" class="rounded red-filter" style="width: 30px; height: 30px;" />
					</div>
				</div>
				<span class="fw-semibold d-block mb-2">Total Pengeluaran</span>
				<h3 class="text-danger card-title mb-4"><i class="bx bx-down-arrow-alt"></i>Rp.
					<?= number_format($pengeluaran, 0, ',', '.') ?></h3>
			</div>
		</div>
	</div>
	<!-- Hutang -->
	<div class="col-lg-4 col-md-12 col-4 mb-4">
		<div class="card">
			<div class="card-body">
				<div class="card-title d-flex align-items-start justify-content-between">
					<div class="avatar flex-shrink-0">
						<img src="<?= base_url('aset/sneat')?>/assets/img/icons/unicons/line-chart-down-regular.png"
							alt="chart success" class="rounded red-filter" style="width: 30px; height: 30px;" />
					</div>
				</div>
				<span class="fw-semibold d-block mb-2">Total Hutang</span>
				<h3 class="text-danger card-title mb-4"><i class="bx bx-down-arrow-alt"></i>Rp.
					<?= number_format($hutang, 0, ',', '.') ?></h3>
			</div>
		</div>
	</div>
</div>

<div class="col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
	<div class="card">
		<div class="row row-bordered g-0">
			<div class="col-md-12 d-flex justify-content-between align-items-center">
				<h5 class="card-header m-0 me-2 pb-3">Tabel Piutang</h5>
				<button type="button" class="btn btn-dark m-2" data-bs-toggle="modal" data-bs-target="#laporan">
					Cetak Laporan
				</button>
			</div>
			<div class="card-header d-flex justify-content-between align-items-center">
				<div class="input-group me-2" style="width: auto;">
					<div class="dataTables_length" id="DataTables_Table_0_length">
						<label class="mb-0">
							<span class="d-flex align-items-center">
								<span class="ms-0">Show</span>
								<select id="entriesPerPage" aria-controls="DataTables_Table_0" class="form-select ms-1"
									onchange="updateTable()">
									<option value="10">10</option>
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
								</select>
								<span class="ms-1">entries</span>
							</span>
						</label>
					</div>
				</div>
				<form class="col-3 ms-auto" id="searchForm">
					<div class="input-group">
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
							<th>Nama</th>
							<th>Alamat</th>
							<th>No transaksi</th>
							<th>tanggal transaksi</th>
							<th>status</th>
							<th>Total Hutang</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody id="tableBody">
						<?php $no=1; foreach($piutang as $row){ ?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= $row['nama_pelanggan'] ?></td>
							<td><?= $row['alamat'] ?></td>
							<td><?= $row['kode_penjualan'] ?></td>
							<td><?= $row['tanggal_penjualan'] ?></td>
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
									class="btn btn-success btn-sm text-white" target="_blank">Lihat detail</a>
							</td>
						</tr>
						<?php $no++; } ?>
					</tbody>
				</table>
			</div>

		</div>
		<!-- Pagination -->
		<nav aria-label="Page navigation" class="mt-3">
			<ul class="pagination justify-content-center" id="pagination"></ul>
		</nav>
	</div>
</div>

<div class="modal fade" id="laporan" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('home/laporan') ?>" method="get" target="_blank">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">Laporan</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col mb-3">
							<label class="form-label">Status</label>
                            <select name="status_pembayaran" class="form-control">
                                <option value=" ">Semua</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                            </select>
						</div>
					</div>
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

		// Filter rows based on search input
		const filteredRows = rows.filter(row => {
			return Array.from(row.cells).some((cell, index) => {
				const excludedColumns = [7]; // Kolom yang ingin diabaikan
				return !excludedColumns.includes(index) && cell.textContent.toLowerCase().includes(
					searchInput);
			});
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