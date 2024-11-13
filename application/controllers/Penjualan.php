<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if($this->session->userdata('level')==NULL){
            redirect('auth');
        }
    }
    public function index() {
        // Mendapatkan tanggal hari ini
        $today = date('Y-m-d');
    
        // Mengambil data semua penjualan tanpa filter tanggal, dengan join ke pelanggan dan pembayaran
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'penjualan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->join('pembayaran', 'penjualan.id_penjualan = pembayaran.id_penjualan', 'left');
        $this->db->order_by('penjualan.id_pelanggan', 'DESC');
        $penjualan = $this->db->get()->result_array();
    
        // Mengambil data pelanggan
        $this->db->select('*')->from('pelanggan');
        $this->db->order_by('id_pelanggan', 'ASC');
        $pelanggan = $this->db->get()->result_array();
    
        // Hitung pemasukan hari ini (total uang muka + uang dibayar)
        $this->db->select('SUM(uang_muka + uang_dibayar) as total_pemasukan');
        $this->db->from('pembayaran');
        $this->db->join('penjualan', 'pembayaran.id_penjualan = penjualan.id_penjualan', 'left');
        $this->db->where('penjualan.tanggal_penjualan', $today);
        $pemasukan = $this->db->get()->row()->total_pemasukan ?? 0;
    
        // Hitung pengeluaran hari ini (total harga pengeluaran)
        $this->db->select('SUM(harga_pengeluaran) as total_pengeluaran');
        $this->db->from('pengeluaran');
        $this->db->where('tanggal_pengeluaran', $today);
        $pengeluaran = $this->db->get()->row()->total_pengeluaran ?? 0;
    
        // Hitung hutang hari ini (total jumlah kurang)
        $this->db->select('SUM(jumlah_kurang) as total_hutang');
        $this->db->from('pembayaran');
        $this->db->join('penjualan', 'pembayaran.id_penjualan = penjualan.id_penjualan', 'left');
        $this->db->where('penjualan.tanggal_penjualan', $today);
        $hutang = $this->db->get()->row()->total_hutang ?? 0;
    
        $data = array(
            'judul_halaman' => 'Nala > Penjualan',
            'penjualan'     => $penjualan,
            'pelanggan'     => $pelanggan,
            'pemasukan'     => $pemasukan,
            'pengeluaran'   => $pengeluaran,
            'hutang'        => $hutang,
        );
    
        $this->template->load('template', 'penjualan/penjualan_index', $data);
    }
    
    public function laporan() {
        $tanggal1 = $this->input->get('tanggal1');
        $tanggal2 = $this->input->get('tanggal2');
        
        $this->db->from('penjualan a');
        $this->db->join('pelanggan b','a.id_pelanggan=b.id_pelanggan','left');
        $this->db->order_by('a.tanggal_penjualan', 'DESC');
        
        if (!empty($tanggal1)) {
            $this->db->where('tanggal_penjualan >=', $tanggal1);
        }
        if (!empty($tanggal2)) {
            $this->db->where('tanggal_penjualan <=', $tanggal2);
        }
    
        $laporan = $this->db->get()->result_array();
        $data = array(
            'laporan' => $laporan,
        );
        $this->load->view('laporan/penjualan', $data);
    }
    public function transaksi($id_pelanggan) {
        // Ambil semua produk
        $this->db->from('produk');
        $this->db->order_by('id_produk', 'ASC');
        $produk = $this->db->get()->result_array();
    
        // Set zona waktu dan ambil total penjualan bulan ini
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date('Y-m');
        $this->db->from('penjualan');
        $this->db->where("DATE_FORMAT(tanggal_penjualan,'%Y-%m')", $tanggal);
        $total_penjualan = $this->db->count_all_results();
    
        // Ambil nama pelanggan
        $this->db->from('pelanggan')->where('id_pelanggan', $id_pelanggan);
        $namapelanggan = $this->db->get()->row()->nama_pelanggan;
    
        // Cek apakah kode_penjualan yang sudah dibayar sudah ada
        $this->db->from('penjualan');
        $this->db->join('detail_penjualan', 'penjualan.kode_penjualan = detail_penjualan.kode_penjualan', 'left');
        $this->db->where('detail_penjualan.id_pelanggan', $id_pelanggan);
        $this->db->where('detail_penjualan.status_pembayaran', 'sudah'); // status pembayaran sudah dibayar
        $kode_penjualan_dibayar = $this->db->get()->row(); // Ambil data kode_penjualan yang sudah dibayar
    
        if ($kode_penjualan_dibayar) {
            // Jika kode penjualan sudah dibayar, tampilkan pesan atau nonaktifkan input
            $kode_penjualan_status = 'Kode penjualan ini sudah dibayar, tidak bisa digunakan lagi!';
        } else {
            $kode_penjualan_status = '';
        }
    
        // Ambil kode_penjualan terbaru yang belum dibayar untuk pelanggan ini
        $this->db->select('kode_penjualan');
        $this->db->from('detail_penjualan');
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->where('status_pembayaran', 'belum'); // Hanya yang belum dibayar
        $this->db->order_by('id_detail', 'DESC');
        $kode_penjualan_belum_dibayar = $this->db->get()->row()->kode_penjualan ?? null;
    
        // Ambil detail produk dalam keranjang yang belum dibayar oleh pelanggan
        $this->db->from('detail_penjualan a');
        $this->db->join('produk b', 'a.id_produk = b.id_produk', 'left');
        $this->db->where('a.id_pelanggan', $id_pelanggan);
        $this->db->where('a.status_pembayaran', 'belum'); // Hanya ambil item dengan status belum dibayar
        $detail = $this->db->get()->result_array();
    
        // Kirim data ke view
        $data = array(
            'judul_halaman' => 'Nala > Transaksi Penjualan',
            'total_penjualan' => $total_penjualan,
            'id_pelanggan' => $id_pelanggan,
            'namapelanggan' => $namapelanggan,
            'detail' => $detail, // Hanya item belum dibayar yang ditampilkan di keranjang
            'produk' => $produk,
            'kode_penjualan_status' => $kode_penjualan_status, // Status untuk kode penjualan yang sudah dibayar
            'kode_penjualan_belum_dibayar' => $kode_penjualan_belum_dibayar, // Kode penjualan yang belum dibayar
        );
    
        $this->template->load('template', 'penjualan/penjualan_transaksi', $data);
    }
    
    public function tambahkeranjang() {
        // Ambil `id_produk`, `kode_penjualan`, dan `id_pelanggan` dari input
        $id_produk = $this->input->post('id_produk');
        $kode_penjualan = $this->input->post('kode_penjualan');
        $id_pelanggan = $this->input->post('id_pelanggan');
    
        // Cek apakah kode_penjualan ini sudah dibayar di tabel utama penjualan
        $this->db->from('penjualan'); // Asumsikan tabel ini menyimpan transaksi utama
        $this->db->where('kode_penjualan', $kode_penjualan);
        $this->db->where('status_pembayaran', 'sudah'); // Pastikan status pembayaran sudah dibayar (1)
        $cek_kode_sudah_dibayar = $this->db->get()->num_rows();
    
        if ($cek_kode_sudah_dibayar > 0) {
            // Jika kode_penjualan sudah dibayar, tampilkan pesan error
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Kode penjualan ini sudah dibayar dan tidak bisa digunakan lagi!</div>
            ');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }
    
        // Lanjutkan dengan pengecekan lainnya
// Cek apakah produk sudah ada dalam keranjang berdasarkan id_produk dan kode_penjualan yang sama
$this->db->from('detail_penjualan');
$this->db->where('id_produk', $id_produk);  // Gunakan id_produk untuk pengecekan, bukan deskripsi
$this->db->where('kode_penjualan', $kode_penjualan);
$cek = $this->db->get()->result_array();

if (!empty($cek)) {
    $this->session->set_flashdata('notifikasi', '
        <div class="alert alert-danger" role="alert">Produk sudah dipilih dengan kode penjualan yang sama!</div>
    ');
    redirect($_SERVER['HTTP_REFERER']);
    return;
}
    
        // Ambil data produk berdasarkan id_produk
        $this->db->from('produk')->where('id_produk', $id_produk);
        $produk_data = $this->db->get()->row();
    
        if ($produk_data) {
            $stok_lama = (float) $produk_data->jumlah_barang;
        } else {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Produk tidak ditemukan!</div>
            ');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }
    
        // Konversi inputan koma menjadi titik pada `bahan_terpakai`, `panjang`, dan `lebar`
        $bahan_terpakai = (float) str_replace(',', '.', $this->input->post('jumlah_pcs') ?: $this->input->post('bahan_terpakai'));
        $panjang = (float) str_replace(',', '.', $this->input->post('panjang') ?: 0);
        $lebar = (float) str_replace(',', '.', $this->input->post('lebar') ?: 0);
    
        // Hitung stok sekarang
        $stok_sekarang = $stok_lama - $bahan_terpakai;
    
        // Data yang akan disimpan, tambahkan 'status_pembayaran' => 0
        $data = array(
            'kode_penjualan' => $kode_penjualan,
            'id_produk'      => $id_produk,
            'sub_total'      => $this->input->post('sub_total'),
            'deskripsi'      => $this->input->post('deskripsi'),
            'id_pelanggan'   => $id_pelanggan,
            'panjang'        => $panjang,
            'lebar'          => $lebar,
            'bahan_terpakai' => $bahan_terpakai,
            'status_pembayaran' => 'belum' // Set status pembayaran ke 0
        );
    
        if ($stok_lama >= $bahan_terpakai) {
            $this->db->insert('detail_penjualan', $data);
    
            $data2 = array(
                'jumlah_barang' => $stok_sekarang
            );
            $where = array(
                'id_produk' => $id_produk
            );
            $this->db->update('produk', $data2, $where);
    
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-success" role="alert">Produk berhasil ditambahkan ke keranjang!</div>
            ');
        } else {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Produk yang dipilih tidak mencukupi!</div>
            ');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    public function hapus($id_detail,$id_produk){
		$this->db->from('detail_penjualan')->where('id_detail',$id_detail);
		$jumlah = $this->db->get()->row()->bahan_terpakai;
		$this->db->from('produk')->where('id_produk',$id_produk);
		$stok_lama = $this->db->get()->row()->jumlah_barang;
		$stok_sekarang = $jumlah+$stok_lama;

		$data2 = array(
			'jumlah_barang' => $stok_sekarang
		);
		$where = array(
			'id_produk' => $id_produk
		);
		$this->db->update('produk',$data2,$where);

		$where = array('id_detail'   => $id_detail );
        $this->db->delete('detail_penjualan',$where);
        $this->session->set_flashdata('notifikasi','
            <div class="alert alert-success" role="alert">Produk berhasil dihapus dari keranjang!</div>
            ');
		redirect($_SERVER['HTTP_REFERER']);
	}
    public function batalpemesanan($kode_penjualan) {
        // Ambil data penjualan berdasarkan kode_penjualan
        $this->db->from('penjualan')->where('kode_penjualan', $kode_penjualan);
        $penjualan = $this->db->get()->row();
    
        if ($penjualan) {
            // Ambil detail penjualan yang terkait dengan kode_penjualan
            $this->db->from('detail_penjualan')->where('kode_penjualan', $kode_penjualan);
            $detail_penjualan = $this->db->get()->result();
    
            // Mengembalikan stok produk yang dibatalkan
            foreach ($detail_penjualan as $row) {
                $this->db->from('produk')->where('id_produk', $row->id_produk);
                $produk = $this->db->get()->row();
    
                if ($produk) {
                    $stok_lama = $produk->jumlah_barang;
                    $stok_sekarang = $stok_lama + $row->bahan_terpakai;
                    // Update stok produk
                    $this->db->update('produk', ['jumlah_barang' => $stok_sekarang], ['id_produk' => $row->id_produk]);
                }
            }
    
            // Hapus data terkait di tabel detail_penjualan berdasarkan kode_penjualan
            $this->db->delete('detail_penjualan', ['kode_penjualan' => $kode_penjualan]);
    
            // Hapus data pembayaran terkait di tabel pembayaran berdasarkan id_penjualan
            $this->db->delete('pembayaran', ['id_penjualan' => $penjualan->id_penjualan]);
    
            // Hapus data penjualan di tabel penjualan berdasarkan kode_penjualan
            $this->db->delete('penjualan', ['kode_penjualan' => $kode_penjualan]);
    
            // Set notifikasi sukses
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-success" role="alert">Pesanan berhasil dibatalkan!</div>
            ');
        } else {
            // Jika penjualan tidak ditemukan
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Pesanan tidak ditemukan!</div>
            ');
        }
    
        // Redirect kembali ke halaman sebelumnya
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function bayar() {
        $kode_penjualan = $this->input->post('nota'); // Ambil kode penjualan
        $id_pelanggan = $this->input->post('id_pelanggan'); // Ambil ID pelanggan
        $total_harga = $this->input->post('total'); // Ambil total harga
        $status_pembayaran = $this->input->post('status_pembayaran'); // Ambil status pembayaran
        $uang_dibayarkan = $this->input->post('uang_dibayarkan'); // Ambil uang yang dibayarkan
        $kurang = $this->input->post('kurangHidden'); // Ambil nilai kurang dari input tersembunyi
        $tanggal = date('Y-m-d'); // Ambil tanggal hari ini
    
        // Validasi total_harga
        if (empty($total_harga)) {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">
                    <strong>Error - </strong> Total harga tidak boleh kosong!
                </div>
            ');
            redirect('penjualan'); // Ganti dengan rute yang sesuai
            return;
        }
    
        // Data untuk tabel penjualan
        $data_penjualan = array(
            'kode_penjualan'   => $kode_penjualan,
            'id_pelanggan'     => $id_pelanggan,
            'total_harga'      => $total_harga,
            'tanggal_penjualan' => $tanggal
        );
    
        // Simpan data ke tabel penjualan
        $this->db->insert('penjualan', $data_penjualan);
        $id_penjualan = $this->db->insert_id(); // Ambil ID penjualan yang baru ditambahkan
    
        // Data untuk tabel pembayaran
        $data_pembayaran = array(
            'id_penjualan'      => $id_penjualan,
            'status_pembayaran' => $status_pembayaran === "lunas" ? "Lunas" : "Belum Lunas",
            'jumlah_kurang'     => ($status_pembayaran === "lunas") ? 0 : $kurang,
            'uang_muka'         => ($status_pembayaran === "hutang") ? 0 : $uang_dibayarkan, // Simpan 0 jika hutang
            'uang_dibayar'      => ($status_pembayaran === "lunas") ? $uang_dibayarkan : 0 // Simpan uang dibayarkan jika lunas, atau 0 jika hutang
        );
    
        // Simpan data ke tabel pembayaran
        $this->db->insert('pembayaran', $data_pembayaran);
    
        // Update status_pembayaran pada tabel detail_penjualan menjadi 'sudah'
        $this->db->where('kode_penjualan', $kode_penjualan);
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->update('detail_penjualan', array('status_pembayaran' => 'sudah'));
    
        // Set notifikasi
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">
                <strong>Berhasil - </strong> Penjualan berhasil!
            </div>
        '); 
    
        // Redirect ke halaman invoice
        redirect('penjualan/invoice/'.$kode_penjualan);
    }
    
     
    public function invoice($kode_penjualan){
		$this->db->select('*');
		$this->db->from('penjualan a')->order_by('a.tanggal_penjualan','DESC')->where('a.kode_penjualan',$kode_penjualan);
		$this->db->join('pelanggan b','a.id_pelanggan=b.id_pelanggan','left');
		$this->db->join('pembayaran c','a.id_penjualan=c.id_penjualan','left');
        $penjualan = $this->db->get()->row();

		$this->db->from('detail_penjualan a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.kode_penjualan',$kode_penjualan);
		$detail = $this->db->get()->result_array();

		$data = array(
			'judul_halaman' => 'Kasir | Transaksi Penjualan',	
			'nota'			=> $kode_penjualan,
			'penjualan'		=> $penjualan,
			'detail'		=> $detail,
		);
		$this->load->view('penjualan/invoice',$data);
	}
    public function struk($kode_penjualan) {
        $this->db->select('*');
		$this->db->from('penjualan a')->order_by('a.tanggal_penjualan','DESC')->where('a.kode_penjualan',$kode_penjualan);
		$this->db->join('pelanggan b','a.id_pelanggan=b.id_pelanggan','left');
		$this->db->join('pembayaran c','a.id_penjualan=c.id_penjualan','left');
        $penjualan = $this->db->get()->row();

		$this->db->from('detail_penjualan a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.kode_penjualan',$kode_penjualan);
		$detail = $this->db->get()->result_array();

		$data = array(
			'judul_halaman' => 'Kasir | Transaksi Penjualan',	
			'nota'			=> $kode_penjualan,
			'penjualan'		=> $penjualan,
			'detail'		=> $detail,
		);
        $this->load->view('penjualan/struk',$data); // Tampilkan halaman struk
    }
    public function update($id_penjualan) {
        // Ambil nilai dari form
        $uang_dibayar_baru = $this->input->post('uang_dibayar'); // Inputan bayar baru
    
        // Ambil data pembayaran lama dari database berdasarkan ID penjualan
        $pembayaran = $this->db->get_where('pembayaran', ['id_penjualan' => $id_penjualan])->row();
    
        // Hitung total uang dibayar dan kekurangan baru
        $total_uang_dibayar = $pembayaran->uang_dibayar + $uang_dibayar_baru;
        $jumlah_kurang_baru = $pembayaran->jumlah_kurang - $uang_dibayar_baru;
    
        // Jika jumlah kurang di bawah 0, set menjadi 0 dan update uang_dibayar dengan sisa kekurangan
        if ($jumlah_kurang_baru <= 0) {
            $jumlah_kurang_baru = 0;
            $total_uang_dibayar = $pembayaran->uang_dibayar + $pembayaran->jumlah_kurang;
        }
    
        // Update status pembayaran jika jumlah_kurang mencapai 0
        $status_pembayaran = ($jumlah_kurang_baru == 0) ? 'Lunas' : 'Belum Lunas';
    
        // Data yang akan diupdate pada tabel pembayaran
        $data_pembayaran = [
            'uang_dibayar' => $total_uang_dibayar,
            'jumlah_kurang' => $jumlah_kurang_baru,
            'status_pembayaran' => $status_pembayaran
        ];
    
        // Update data di tabel pembayaran
        $this->db->where('id_penjualan', $id_penjualan);
        $this->db->update('pembayaran', $data_pembayaran);
    
        // Set notifikasi sukses
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">
                <strong>Berhasil - </strong> Pembayaran berhasil diperbarui!
            </div>
        ');
    
        // Redirect kembali ke halaman penjualan atau halaman lain yang sesuai
        redirect('penjualan');
    }
    
}
