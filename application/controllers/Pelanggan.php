<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if($this->session->userdata('level')==NULL){
            redirect('auth');
        }
    }
	public function index(){
        $this->db->select('*')->from('pelanggan');
        $this->db->order_by('id_pelanggan','ASC');
        $pelanggan = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Nala > Pelanggan',	
            'pelanggan'          => $pelanggan
		);
		$this->template->load('template', 'pelanggan/pelanggan_index',$data);
	}
    public function simpan(){
        $this->db->from('pelanggan')->where('nama_pelanggan',$this->input->post('nama_pelanggan'));
        $cek = $this->db->get()->result_array();
        if($cek==NULL){
            $data = array(
                'nama_pelanggan'      => $this->input->post('nama_pelanggan'),
                'alamat'    => $this->input->post('alamat'),
                'telp'      => $this->input->post('telp'),
            );
            $this->db->insert('pelanggan',$data);  
            $this->session->set_flashdata('notifikasi','
            <div class="alert alert-success" role="alert">Pelanggan berhasil ditambahkan!</div>
            '); 
        } else {
            $this->session->set_flashdata('notifikasi','
            <div class="alert alert-danger" role="alert">Pelanggan sudah ada!</div>
            ');
        }
        redirect('pelanggan');
    }
    public function hapus($id_pelanggan){
        $where = array('id_pelanggan'   => $id_pelanggan );
        $this->db->delete('pelanggan',$where);
        $this->session->set_flashdata('notifikasi','
            <div class="alert alert-danger" role="alert">Pelanggan berhasil dihapus!</div>
            ');
        redirect('pelanggan');
    }
    public function update($id_pelanggan){
        $pelanggan_lama = $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
    
        if ($pelanggan_lama->nama_pelanggan != $this->input->post('nama_pelanggan')) {
            $this->db->from('pelanggan')->where('nama_pelanggan', $this->input->post('nama_pelanggan'));
            $cek = $this->db->get()->result_array();
            if ($cek != NULL) {
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-danger" role="alert">pelanggan sudah ada!</div>
                ');
                redirect('pelanggan');
                return; 
            }
        }
        $data = array(
            'nama_pelanggan' => $this->input->post('nama_pelanggan'),
            'alamat' => $this->input->post('alamat'),
            'telp' => $this->input->post('telp'),
        );
        $where = array('id_pelanggan' => $id_pelanggan);
    
        $this->db->update('pelanggan', $data, $where);
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">Pelanggan berhasil diperbarui!</div>
        ');
        redirect('pelanggan');
    }
}
