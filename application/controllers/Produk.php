<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if($this->session->userdata('level')==NULL){
            redirect('auth');
        }
    }
	public function index(){
        $this->db->select('*')->from('produk');
        $this->db->order_by('id_produk','ASC');
        $produk = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Nala > Produk',	
            'produk'          => $produk
		);
		$this->template->load('template', 'produk/produk_index',$data);
	}
    public function simpan(){
        $this->db->from('produk')->where('nama_produk',$this->input->post('nama_produk'));
        $cek = $this->db->get()->result_array();
        if($cek==NULL){
            $data = array(
                'nama_produk'          => $this->input->post('nama_produk'),
            );
            $this->db->insert('produk',$data);  
            $this->session->set_flashdata('notifikasi','
            <div class="alert alert-success" role="alert">Produk berhasil ditambahkan!</div>
            '); 
        } else {
            $this->session->set_flashdata('notifikasi','
            <div class="alert alert-danger" role="alert">Produk sudah ada!</div>
            ');
        }
        redirect('produk');
    }
    public function update($id_produk){
        $produk_lama = $this->db->get_where('produk', ['id_produk' => $id_produk])->row();
        
        if ($produk_lama->nama_produk != $this->input->post('nama_produk')) {
            $this->db->from('produk')->where('nama_produk', $this->input->post('nama_produk'));
            $cek = $this->db->get()->result_array();
            if ($cek != NULL) {
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-danger" role="alert">Produk sudah ada!</div>
                ');
                redirect('produk');
                return; 
            }
        }
        $data = array(
            'nama_produk' => $this->input->post('nama_produk'),
        );
        $where = array('id_produk' => $id_produk);
    
        $this->db->update('produk', $data, $where);
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">Produk berhasil diperbarui!</div>
        ');
        redirect('produk');
    }
    public function hapus($id_produk){
        $where = array('id_produk'   => $id_produk );
        $this->db->delete('produk',$where);
        $this->session->set_flashdata('notifikasi','
            <div class="alert alert-danger" role="alert">Produk berhasil dihapus!</div>
            ');
        redirect('produk');
    }
}