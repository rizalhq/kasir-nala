<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if($this->session->userdata('level')==NULL){
            redirect('auth');
        }
    }
	public function index(){
        $this->db->select('*')->from('pengeluaran');
        $this->db->order_by('id_pengeluaran','ASC');
        $pengeluaran = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Nala > Pengeluaran',	
            'pengeluaran'          => $pengeluaran
		);
		$this->template->load('template', 'pengeluaran/pengeluaran_index',$data);
	}
    public function simpan(){
        $this->db->from('pengeluaran')->where('keterangan_pengeluaran', $this->input->post('keterangan_pengeluaran'));
        $cek = $this->db->get()->result_array();
    
        if ($cek == NULL) {
            $data = array(
                'keterangan_pengeluaran' => $this->input->post('keterangan_pengeluaran'),
                'harga_pengeluaran' => $this->input->post('harga_pengeluaran'),
                'tanggal_pengeluaran' => $this->input->post('tanggal_pengeluaran')  // Menyimpan tanggal pengeluaran
            );
    
            $this->db->insert('pengeluaran', $data);  
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-success" role="alert">Pengeluaran berhasil ditambahkan!</div>
            ');
        } else {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Pengeluaran sudah ada!</div>
            ');
        }
    
        redirect('pengeluaran');
    }
    
    public function update($id_pengeluaran){
        $pengeluaran_lama = $this->db->get_where('pengeluaran', ['id_pengeluaran' => $id_pengeluaran])->row();
        
        if ($pengeluaran_lama->keterangan_pengeluaran != $this->input->post('keterangan_pengeluaran')) {
            $this->db->from('pengeluaran')->where('keterangan_pengeluaran', $this->input->post('keterangan_pengeluaran'));
            $cek = $this->db->get()->result_array();
            if ($cek != NULL) {
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-danger" role="alert">Pengeluaran sudah ada!</div>
                ');
                redirect('pengeluaran');
                return; 
            }
        }
        $data = array(
            'keterangan_pengeluaran' => $this->input->post('keterangan_pengeluaran'),
            'harga_pengeluaran' => $this->input->post('harga_pengeluaran'),
        );
        $where = array('id_pengeluaran' => $id_pengeluaran);
    
        $this->db->update('pengeluaran', $data, $where);
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">Pengeluaran berhasil diperbarui!</div>
        ');
        redirect('pengeluaran');
    }
    public function hapus($id_pengeluaran){
        $where = array('id_pengeluaran'   => $id_pengeluaran );
        $this->db->delete('pengeluaran',$where);
        $this->session->set_flashdata('notifikasi','
            <div class="alert alert-danger" role="alert">Pengeluaran berhasil dihapus!</div>
            ');
        redirect('pengeluaran');
    }
    public function laporan() {
        $tanggal1 = $this->input->get('tanggal1');
        $tanggal2 = $this->input->get('tanggal2');
        
        $this->db->from('pengeluaran a');
        $this->db->order_by('a.tanggal_pengeluaran', 'DESC');
        
        if (!empty($tanggal1)) {
            $this->db->where('tanggal_pengeluaran >=', $tanggal1);
        }
        if (!empty($tanggal2)) {
            $this->db->where('tanggal_pengeluaran <=', $tanggal2);
        }
    
        $laporan = $this->db->get()->result_array();
        $data = array(
            'laporan' => $laporan,
        );
        $this->load->view('laporan/pengeluaran', $data);
    }
}