<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('level') == NULL){
            redirect('auth');
        }
        if($this->session->userdata('level') == 'kasir'){
            redirect('auth');
        }
    }
	public function index() {
		// Hitung pemasukan (total uang muka + uang dibayar)
		$this->db->select('SUM(uang_muka + uang_dibayar) as total_pemasukan');
		$this->db->from('pembayaran');
		$pemasukan = $this->db->get()->row()->total_pemasukan ?? 0;
	
		// Hitung pengeluaran (total harga_beli dari stok + total harga_pengeluaran dari pengeluaran)
		$this->db->select('SUM(harga_beli) as total_harga_beli');
		$this->db->from('stok');
		$total_harga_beli = $this->db->get()->row()->total_harga_beli ?? 0;
	
		$this->db->select('SUM(harga_pengeluaran) as total_harga_pengeluaran');
		$this->db->from('pengeluaran');
		$total_harga_pengeluaran = $this->db->get()->row()->total_harga_pengeluaran ?? 0;
	
		// Total pengeluaran adalah jumlah dari harga_beli dan harga_pengeluaran
		$pengeluaran = $total_harga_beli + $total_harga_pengeluaran;
	
		// Hitung hutang (total jumlah kurang)
		$this->db->select('SUM(jumlah_kurang) as total_hutang');
		$this->db->from('pembayaran');
		$hutang = $this->db->get()->row()->total_hutang ?? 0;
	
		// Ambil data piutang dengan urutan: `uang_dibayar = 0` di atas, lalu status pembayaran, lalu tanggal penjualan
		$this->db->select('*');
		$this->db->from('penjualan a');
		$this->db->join('pelanggan b', 'a.id_pelanggan = b.id_pelanggan', 'left');
		$this->db->join('pembayaran c', 'a.id_penjualan = c.id_penjualan', 'left');
		// Mengurutkan: `uang_dibayar = 0` di atas, lalu 'belum lunas' di atas 'lunas', terakhir tanggal penjualan
		$this->db->order_by("CASE WHEN c.uang_dibayar = 0 THEN 0 ELSE 1 END ASC", '', false);
		$this->db->order_by("FIELD(c.status_pembayaran, 'belum lunas', 'lunas') ASC, a.tanggal_penjualan ASC");
		$piutang = $this->db->get()->result_array();
	
		// Ambil data stok
		$this->db->select('*');
		$this->db->from('stok');
		$stok = $this->db->get()->result_array();
	
		// Data yang dikirim ke view
		$data = array(
			'judul_halaman' => 'Nala > Dashboard',
			'pemasukan' => $pemasukan,
			'pengeluaran' => $pengeluaran,
			'hutang' => $hutang,
			'piutang' => $piutang,
			'stok' => $stok,
		);
		$this->template->load('template', 'dashboard', $data);
	}	
	public function laporan() {
        $tanggal1 = $this->input->get('tanggal1');
        $tanggal2 = $this->input->get('tanggal2');
        $status_pembayaran = $this->input->get('status_pembayaran');
        
        $this->db->from('pembayaran a');
        $this->db->join('penjualan b', 'a.id_penjualan = b.id_penjualan', 'left');
        $this->db->join('pelanggan c', 'b.id_pelanggan = c.id_pelanggan', 'left');
        $this->db->order_by('b.tanggal_penjualan', 'DESC');
        
        if (!empty($tanggal1)) {
            $this->db->where('b.tanggal_penjualan >=', $tanggal1);
        }
        if (!empty($tanggal2)) {
            $this->db->where('b.tanggal_penjualan <=', $tanggal2);
        }
        if (!empty($status_pembayaran) && $status_pembayaran != 'all') {
            $this->db->where('a.status_pembayaran', $status_pembayaran);
        }
    
        $laporan = $this->db->get()->result_array();
        $data = array(
            'laporan' => $laporan,
        );
        $this->load->view('laporan/piutang', $data);
    }    
}
