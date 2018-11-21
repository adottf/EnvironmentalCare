<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller {

	public function index()
	{
		$this->load->view('tampilan_daftar');
	}

	public function simpan()
	{
	    
		$key = $this->input->post('Email_Volunteer');
		$email = $this->input->post('Email_Volunteer');
		$data['Email_Volunteer']		= $this->input->post('Email_Volunteer');
		$saltid   = md5($this->input->post('Email_Volunteer'));
		$status   = 1;
		$data['status']	= $status;
		$data['Nama_Lengkap']			= $this->input->post('Nama_Lengkap');
		$data['Username']			= $this->input->post('Username');
		$data['No_Hp']		= $this->input->post('No_Hp');
		$data['Instansi']	= $this->input->post('Instansi');
		$data['id_regional']	= $this->input->post('pilihanregional');
		$data['Password']			= md5($this->input->post('Password'));


		$this->load->model('model_daftar');
		$query = $this->model_daftar->getdata($key);
		$cek1=$this->model_daftar->checkEmail($key);
		$cek2=$this->model_daftar->cekmail($key);
		if($cek1 == false)
		{
			echo "<script>window.alert('Email anda invalid')</script>";
			echo "<meta http-equiv='refresh' content='0;url=http://localhost/ecare/daftar'>";

		}
			else
		{
			if ($cek2 == false) {
				echo "<script>window.alert('Email Sudah Terdaftar')</script>";
				echo "<meta http-equiv='refresh' content='0;url=http://localhost/ecare/daftar'>";
				# code...
			}
			else
			{
			$this->model_daftar->getinsert($data);
			$this->sendemail($email, $saltid);
			echo "<script>window.alert('Berhasil Daftar!',refresh)</script>";

			}
		}
	}

	function sendemail($email,$saltid){
    // configure the email setting
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.gmail.com'; //smtp host name
    $config['smtp_port'] = '465'; //smtp port number
    $config['smtp_user'] = 'vinyversid@gmail.com';
    $config['smtp_pass'] = 'aditya23#'; //$from_email password
    $config['mailtype'] = 'html';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['newline'] = "\r\n"; //use double quotes
    $this->email->initialize($config);
    $url = base_url()."daftar/confirmation/".$saltid;
    $this->email->from('vinyversid@gmail.com', 'VERIFIKASI EMAIL REGISTRASI');
    $this->email->to($email);
    $this->email->subject('Verifikasi Email Pendaftaran');
    $message = "<html><head><head></head><body><p>Hi,</p><p>Terimakasih telah mendaftar.</p><p>ikuti tautan berikut untuk konfirmasi email.</p><a href=".$url."><b>VERIFIKASI</b></a><br/><p>Hormat,</p><p>Administrator E-Care</p></body></html>";
    $this->email->message($message);
    return $this->email->send();
  }

	public function confirmation($kunci)
  {
    if($this->user_model->verifyemail($kunci))
    {
      echo "<meta http-equiv='refresh' content='0;url=http://localhost/ecare/Berhasil_verifikasi/'>";
    }
    else
    {
      $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Email Gagal diverifikasi. Coba lagi nanti...</div>');
      redirect(base_url());
    }
  }

}