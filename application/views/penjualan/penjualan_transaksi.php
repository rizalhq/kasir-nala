<?= $this->session->flashdata('notifikasi'); ?>
<!-- form untuk tambah keranjang -->
<div class="row">
	<!-- Basic Layout -->
	<div class="col-xxl">
		<div class="card mb-4">
			<div class="card-body">
				<form action="<?= base_url('penjualan/tambahkeranjang') ?>" method="post">
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label" for="basic-default-name">No Pesanan</label>
						<div class="col-sm-10">
							<input type="number" name="kode_penjualan" class="form-control" required>
							<input type="hidden" name="id_pelanggan" class="form-control" value="<?= $id_pelanggan ?>">
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Pelanggan</label>
						<div class="col-sm-10">
							<input type="text" name="nama_pelanggan" class="form-control" value="<?= $namapelanggan ?>"
								readonly>
						</div>
					</div>
					<div class="row mb-3">
						<label for="productSelect" class="col-sm-2 col-form-label">Produk</label>
						<div class="col-sm-10">
							<div class="input-group">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal"
									data-bs-target="#pilihProduk">
									Pilih Produk
								</button>
								<input type="text" class="form-control" id="selectedProduct" name="nama_produk"
									placeholder="Produk yang dipilih" readonly>
								<input type="hidden" id="selectedProductId" name="id_produk">
							</div>
							<div id="selectedProductInfo"></div>
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10">
							<input type="text" name="deskripsi" id="keterangan" class="form-control" required>
						</div>
					</div>

<!-- Field untuk produk MMT -->
<div id="meterProduk" style="display: none;">
	<div class="row mb-3">
		<label class="col-sm-2 col-form-label">Harga per Meter</label>
		<div class="col-sm-10">
			<input type="number" name="harga_per_meter" id="harga_per_meter" class="form-control"
				oninput="calculateTotal()" required>
		</div>
	</div>
	<div class="row mb-3">
	<label class="col-sm-2 col-form-label">Panjang (m)</label>
	<div class="col-sm-2">
		<input type="text" name="panjang" id="panjang" class="form-control"
			placeholder="Panjang" oninput="validateInput(this); calculateTotal();" required>
	</div>
	<label class="col-sm-2 col-form-label">Lebar (m)</label>
	<div class="col-sm-2">
		<input type="text" name="lebar" id="lebar" class="form-control" placeholder="Lebar"
			oninput="validateInput(this); calculateTotal();" required>
	</div>
	<label class="col-sm-2 col-form-label">Bahan Terpakai (m)</label>
	<div class="col-sm-2">
		<input type="text" name="bahan_terpakai" id="bahan_terpakai" class="form-control"
			required style="background-color: #e9ecef;" oninput="validateInput(this);">
	</div>
</div>
</div>

					<!-- Field untuk produk Pcs -->
					<div id="pcsFields" style="display: none;">
						<div class="row mb-3">
							<label class="col-sm-2 col-form-label">Harga</label>
							<div class="col-sm-4">
								<input type="number" name="harga_pcs" id="harga_pcs" class="form-control"
									oninput="calculateTotalPcs()" required>
							</div>
							<label class="col-sm-2 col-form-label">Jumlah</label>
							<div class="col-sm-4">
								<input type="number" name="jumlah_pcs" id="jumlah_pcs" class="form-control"
									oninput="calculateTotalPcs()" required>
							</div>
						</div>
					</div>

					<!-- Field Total Harga untuk kedua jenis produk -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Total Harga</label>
						<div class="col-sm-10">
							<input type="text" name="sub_total" id="sub_total" class="form-control" readonly>
						</div>
					</div>

					<div class="row justify-content-end">
						<div class="col-sm-12 text-end">
							<button type="submit" class="btn btn-primary">Tambah</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- form untuk bayar barang pada keranjang -->
<div class="row">
	<div class="col-xxl">
		<div class="card mb-4">
			<div class="card-body">
				<div class="card-header d-flex justify-content-between align-items-center">
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
								<th>Produk</th>
								<th>Panjang</th>
								<th>Lebar</th>
								<th>Bahan Terpakai</th>
								<th>Deskripsi</th>
								<th>Harga</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="tableBody">
							<?php $total=0; $no=1; foreach($detail as $row){ ?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= $row['nama_produk'] ?></td>
								<td><?= $row['panjang'] ?> Meter</td>
								<td><?= $row['lebar'] ?> Meter</td>
								<td><?= $row['bahan_terpakai'] ?> Meter</td>
								<td><?= $row['deskripsi'] ?></td>
								<td>Rp. <?= number_format($row['sub_total']) ?></td>
								<td>
									<a onclick="return confirm('Apakah anda yakin menghapus data ini?')"
										href="<?= base_url('penjualan/hapus/'.$row['id_detail'].'/'.$row['id_produk']) ?>"
										class="btn btn-danger btn-sm text-white">Hapus</a>
								</td>
							</tr>
							<?php $total=$total+$row['sub_total']; $no++; } ?>
							<tr class="table-success exclude-search">
								<td colspan="6">Total Harga</td>
								<td colspan="2">Rp. <?= number_format($total); ?></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="row mt-3">
					<div class="col-12 text-end pe-3">
						<?php if($detail<>NULL) { ?>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bayar">
							Bayar
						</button>
						<?php } ?>
					</div>
				</div>

				<!-- Pagination -->
				<nav aria-label="Page navigation" class="mt-3">
					<ul class="pagination justify-content-center" id="pagination"></ul>
				</nav>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="pilihProduk" tabindex="-1" aria-hidden="true">
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

<div class="modal fade" id="bayar" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Pembayaran</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('penjualan/bayar') ?>" method="post" id="paymentForm">
				<div class="modal-body">
					<input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan; ?>">
					<input type="hidden" name="nota" value="<?= $kode_penjualan_belum_dibayar; ?>">
					<input type="hidden" name="total" id="totalBayar" value="<?= $total; ?>">

					<div class="row mb-3">
						<label class="col-sm-4 col-form-label">Status Pembayaran</label>
						<div class="col-sm-8">
							<select name="status_pembayaran" id="statusPembayaran" class="form-select" required
								onchange="toggleInputFields()">
								<option value="lunas">Lunas</option>
								<option value="dp">DP</option>
								<option value="hutang">Hutang</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-4 col-form-label">Total Bayar</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="Rp. <?= number_format($total); ?>" readonly>
						</div>
					</div>
					<div class="row mb-3" id="uangDibayarkanRow">
						<label class="col-sm-4 col-form-label">Uang yang Dibayarkan</label>
						<div class="col-sm-8">
							<input type="text" id="uangDibayarkan" name="uang_dibayarkan" class="form-control"
								placeholder="Masukkan jumlah bayar" oninput="calculateAmount()">
						</div>
					</div>
					<div class="row mb-3" id="kurangRow" style="display: none;">
						<label class="col-sm-4 col-form-label">Kurang</label>
						<div class="col-sm-8">
							<input type="text" id="kurang" name="kurang" class="form-control" placeholder="Kurang"
								readonly>
						</div>
						<input type="hidden" id="kurangHidden" name="kurangHidden" value="">
					</div>
					<div class="row mb-3" id="kembalianRow" style="display: none;">
						<label class="col-sm-4 col-form-label">Kembalian</label>
						<div class="col-sm-8">
							<input type="text" id="kembalian" name="kembalian" class="form-control"
								placeholder="Kembalian" readonly>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Bayar</button>
				</div>
			</form>
		</div>
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
		const tableBody = document.getElementById("tableBodyModal"); // Use the new ID here
		const rows = Array.from(tableBody.getElementsByTagName("tr"));
		const searchInput = document.getElementById("searchInputModal").value.toLowerCase();

		// Filter rows based on search input, excluding the second column (index 1)
		const filteredRows = rows.filter(row => {
			return Array.from(row.cells).some((cell, index) => {
				return index !== 2 && cell.textContent.toLowerCase().includes(searchInput);
			});
		});

		// Hide all rows
		rows.forEach(row => row.style.display = "none");

		// Calculate start and end indices for displayed rows
		const start = (modalCurrentPage - 1) * modalRowsPerPage;
		const end = start + modalRowsPerPage;

		// Show relevant rows after filtering
		for (let i = start; i < end && i < filteredRows.length; i++) {
			filteredRows[i].style.display = "";
		}

		// Call function to update pagination controls
		displayModalPaginationControls(filteredRows.length);
	}

	function displayModalPaginationControls(filteredRowsCount) {
		const paginationControls = document.getElementById("paginationControls");
		paginationControls.innerHTML = "";
		const totalPages = Math.ceil(filteredRowsCount / modalRowsPerPage);

		// Create pagination buttons
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
		displayModalTableRows(); // Call to display updated rows based on the search input
	}

	// Initialize modal table display when the page loads
	window.onload = function () {
		document.getElementById("searchInputModal").addEventListener("keyup", filterTableModal);
		updateTableModal();
	};

	function selectProduct(productName, productId) {
		// Set nama produk ke input
		document.getElementById("selectedProduct").value = productName;

		// Set ID produk ke input hidden
		document.getElementById("selectedProductId").value = productId;

		// (Opsional) Jika Anda ingin melakukan sesuatu setelah produk dipilih
		displaySelectedProduct();
	}

	function displaySelectedProduct() {
		const selectedProductName = document.getElementById("selectedProduct").value;

		// Menyembunyikan atau menampilkan field berdasarkan produk yang dipilih
		if (selectedProductName.includes("XBANNER") || selectedProductName.includes("ROLL UP BANNER")) {
			// Produk PCS
			document.getElementById("meterProduk").style.display = "none";
			document.getElementById("pcsFields").style.display = "block";

			// Hapus atribut 'required' dari produk MMT
			document.getElementById("harga_per_meter").removeAttribute('required');
			document.getElementById("panjang").removeAttribute('required');
			document.getElementById("lebar").removeAttribute('required');
			document.getElementById("bahan_terpakai").removeAttribute('required');

			// Set 'required' untuk produk PCS
			document.getElementById("harga_pcs").setAttribute('required', 'true');
			document.getElementById("jumlah_pcs").setAttribute('required', 'true');
		} else {
			// Produk MMT
			document.getElementById("meterProduk").style.display = "block";
			document.getElementById("pcsFields").style.display = "none";

			// Hapus atribut 'required' dari produk PCS
			document.getElementById("harga_pcs").removeAttribute('required');
			document.getElementById("jumlah_pcs").removeAttribute('required');

			// Set 'required' untuk produk MMT
			document.getElementById("harga_per_meter").setAttribute('required', 'true');
			document.getElementById("panjang").setAttribute('required', 'true');
			document.getElementById("lebar").setAttribute('required', 'true');
			document.getElementById("bahan_terpakai").setAttribute('required', 'true');
		}
	}

	function validateInput(input) {
		// Mengganti titik dengan koma dan menghapus karakter non-numerik kecuali angka dan koma
		input.value = input.value.replace('.', ',').replace(/[^0-9,]/g, '');

		// Memastikan hanya ada satu koma dalam input
		const parts = input.value.split(',');
		if (parts.length > 2) {
			input.value = parts[0] + ',' + parts[1].replace(/,/g, '');
		}
	}

	function calculateTotal() {
		const hargaPerMeter = parseFloat(document.getElementById("harga_per_meter").value.replace(',', '.')) || 0;
		const panjang = parseFloat(document.getElementById("panjang").value.replace(',', '.')) || 0;
		const lebar = parseFloat(document.getElementById("lebar").value.replace(',', '.')) || 0;

		const subTotal = hargaPerMeter * (panjang + lebar);

		// Menampilkan hasil di input yang sesuai
		document.getElementById("sub_total").value = subTotal.toFixed(2);
	}

	function calculateTotalPcs() {
		const harga = parseFloat(document.getElementById("harga_pcs").value) || 0;
		const jumlah = parseFloat(document.getElementById("jumlah_pcs").value) || 0;
		const totalHargaPcs = harga * jumlah;

		document.getElementById("sub_total").value = totalHargaPcs.toFixed(2);

		// Set panjang dan lebar ke 0 untuk produk PCS
		document.getElementById("panjang").value = 0;
		document.getElementById("lebar").value = 0;
	}


	setTimeout(function () {
		const notification = document.querySelector('.alert');
		if (notification) {
			notification.style.display = 'none';
		}
	}, 5000);
</script>

<script>
	let currentPage = 1;
	let entriesPerPage = 10;

	function updateTable() {
		entriesPerPage = parseInt(document.getElementById('entriesPerPage').value);
		currentPage = 1;
		renderTable();
	}

	function renderTable() {
		const tableBody = document.getElementById('tableBody');
		const pagination = document.getElementById('pagination');
		const rows = Array.from(tableBody.getElementsByTagName('tr'));
		const totalRows = rows.length;

		const searchInput = document.getElementById('searchInput').value.toLowerCase();
		const filteredRows = rows.filter(row => {
			const cells = row.getElementsByTagName('td');
			const name = cells[1].innerText.toLowerCase();
			const address = cells[2].innerText.toLowerCase();
			const phone = cells[3].innerText.toLowerCase();
			return name.includes(searchInput) || address.includes(searchInput) || phone.includes(searchInput);
		});

		for (let i = 0; i < totalRows; i++) {
			rows[i].style.display = 'none';
		}

		const start = (currentPage - 1) * entriesPerPage;
		const end = start + entriesPerPage;

		for (let i = start; i < end && i < filteredRows.length; i++) {
			filteredRows[i].style.display = '';
		}

		updatePagination(filteredRows.length);
	}

	function updatePagination(totalFilteredRows) {
		const pagination = document.getElementById('pagination');
		pagination.innerHTML = '';

		const totalPages = Math.ceil(totalFilteredRows / entriesPerPage);

		for (let i = 1; i <= totalPages; i++) {
			const button = document.createElement('li');
			button.className = 'page-item';

			const link = document.createElement('a');
			link.className = 'page-link';
			link.innerText = i;
			link.href = '#';
			link.onclick = (e) => {
				e.preventDefault();
				currentPage = i;
				renderTable();
			};

			button.appendChild(link);
			pagination.appendChild(button);
		}
	}

	function filterTable() {
		currentPage = 1;
		renderTable();
	}

	document.addEventListener('DOMContentLoaded', function () {
		renderTable();
	});
</script>

<script>
	document.getElementById('searchInput').addEventListener('keyup', function () {
		const filter = this.value.toLowerCase();
		const rows = document.querySelectorAll('#dataTable tbody tr');

		rows.forEach(row => {
			if (row.classList.contains('exclude-search')) {
				return; // Skip row with "exclude-search" class
			}

			let rowContainsFilter = false;

			Array.from(row.cells).forEach((cell, index) => {
				const excludedColumns = [4]; // misalnya, kolom ke-5 (index 4)

				if (!excludedColumns.includes(index)) {
					if (cell.textContent.toLowerCase().includes(filter)) {
						rowContainsFilter = true;
					}
				}
			});
			row.style.display = rowContainsFilter ? '' : 'none';
		});
	});
</script>
<script>
	// Event listener for showing the modal and setting up initial input fields
	document.getElementById('bayar').addEventListener('shown.bs.modal', toggleInputFields);

	function toggleInputFields() {
		const status = document.getElementById("statusPembayaran").value;
		const kurangRow = document.getElementById("kurangRow");
		const kembalianRow = document.getElementById("kembalianRow");
		const uangDibayarkanRow = document.getElementById("uangDibayarkanRow");

		if (status === "dp") {
			uangDibayarkanRow.style.display = "flex";
			kurangRow.style.display = "flex";
			kembalianRow.style.display = "none";
			document.getElementById("kembalian").value = ""; // Reset kembalian jika status DP
		} else if (status === "lunas") {
			uangDibayarkanRow.style.display = "flex";
			kurangRow.style.display = "none";
			kembalianRow.style.display = "flex";
			document.getElementById("kurang").value = ""; // Reset kurang jika status Lunas
		} else if (status === "hutang") {
			uangDibayarkanRow.style.display = "none"; // Sembunyikan Uang yang Dibayarkan
			kurangRow.style.display = "flex";
			kembalianRow.style.display = "none";
			document.getElementById("kurang").value = "Rp. " + parseFloat(document.getElementById("totalBayar").value)
				.toLocaleString("id-ID"); // Tampilkan total bayar di kolom kurang
			document.getElementById("kurangHidden").value = parseFloat(document.getElementById("totalBayar")
			.value); // Simpan nilai kurang
			document.getElementById("kembalian").value = ""; // Reset kembalian
		}
	}

	function calculateAmount() {
		const totalBayar = parseFloat(document.getElementById("totalBayar").value) || 0;
		const uangDibayarkan = parseFloat(document.getElementById("uangDibayarkan").value) || 0;
		const status = document.getElementById("statusPembayaran").value;

		if (status === "dp") {
			const kurang = totalBayar - uangDibayarkan;
			document.getElementById("kurang").value = kurang > 0 ? "Rp. " + kurang.toLocaleString("id-ID") : "Rp. 0";
			document.getElementById("kurangHidden").value = kurang; // Menyimpan nilai kurang ke input tersembunyi
		} else if (status === "lunas") {
			const kembalian = uangDibayarkan - totalBayar;
			document.getElementById("kembalian").value = kembalian > 0 ? "Rp. " + kembalian.toLocaleString("id-ID") :
				"Rp. 0";
			document.getElementById("kurangHidden").value = 0; // Set nilai kurang menjadi 0 jika lunas
		}
	}
</script>