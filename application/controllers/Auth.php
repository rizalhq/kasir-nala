<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct(){
        parent::__construct();
    }
	public function index(){
		$data = array(
			'judul_halaman' => 'Kasir | Login',	
		);
		$this->load->view('login',$data);
	}
    public function login(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $this->db->from('staff')->where('username', $username);
        $cek = $this->db->get()->row(); 
    
        if ($cek == NULL) {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Staff tidak ada!</div>
            '); 
            redirect('auth');
        } else if ($cek->password == $password) {
            $data = array(
                'id_user' => $cek->id_user,
                'username' => $cek->username,
                'level' => $cek->level,
                'nama' => $cek->nama,
            );
            $this->session->set_userdata($data);
    
            // Pengecekan level untuk redirect
            if ($cek->level == 'admin') {
                redirect('home');
            } else if ($cek->level == 'kasir') {
                redirect('penjualan');
            } else {
                // Tambahkan logika untuk level lainnya jika diperlukan
                redirect('auth'); // atau halaman lain yang sesuai
            }
        } else {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger" role="alert">Password salah!</div>
            '); 
            redirect('auth');
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}
