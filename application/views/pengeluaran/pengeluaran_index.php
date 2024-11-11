<div class="col-12">
<div class="d-flex justify-content-between">
    <?= $this->session->flashdata('notifikasi'); ?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Tambah Pengeluaran
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
                        <select id="entriesPerPage" aria-controls="DataTables_Table_0" class="form-select ms-1" onchange="updateTable()">
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
                <input type="text" class="form-control" id="searchInput" placeholder="Search..." onkeyup="filterTable()">
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Keterangan pengeluaran</th>
                    <th>Jumlah Bahan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="tableBody">
                <?php $no=1; foreach($pengeluaran as $row){ ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['keterangan_pengeluaran'] ?></td>
                    <td>Rp. <?= number_format($row['harga_pengeluaran']) ?></td>
                    <td><?= $row['tanggal_pengeluaran'] ?></td>
                    <td>
                        <a onclick="return confirm('Apakah anda yakin menghapus data ini?')"
                            href="<?= base_url('pengeluaran/hapus/'.$row['id_pengeluaran']) ?>"
                            class="btn btn-danger btn-sm text-white">Hapus</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#gantipengeluaran-<?= $row['id_pengeluaran'] ?>">
                            Edit pengeluaran
                        </button>
                    </td>
                </tr>
                <!-- edit -->
                <div class="modal fade" id="gantipengeluaran-<?= $row['id_pengeluaran'] ?>" tabindex="-1" aria-labelledby="gantipengeluaranLabel" aria-hidden="true">
                	<div class="modal-dialog">
                		<form action="<?= base_url('pengeluaran/update/' . $row['id_pengeluaran']) ?>" method="post">
                			<div class="modal-content">
                				<div class="modal-header">
                					<h5 class="modal-title" id="gantipengeluaran">Edit Data untuk <?= $row['keterangan_pengeluaran'] ?></h5>
                					<button type="button" class="btn-close" data-bs-dismiss="modal"
                						aria-label="Close"></button>
                				</div>
                				<div class="modal-body">
                					<div class="mb-3">
                						<label for="keterangan-<?= $row['id_pengeluaran'] ?>" class="form-label">Keterangan Pengeluaran</label>
                						<input type="text" class="form-control" name="keterangan_pengeluaran" value="<?= $row['keterangan_pengeluaran'] ?>"
                							required>
                					</div>
                					<div class="mb-3">
                						<label class="form-label">Harga</label>
                						<input type="text" class="form-control" name="harga_pengeluaran" value="<?= $row['harga_pengeluaran'] ?>"
                							required>
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

<div class="modal fade" id="laporan" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('pengeluaran/laporan') ?>" method="get" target="_blank">
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

<div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('pengeluaran/simpan') ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="keterangan_pengeluaran" class="form-label">Keterangan Pengeluaran</label>
                            <input type="text" class="form-control" placeholder="Keterangan pengeluaran" name="keterangan_pengeluaran" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="harga_pengeluaran" class="form-label">Harga</label>
                            <input type="number" class="form-control" placeholder="Uang yang dikeluarkan" name="harga_pengeluaran" required>
                        </div>
                    </div>
                    <!-- Input tanggal yang disembunyikan -->
                    <input type="hidden" name="tanggal_pengeluaran" id="tanggal_pengeluaran">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_pengeluaran').value = today;
    });
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
		const totalRows = rows.length;

		// Hide all rows initially
		rows.forEach(row => row.style.display = 'none');

		// Calculate start and end indices for the current page
		const start = (currentPage - 1) * rowsPerPage;
		const end = start + rowsPerPage;

		// Display rows for the current page
		for (let i = start; i < end && i < totalRows; i++) {
			rows[i].style.display = '';
		}

		// Update pagination controls
		displayPaginationControls(totalRows);
	}

	function displayPaginationControls(totalRows) {
		const pagination = document.getElementById('pagination');
		pagination.innerHTML = '';
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

	function filterTable() {
		currentPage = 1;
		renderTable();
	}

	// Initialize the table on page load
	document.addEventListener('DOMContentLoaded', function () {
		renderTable();
	});
</script>


<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTable tbody tr');

    rows.forEach(row => {
        let rowContainsFilter = false;

        Array.from(row.cells).forEach((cell, index) => {
            const excludedColumns = [3]; // misalnya, kolom ke-5 (index 4)

            if (!excludedColumns.includes(index)) {
                if (cell.textContent.toLowerCase().includes(filter)) {
                    rowContainsFilter = true;
                }
            }
        });
        row.style.display = rowContainsFilter ? '' : 'none';
    });
});


setTimeout(function() {
    const notification = document.querySelector('.alert'); 
    if (notification) {
        notification.style.display = 'none'; 
    }
}, 5000); 
</script>
