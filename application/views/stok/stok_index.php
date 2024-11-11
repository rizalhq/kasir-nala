<div class="col-12">
	<?= $this->session->flashdata('notifikasi'); ?>
	<div class="d-flex justify-content-between">
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
			Tambah Stok
		</button>
		<button type="button" class="btn btn-dark ms-auto" data-bs-toggle="modal" data-bs-target="#laporan">
			Cetak Laporan
		</button>
	</div>
</div>

<div class="card mt-4">
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
					<th>Jumlah Barang</th>
					<th>Tanggal Pembelian</th>
					<th>Harga Barang</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody class="table-border-bottom-0" id="tableBody">
				<?php $no=1; foreach($stok as $row){ ?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= $row['nama_produk'] ?></td>
					<td><?= $row['jumlah_stok'] ?> Meter</td>
					<td><?= $row['tanggal_pembelian'] ?></td>
					<td>Rp. <?= number_format($row['harga_beli']) ?></td>
					<td>
						<a onclick="return confirm('Apakah anda yakin menghapus data ini?')"
							href="<?= base_url('stok/hapus/'.$row['id_stok']) ?>"
							class="btn btn-danger btn-sm text-white">Hapus</a>
						<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
							data-bs-target="#gantistok-<?= $row['id_stok'] ?>">
							Edit Stok
						</button>
					</td>
				</tr>
				<!-- edit -->
				<div class="modal fade" id="gantistok-<?= $row['id_stok'] ?>" tabindex="-1"
					aria-labelledby="gantistokLabel" aria-hidden="true">
					<div class="modal-dialog">
						<form action="<?= base_url('stok/update/' . $row['id_stok']) ?>" method="post">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="gantistok">Edit Data untuk <?= $row['nama_produk'] ?>
									</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal"
										aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="mb-3">
										<label for="nama-<?= $row['nama_produk'] ?>" class="form-label">Nama</label>
										<input type="text" class="form-control" name="nama_barang"
											value="<?= $row['nama_produk'] ?>" readonly>
									</div>
									<div class="mb-3">
										<label class="form-label">Jumlah</label>
										<input type="number" class="form-control" name="jumlah_barang"
											value="<?= $row['jumlah_stok'] ?>" required>
									</div>
									<div class="mb-3">
										<label class="form-label">Harga Beli</label>
										<input type="number" class="form-control" name="harga_beli"
											value="<?= $row['harga_beli'] ?>" required>
									</div>
									<!-- Tambahkan input tersembunyi untuk id_produk -->
									<input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
									<input type="hidden" name="tanggal_pembelian"
										value="<?= $row['tanggal_pembelian'] ?>">
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

<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<form action="<?= base_url('stok/simpan') ?>" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">Tambah Stok</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label for="productSelect" class="form-label">Pilih Produk</label>
						<div class="input-group">
							<button type="button" class="btn btn-primary" data-bs-toggle="modal"
								data-bs-target="#pilihProduk" onclick="openProductModal('basicModal')">
								Pilih Produk
							</button>
							<input type="text" class="form-control" id="selectedProductBasic" name="nama_produk"
								placeholder="Produk yang dipilih" readonly>
							<input type="hidden" id="selectedProductIdBasic" name="id_produk">
						</div>
					</div>
					<div class="mb-3">
						<label for="stokInput" class="form-label">Jumlah Stok</label>
						<input type="number" class="form-control" id="stokInput" name="jumlah_stok"
							placeholder="Masukkan jumlah stok" required>
					</div>
					<div class="mb-3">
						<label for="stokInput" class="form-label">Harga Beli</label>
						<input type="number" class="form-control" id="stokInput" name="harga_beli"
							placeholder="Masukkan Harga Beli" required>
					</div>
					<input type="hidden" name="tanggal_pembelian" value="<?= date('Y-m-d') ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="pilihProduk" tabindex="-1" aria-hidden="true" data-bs-caller="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Pilih Produk</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive text-nowrap">
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
					<table class="table" id="dataTable">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Produk</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody class="table-border-bottom-0" id="tableBodyModal">
							<?php $no=1; foreach($produk as $row){ ?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= $row['nama_produk'] ?></td>
								<td>
									<button type="button" class="btn btn-warning btn-sm"
										onclick="selectProduct('<?= $row['nama_produk'] ?>', '<?= $row['id_produk'] ?>')"
										data-bs-dismiss="modal">
										Pilih
									</button>
								</td>
							</tr>
							<?php $no++; } ?>
						</tbody>
					</table>
					<nav aria-label="Page navigation">
						<ul class="pagination justify-content-center" id="paginationControls"></ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="laporan" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('stok/laporan') ?>" method="get" target="_blank">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">Laporan</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col mb-3">
							<label class="form-label">Nama Barang</label>
							<div class="input-group">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal"
									data-bs-target="#pilihProduk" onclick="openProductModal('laporan')">
									Pilih Produk
								</button>
								<input type="text" class="form-control" id="selectedProductLaporan" name="nama_produk"
									placeholder="Produk yang dipilih" readonly>
								<input type="hidden" id="selectedProductIdLaporan" name="id_produk">
							</div>
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
	const modalRowsPerPageOptions = [10, 25, 50, 100];
	let modalCurrentPage = 1;
	let modalRowsPerPage = 10;

	document.getElementById('pilihProduk').addEventListener('shown.bs.modal', function () {
		modalCurrentPage = 1;
		displayModalTableRows();
	});

	function updateTableModal() {
		modalRowsPerPage = parseInt(document.getElementById("entriesPerPageModal").value);
		modalCurrentPage = 1;
		displayModalTableRows();
	}

	function displayModalTableRows() {
		const tableBody = document.getElementById("tableBodyModal");
		const rows = Array.from(tableBody.getElementsByTagName("tr"));
		const searchInput = document.getElementById("searchInputModal").value.toLowerCase();

		// Filter baris berdasarkan input pencarian, kecuali kolom kedua (index 1)
		const filteredRows = rows.filter(row => {
			return Array.from(row.cells).some((cell, index) => {
				// Mengecualikan kolom kedua (index 1) dari pencarian
				return index !== 2 && cell.textContent.toLowerCase().includes(searchInput);
			});
		});

		// Sembunyikan semua baris
		rows.forEach(row => row.style.display = "none");

		// Hitung indeks mulai dan akhir untuk baris yang ditampilkan
		const start = (modalCurrentPage - 1) * modalRowsPerPage;
		const end = start + modalRowsPerPage;

		// Tampilkan baris yang relevan setelah pemfilteran
		for (let i = start; i < end && i < filteredRows.length; i++) {
			filteredRows[i].style.display = "";
		}

		// Panggil fungsi untuk memperbarui kontrol pagination
		displayModalPaginationControls(filteredRows.length);
	}

	function displayModalPaginationControls(filteredRowsCount) {
		const paginationControls = document.getElementById("paginationControls");
		paginationControls.innerHTML = "";
		const totalPages = Math.ceil(filteredRowsCount / modalRowsPerPage);

		// Buat tombol pagination
		for (let i = 1; i <= totalPages; i++) {
			const li = document.createElement("li");
			li.className = "page-item" + (i === modalCurrentPage ? " active" : "");
			li.innerHTML = `<a class="page-link" href="#" onclick="goToModalPage(${i})">${i}</a>`;
			paginationControls.appendChild(li);
		}
	}

	function goToModalPage(pageNumber) {
		modalCurrentPage = pageNumber;
		displayModalTableRows();
	}

	function filterTableModal() {
		displayModalTableRows();
	}

	// Inisialisasi tampilan tabel modal saat pertama kali halaman dimuat
	window.onload = function () {
		document.getElementById("searchInputModal").addEventListener("keyup", filterTableModal);
		updateTableModal();
	};

	function openProductModal(callerModalId) {
		var pilihProdukModal = document.getElementById('pilihProduk');
		pilihProdukModal.setAttribute('data-bs-caller', callerModalId); // Set data pemanggil

		var modalInstance = new bootstrap.Modal(pilihProdukModal);
		modalInstance.show();
	}

	function selectProduct(productName, productId) {
		var callerModalId = document.getElementById('pilihProduk').getAttribute('data-bs-caller');

		// Pilih elemen input berdasarkan modal pemanggil
		if (callerModalId === 'basicModal') {
			document.getElementById('selectedProductBasic').value = productName;
			document.getElementById('selectedProductIdBasic').value = productId;
		} else if (callerModalId === 'laporan') {
			document.getElementById('selectedProductLaporan').value = productName;
			document.getElementById('selectedProductIdLaporan').value = productId;
		}

		// Tutup modal "Pilih Produk"
		var pilihProdukModal = bootstrap.Modal.getInstance(document.getElementById('pilihProduk'));
		pilihProdukModal.hide();

		// Pastikan backdrop dihapus
		removeBackdrop();

		// Tampilkan kembali modal pemanggil
		if (callerModalId) {
			var callerModal = new bootstrap.Modal(document.getElementById(callerModalId));
			callerModal.show();
		}
	}

	// Fungsi untuk menghapus backdrop
	function removeBackdrop() {
		var backdrop = document.querySelector('.modal-backdrop');
		if (backdrop) {
			backdrop.parentNode.removeChild(backdrop);
		}
	}
</script>

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
				const excludedColumns = [5]; // Kolom yang ingin diabaikan
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