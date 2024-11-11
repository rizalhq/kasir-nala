<div class="col-12">
    <?= $this->session->flashdata('notifikasi'); ?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Tambah Pelanggan
    </button>
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
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="tableBody">
                <?php $no=1; foreach($pelanggan as $row){ ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['nama_pelanggan'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    <td><?= $row['telp'] ?></td>
                    <td>
                        <a onclick="return confirm('Apakah anda yakin menghapus data ini?')"
                            href="<?= base_url('pelanggan/hapus/'.$row['id_pelanggan']) ?>"
                            class="btn btn-danger btn-sm text-white">Hapus</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#gantipelanggan-<?= $row['id_pelanggan'] ?>">
                            Edit Pelanggan
                        </button>
                    </td>
                </tr>
                <!-- edit -->
                <div class="modal fade" id="gantipelanggan-<?= $row['id_pelanggan'] ?>" tabindex="-1" aria-labelledby="gantipelangganLabel" aria-hidden="true">
                	<div class="modal-dialog">
                		<form action="<?= base_url('pelanggan/update/' . $row['id_pelanggan']) ?>" method="post">
                			<div class="modal-content">
                				<div class="modal-header">
                					<h5 class="modal-title" id="gantipelanggan">Edit Data untuk <?= $row['nama_pelanggan'] ?></h5>
                					<button type="button" class="btn-close" data-bs-dismiss="modal"
                						aria-label="Close"></button>
                				</div>
                				<div class="modal-body">
                					<div class="mb-3">
                						<label for="nama-<?= $row['id_pelanggan'] ?>" class="form-label">Nama</label>
                						<input type="text" class="form-control" name="nama_pelanggan" value="<?= $row['nama_pelanggan'] ?>"
                							required>
                					</div>
                					<div class="mb-3">
                						<label class="form-label">Alamat</label>
                						<input type="text" class="form-control" name="alamat"
                							value="<?= $row['alamat'] ?>" required>
                					</div>
                					<div class="mb-3">
                						<label class="form-label">Telp</label>
                						<input type="number" class="form-control" name="telp"
                							value="<?= $row['telp'] ?>" required>
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

<div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('pelanggan/simpan') ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nama lengkap</label>
                            <input type="text" class="form-control" placeholder="Nama Pengguna" name="nama_pelanggan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Alamat</label>
                            <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Telp</label>
                            <input type="number" class="form-control" placeholder="Telp" name="telp" required>
                        </div>
                    </div>
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


setTimeout(function() {
    const notification = document.querySelector('.alert'); 
    if (notification) {
        notification.style.display = 'none'; 
    }
}, 5000); 
</script>
