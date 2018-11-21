<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->model('model_sesi');
		$this->model_sesi->getsesi();
		$Email_Volunteer = $this->session->userdata('Email_Volunteer');
		$isi['username'] = $this->db->query("SELECT Username FROM user WHERE Email_Volunteer='$Email_Volunteer' ");
		$isi['regional'] = $this->db->query("SELECT nama_kota FROM kategori_regional WHERE id_regional=(SELECT id_regional FROM user WHERE Email_Volunteer='$Email_Volunteer') ");

		$this->load->view('tampilan_dashboard', $isi);
	}


public function ganti_password()
    {
        $Email_Volunteer = $this->session->userdata['Email_Volunteer'];


        $this->form_validation->set_rules('pw_baru','password baru','required');
        $this->form_validation->set_rules('cpw_baru','password kedua','required|matches[pw_baru]');

        $this->form_validation->set_message('required','%s wajib diisi');

        $this->form_validation->set_error_delimiters('<p class="alert">','</p>');

        if( $this->form_validation->run() == FALSE ){
            $this->load->view('tampilan_dashboard');
        } else {
            $post = $this->input->post();
            
            $data = array(
                'password' => md5($post['pw_baru']),
            );

            $this->load->model('model_dashboard');
            $this->model_dashboard->update($Email_Volunteer, $data, 'user');

        }



}
}