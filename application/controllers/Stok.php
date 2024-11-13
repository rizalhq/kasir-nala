<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if($this->session->userdata('level')==NULL){
            redirect('auth');
        }
        if($this->session->userdata('level')=='kasir'){
            redirect('auth');
        }
    }
    public function index() {
        // Melakukan join antara tabel stok dan produk
        $this->db->select('*'); // Menyertakan kolom dari kedua tabel
        $this->db->from('stok');
        $this->db->join('produk', 'stok.id_produk = produk.id_produk', 'left'); // Menggabungkan tabel stok dan produk
        $this->db->order_by('stok.id_stok', 'ASC'); // Mengurutkan berdasarkan id_stok
        $stok = $this->db->get()->result_array();
        $this->db->from('produk');
        $this->db->order_by('nama_produk', 'ASC');
        $produk = $this->db->get()->result_array();
        // Data yang akan dikirim ke view
        $data = array(
            'judul_halaman' => 'Nala > Stok',    
            'stok'          => $stok,
            'produk'          => $produk,
        );
    
        // Memuat template dengan data yang diambil
        $this->template->load('template', 'stok/stok_index', $data);
    }
    
    public function simpan(){
        // Ambil id_produk dari input form
        $id_produk = $this->input->post('id_produk');
        // Cek apakah produk ada di tabel produk untuk mendapatkan data produk
        $this->db->from('produk')->where('id_produk', $id_produk);
        $produk = $this->db->get()->row_array(); // Gunakan row_array() untuk mendapatkan satu baris data
    
        if ($produk == NULL) {
            // Jika produk tidak ditemukan di tabel produk, tampilkan pesan error
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Produk tidak ditemukan di daftar produk utama!</div>
            ');
        } else {
            // Pastikan bahwa nilai stok dari database adalah integer
            $currentQuantity = (int) $produk['jumlah_barang'];
            $additionalQuantity = (int) $this->input->post('jumlah_stok');
    
            // Hitung jumlah stok baru
            $newQuantity = $currentQuantity + $additionalQuantity;
    
            // Update jumlah_barang di tabel produk
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk', ['jumlah_barang' => $newQuantity]);
    
            // Tambahkan log entri ke tabel stok sebagai catatan tambahan
            $stokData = array(
                'jumlah_stok' => $additionalQuantity,
                'id_produk'   => $id_produk,
                'harga_beli'   => $this->input->post('harga_beli'),
                'tanggal_pembelian'   => $this->input->post('tanggal_pembelian'),
            );
            $this->db->insert('stok', $stokData);  
    
            // Beri notifikasi bahwa stok berhasil diperbarui
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-success" role="alert">Stok produk berhasil diperbarui!</div>
            ');
        }
    
        redirect('stok');
    }
    
    public function update($id_stok) {
        // Ambil data stok lama
        $stok_lama = $this->db->get_where('stok', ['id_stok' => $id_stok])->row();
    
        // Ambil id_produk dari data stok lama
        $id_produk = $stok_lama->id_produk; // Ambil id_produk dari stok yang ingin diupdate
    
        // Cek jika id_produk tidak ada
        if (empty($id_produk)) {
            $this->session->set_flashdata('notifikasi', '<div class="alert alert-danger" role="alert">ID Produk tidak ditemukan!</div>');
            redirect('stok');
            return;
        }
    
        // Ambil jumlah baru dari input
        $jumlah_baru = (int)$this->input->post('jumlah_barang');
    
        $produk_lama = $this->db->get_where('produk', ['id_produk' => $id_produk])->row();
        if (!$produk_lama) {
            $this->session->set_flashdata('notifikasi', '<div class="alert alert-danger" role="alert">Produk tidak ditemukan!</div>');
            redirect('stok');
            return;
        }
    
        // Hitung jumlah baru untuk produk
        $jumlah_produk_lama = (int)$produk_lama->jumlah_barang; // Gunakan jumlah_barang dari tabel produk
        $jumlah_produk_baru = $jumlah_produk_lama + ($jumlah_baru - (int)$stok_lama->jumlah_stok); // Ganti dengan jumlah_stok
    
        // Update jumlah_barang di tabel produk
        $this->db->update('produk', ['jumlah_barang' => $jumlah_produk_baru], ['id_produk' => $id_produk]);
    
        // Update data stok
        $data = [
            'jumlah_stok' => $jumlah_baru, // Ganti dengan jumlah_stok
            'harga_beli'   => $this->input->post('harga_beli'),
            'tanggal_pembelian'   => $this->input->post('tanggal_pembelian'),
        ];
        $this->db->update('stok', $data, ['id_stok' => $id_stok]);
    
        $this->session->set_flashdata('notifikasi', '<div class="alert alert-success" role="alert">Stok berhasil diperbarui!</div>');
        redirect('stok');
    }
    public function hapus($id_stok){
        $where = array('id_stok'   => $id_stok );
        $this->db->delete('stok',$where);
        $this->session->set_flashdata('notifikasi','
            <div class="alert alert-danger" role="alert">Stok berhasil dihapus!</div>
            ');
        redirect('stok');
    }
    public function laporan() {
        $tanggal1 = $this->input->get('tanggal1');
        $tanggal2 = $this->input->get('tanggal2');
        $id_stok = $this->input->get('nama');
        
        $this->db->from('stok a');
        $this->db->join('produk b', 'a.id_produk = b.id_produk', 'left');
        $this->db->order_by('a.tanggal_pembelian', 'DESC');
        
        if (!empty($tanggal1)) {
            $this->db->where('a.tanggal_pembelian >=', $tanggal1);
        }
        if (!empty($tanggal2)) {
            $this->db->where('a.tanggal_pembelian <=', $tanggal2);
        }
        if (!empty($id_stok) && $id_stok != 'all') {
            $this->db->where('b.id_stok', $id_stok);
        }
    
        $laporan = $this->db->get()->result_array();
        $data = array(
            'laporan' => $laporan,
        );
        $this->load->view('laporan/pembelian', $data);
    }    
}