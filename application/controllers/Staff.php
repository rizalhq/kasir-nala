<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('level')==NULL){
            redirect('auth');
        }
        if($this->session->userdata('level')=='kasir'){
            redirect('auth');
        }
        $this->load->library('form_validation');
    }
    
	public function index(){
        $this->db->select('*')->from('staff');
        $this->db->order_by('id_staff', 'ASC');
        $staff = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Nala > Staff',	
            'staff'         => $staff
		);
		$this->template->load('template', 'staff/staff_index', $data);
	}

    public function simpan(){
        $this->db->from('staff')->where('username', $this->input->post('username'));
        $cek = $this->db->get()->result_array();
        if($cek == NULL){
            $data = array(
                'username'  => $this->input->post('username'),
                'password'  => md5($this->input->post('password')),
                'level'     => $this->input->post('level'),
            );
            $this->db->insert('staff', $data);  
            $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">Staff berhasil ditambahkan!</div>
            ');
        } else {
            $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-danger" role="alert">Staff sudah ada!</div>
            ');
        }
        redirect('staff');
    }

    public function hapus($id_staff){
        $where = array('id_staff' => $id_staff);
        $this->db->delete('staff', $where);
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-danger" role="alert">Staff terhapus!</div>
        ');
        redirect('staff');
    }
    public function update($id_staff){
        $staff_lama = $this->db->get_where('staff', ['id_staff' => $id_staff])->row();
    
        if ($staff_lama->nama != $this->input->post('username')) {
            $this->db->from('staff')->where('username', $this->input->post('username'));
            $cek = $this->db->get()->result_array();
            if ($cek != NULL) {
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-danger" role="alert">staff sudah ada!</div>
                ');
                redirect('staff');
                return; 
            }
        }
        $data = array(
            'username' => $this->input->post('username'),
            'level' => $this->input->post('level'),
        );
        $where = array('id_staff' => $id_staff);
    
        $this->db->update('staff', $data, $where);
        $this->session->set_flashdata('notifikasi', '
            <div class="alert alert-success" role="alert">Staff berhasil diperbarui!</div>
        ');
        redirect('staff');
    }
    public function ganti_password($id_staff){
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Password harus minimal 5 karakter!</div>
            ');
            redirect('staff');
        } else {
            $data = array(
                'password' => md5($this->input->post('password_baru')),
            );
            $where = array('id_staff' => $id_staff);
            $this->db->update('staff', $data, $where);
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-success" role="alert">Password berhasil diubah!</div>
            ');
            redirect('staff');
        }
    }
}
