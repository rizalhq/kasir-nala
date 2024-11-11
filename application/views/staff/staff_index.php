<div class="col-12">
    <?= $this->session->flashdata('notifikasi'); ?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Tambah Staff
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
                    <th>Nama Pengguna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="tableBody">
                <?php $no=1; foreach($staff as $row){ ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['username'] ?></td>
                    <td>
                        <a onclick="return confirm('Apakah anda yakin menghapus data ini?')"
                            href="<?= base_url('staff/hapus/'.$row['id_staff']) ?>"
                            class="btn btn-danger btn-sm text-white">Hapus</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#gantiUsernameModal-<?= $row['id_staff'] ?>">
                            Edit Username
                        </button>
                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                            data-bs-target="#gantiPasswordModal-<?= $row['id_staff'] ?>">
                            Ganti Password
                        </button>
                    </td>
                </tr>

                <!-- Modal Ganti Password untuk setiap staff -->
                <div class="modal fade" id="gantiPasswordModal-<?= $row['id_staff'] ?>" tabindex="-1"
                    aria-labelledby="gantiPasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?= base_url('staff/ganti_password/' . $row['id_staff']) ?>" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gantiPasswordModalLabel">Ganti Password untuk
                                        <?= $row['username'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="password_baru-<?= $row['id_staff'] ?>" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" name="password_baru" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Password Baru</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- username edit -->
                <div class="modal fade" id="gantiUsernameModal-<?= $row['id_staff'] ?>" tabindex="-1"
                    aria-labelledby="gantiUsernameModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?= base_url('staff/update/' . $row['id_staff']) ?>" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gantiUsernameModalLabel">Ganti Username untuk
                                        <?= $row['username'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="username-<?= $row['id_staff'] ?>" class="form-label">Username Baru</label>
                                        <input type="text" class="form-control" name="username" value="<?= $row['username'] ?>" required>
                                        <input type="hidden" name="level" value="staff">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Username Baru</button>
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

    function filterTable() {
        const filter = document.getElementById('searchInput').value.toLowerCase();
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.getElementsByTagName('tr');
        
        // Filter rows based on the search input
        for (let i = 0; i < rows.length; i++) {
            const usernameCell = rows[i].getElementsByTagName('td')[1];
            if (usernameCell) {
                const usernameText = usernameCell.textContent || usernameCell.innerText;
                rows[i].style.display = usernameText.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    
        // Re-render table to apply pagination after filtering
        renderTable();
    }
    
    // Initial render
    renderTable();
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
        const usernameCell = row.cells[1];
        const rowText = usernameCell.textContent.toLowerCase();

        row.style.display = rowText.includes(filter) ? '' : 'none';
    });
});

setTimeout(function() {
    const notification = document.querySelector('.alert'); 
    if (notification) {
        notification.style.display = 'none'; 
    }
}, 5000); 
</script>

<div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('staff/simpan') ?>" method="post" onsubmit="return validatePassword()">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" placeholder="Nama Pengguna" name="username" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="passwordInput" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="passwordInput" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" name="password" minlength="5" required>
                            <small class="text-danger" id="passwordError" style="display: none;">Kata sandi harus minimal 5 karakter.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Level</label>
                            <select name="level" class="form-control">
                                <option value="Admin">Admin</option>
                                <option value="Kasir">Kasir</option>
                            </select>
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
function validatePassword() {
    const password = document.getElementById('passwordInput').value;
    const error = document.getElementById('passwordError');
    
    if (password.length < 5) {
        error.style.display = 'block';
        return false;
    }
    
    error.style.display = 'none';
    return true;
}
</script>