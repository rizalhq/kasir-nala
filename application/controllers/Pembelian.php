<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if($this->session->userdata('level')==NULL){
            redirect('auth');
        }
    }
	public function index(){
        $this->db->from('pembelian');
        $this->db->join('stok', 'pembelian.id_stok = stok.id_stok', 'left');
        $this->db->order_by('pembelian.id_pembelian', 'ASC');
        $pembelian = $this->db->get()->result_array();
        $this->db->select('*')->from('stok');
        $this->db->order_by('id_stok','ASC');
        $stok = $this->db->get()->result_array();
        $data = array(
            'judul_halaman' => 'Nala > Pembelian',
            'pembelian'     => $pembelian,
            'stok'     => $stok,
        );
        $this->template->load('template', 'pembelian/pembelian_index', $data);
    }
    
    public function simpan() {
        $id_stok = $this->input->post('nama');
        $jumlah = $this->input->post('jumlah');
        $data = array(
            'id_stok' => $id_stok,
            'tanggal'   => date('Y-m-d'),
            'jumlah'    => $jumlah,
            'harga_beli' => $this->input->post('harga_beli'),
        );
    
        $this->db->insert('pembelian', $data);

        $this->db->set('jumlah_barang', 'jumlah_barang + ' . (int)$jumlah, FALSE);
        $this->db->where('id_stok', $id_stok);
        $this->db->update('stok');
    
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">Pembelian berhasil ditambahkan!</div>
        ');
        redirect('pembelian');
    }
    public function laporan() {
        $tanggal1 = $this->input->get('tanggal1');
        $tanggal2 = $this->input->get('tanggal2');
        $id_stok = $this->input->get('nama');
        
        $this->db->from('pembelian a');
        $this->db->join('stok b', 'a.id_stok = b.id_stok', 'left');
        $this->db->order_by('a.tanggal', 'DESC');
        
        if (!empty($tanggal1)) {
            $this->db->where('a.tanggal >=', $tanggal1);
        }
        if (!empty($tanggal2)) {
            $this->db->where('a.tanggal <=', $tanggal2);
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
