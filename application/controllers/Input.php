<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {

	public function index()
	{
		$this->load->model('model_sesi');
		$this->model_sesi->getsesi();
		$Email_Volunteer = $this->session->userdata('Email_Volunteer');
		$isi['username'] = $this->db->query("SELECT Username FROM user WHERE Email_Volunteer='$Email_Volunteer' ");
		$isi['regional'] = $this->db->query("SELECT nama_kota FROM kategori_regional WHERE id_regional=(SELECT id_regional FROM user WHERE Email_Volunteer='$Email_Volunteer') ");

		$this->load->view('tampilan_input', $isi);
	}

	public function simpan(){
		$key = $this->input->post('Email_Volunteer');
		$data['Email_Volunteer']	= $this->session->userdata('Email_Volunteer');
		$data['Id_laporan']			= $this->input->post('Id_laporan');
		$data['id_sampah']			= $this->input->post('id_sampah');
		$data['Jumlah']				= $this->input->post('Jumlah');

		$this->load->model('model_input');
		$query = $this->model_input->getdata($key);
		$this->model_input->getinsert($data);
		echo "<script>window.alert('Data Berhasil Di Input!')</script>";

	}


}